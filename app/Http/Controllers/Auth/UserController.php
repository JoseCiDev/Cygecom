<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use App\Providers\UserService;
use App\Contracts\UserControllerInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{StoreUserRequest, UpdateUserRequest};
use App\Models\{Company, User};
use App\Services\UserProfileService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller implements UserControllerInterface
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

        $users = $this->userService->getUsers()->where('id', '!=', $loggedId);

        if (!$isAdmin) {
            $users->whereHas('profile', function ($query) {
                return $query->where('name', '!=', 'admin');
            });
        }

        $users = $users->get();

        return view('users.index', ['users' => $users]);
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

        return view('users.user', $params);
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
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $user = User::with([
            'person',
            'person.phone',
            'person.costCenter',
            'profile',
            'approver',
            'userCostCenterPermission.costCenter',
        ])->where('id', $id)->whereNull('deleted_at')->first();

        $approvers = $this->userService->getApprovers('user.update', $id);
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

        return view('users.user', $params);
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

        return redirect()->route('users');
    }

    public function showJson(int $id)
    {
        $user = $this->userService->getUserById($id);
        return response()->json([
            'data' => $user,
        ], 200);
    }
}
