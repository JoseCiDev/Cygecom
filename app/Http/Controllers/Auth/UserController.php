<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Providers\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{StoreAbilitiesRequest, StoreUserRequest, UpdateUserRequest};
use App\Models\{Ability, Company, User};
use App\Services\{UserProfileService, AbilityService};
use App\Enums\MainProfile;

class UserController extends Controller
{
    use RegistersUsers;

    /**
     * The URI that users should be redirected to.
     *
     * @var string
     */
    protected $redirect = '/users';

    public function __construct(
        private UserService $userService,
        private UserProfileService $userProfileService,
        private AbilityService $abilityService,
    ) {
    }

    /**
     * Display a listing of the users.
     *
     * @return View
     */
    public function index(): View
    {
        $loggedId = auth()->user()->id;
        $isAdmin = Gate::allows('admin');

        $abilities = Ability::with('users', 'profiles')->get();
        $groupedAbilities = $abilities->groupBy(function ($ability) {
            $name = $ability->name;
            if (str_contains($name, '.api.') && !str_contains($name, 'delete')) {
                return 'api';
            }

            $firstName = explode('.', $name)[0];
            return in_array($firstName, ['get', 'post', 'delete']) ? $firstName : 'authorize';
        });

        $profiles = $this->userProfileService->profiles()->get();
        $users = $this->userService->getUsers()->where('id', '!=', $loggedId);

        if (!$isAdmin) {
            $users->whereHas('profile', function ($query) {
                return $query->where('name', '!=', 'admin');
            });
        }

        $users = $users->get();

        $params = [
            'groupedAbilities' => $groupedAbilities,
            'profiles' => $profiles,
            'users' => $users
        ];

        return view('users.index', $params);
    }

    /**
     * Show the registration form.
     *
     * @return View
     */
    public function create(): View
    {
        $approvers = $this->userService->getApprovers('register');
        $costCenters = $this->userService->getCostCenters();
        $profiles = $this->userProfileService->profiles()->get();
        $companies = Company::select('id', 'corporate_name', 'name', 'cnpj', 'group')->get();
        $abilities = Ability::with('users', 'profiles')->get();
        $groupedAbilities = $abilities->groupBy(function ($ability) {
            $name = $ability->name;
            if (str_contains($name, '.api.') && !str_contains($name, 'delete')) {
                return 'api';
            }

            $firstName = explode('.', $name)[0];
            return in_array($firstName, ['get', 'post', 'delete']) ? $firstName : 'authorize';
        });

        $params = [
            'approvers' => $approvers,
            'costCenters' => $costCenters,
            'profiles' => $profiles,
            'companies' => $companies,
            'groupedAbilities' => $groupedAbilities,
        ];

        return view('users.store-edit', $params);
    }

    /**
     * Tela que mostra usuário e todas suas habilidades
     * @param User $user
     * @return View Tela de habilidades do usuário encontrado
     */
    public function show(User $user): View
    {
        $profileAbilities = $user->profile->abilities;
        $userAbilities = $user->abilities;
        $abilities = Ability::with('users', 'profiles')->get();

        $params = [
            'id' => $user->id,

            'name' => $user->person->name,
            'email' => $user->email,
            'phone' => $user->person->phone?->number,
            'profile' => $user->profile->name,
            'sector' => $user->person->costCenter->name,
            'company' => $user->person->costCenter->company->name,
            'cnpj' => preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $user->person->costCenter->company->cnpj),
            'approverName' => $user->approver?->person->name ?? '---',
            'approverEmail' => $user->approver?->email ?? '---',
            'isBuyer' => $user->is_buyer ? 'Autorizado' : 'Não autorizado',
            'canAssociateRequest' => $user?->can_associate_requester ? 'Autorizado' : 'Não autorizado',
            'groupedProfileAbilities' => $this->abilityService->groupAbilities($profileAbilities),
            'groupedUserAbilities' => $this->abilityService->groupAbilities($userAbilities),
            'groupedAbilities' => $this->abilityService->groupAbilities($abilities),
        ];

        return view('users.show', $params);
    }

    /**
     * Register a new user.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = $this->userService->registerUser($validated);

        $successMessage = "Usuário cadastrado com sucesso! E-mail: $user->email";

        return response()->json(['message' => $successMessage, 'id' => $user->id]);
    }

    /**
     * Show the edit user form.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        if (!Gate::allows('get.user.edit')) {
            $user = auth()->user();
        }

        $approvers = $this->userService->getApprovers('users.update', $user->id);
        $costCenters = $this->userService->getCostCenters();
        $profiles = $this->userProfileService->profiles()->get();
        $companies = Company::select('id', 'corporate_name', 'name', 'cnpj', 'group')->get();
        $abilities = Ability::with('users', 'profiles')->get();

        $params = [
            'user' => $user,
            'approvers' => $approvers,
            'costCenters' => $costCenters,
            'profiles' => $profiles,
            'companies' => $companies,
            'groupedAbilities' => $this->abilityService->groupAbilities($abilities)
        ];

        return view('users.store-edit', $params);
    }

    /**
     * Update a user's information.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $id = $user->id;
        $isAdmin = Gate::allows('admin');
        $isGestorUsuarios = Gate::allows('gestor_usuarios');
        $isOwnId = $id === auth()->user()->id;
        $userToUpdateIsAdmin = MainProfile::ADMIN->value === $user->profile->name;

        // Para atualizar outro usuário deve ser admin ou gestor || Apenas admin atualizar admin
        if (((!$isAdmin && !$isGestorUsuarios) && !$isOwnId) || ($userToUpdateIsAdmin && !$isAdmin)) {
            return response()->json(['message' => 'Você não tem permissão para realizar esta ação.'], 403);
        }

        try {
            $validated = $request->validated();

            $this->userService->userUpdate($validated, $id);

            $successMessage = auth()->user()->id === $id
                ? 'Seu usuário foi atualizado com sucesso!'
                : 'Usuário atualizado com sucesso!';

            return response()->json(['message' => $successMessage]);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()], 500);
        }
    }

    /**
     * Delete a user.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->userService->deleteUser($id);

            return response()->json(['message' => 'Usuário deletado com sucesso! Recarregando...', 'redirect' => route('users.index')]);
        } catch (Exception $error) {
            return response()->json(['error' => 'Não foi possível deletar o registro no banco de dados.', 'message' => $error->getMessage()], 500);
        }
    }

    public function showJson(int $id)
    {
        $user = $this->userService->getUserById($id);
        return response()->json([
            'data' => $user,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAbilitiesRequest $request
     */
    public function storeAbilities(StoreAbilitiesRequest $request, int $userId)
    {
        $validated = $request->validated();
        $abilities = $validated['abilities'] ?? [];

        $user = $this->userService->getUserById($userId);
        $userProfileAbilities = $user->profile->abilities->pluck('id');

        if ($userProfileAbilities->intersect($abilities)->isNotEmpty()) {
            return response()->json(['error' => 'Não é possível adicionar habilidades já existentes no perfil do usuário.'], 400);
        }

        $user->abilities()->sync($abilities);

        return response()->json($user, 200);
    }
}
