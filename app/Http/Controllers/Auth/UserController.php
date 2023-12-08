<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use Illuminate\Support\Facades\Gate;
use App\Providers\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{StoreAbilitiesRequest, StoreUserRequest, UpdateUserRequest};
use App\Models\{Ability, Company, User};
use App\Services\UserProfileService;

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
        private UserProfileService $userProfileService
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
        $profiles = $this->userProfileService->profiles()->get();
        $users = $this->userService->getUsers()->where('id', '!=', $loggedId);

        if (!$isAdmin) {
            $users->whereHas('profile', function ($query) {
                return $query->where('name', '!=', 'admin');
            });
        }

        $users = $users->get();

        $params = [
            'abilities' => $abilities,
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

        $params = [
            'approvers' => $approvers,
            'costCenters' => $costCenters,
            'profiles' => $profiles,
            'companies' => $companies
        ];

        return view('users.store-edit', $params);
    }

    /**
     * Tela que mostra usuário e suas todas habilidades
     * @param User $user
     * @return View Tela de habilidades do usuário encontrado
     */
    public function show(User $user): View
    {
        return view('users.show', ['user' => $user]);
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

        $params = [
            'user' => $user,
            'approvers' => $approvers,
            'costCenters' => $costCenters,
            'profiles' => $profiles,
            'companies' => $companies
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

        if ((!$isAdmin && !$isGestorUsuarios) && !$isOwnId) {
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
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->userService->deleteUser($id);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi deletar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Usuário deletado com sucesso!");

        return redirect()->route('users.index');
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
