<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Providers\UserService;
use App\Contracts\UserControllerInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{StoreUserRequest, UpdateUserRequest};
use App\Models\Company;
use App\Services\UserProfileService;

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
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $this->userService->registerUser($validated);

        session()->flash('success', "Usuário cadastrado com sucesso! E-mail: {$user['email']}");

        return redirect()->route('users');
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
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $id = $user->id;
        $isAdmin = Gate::allows('admin');
        $isGestorUsuarios = Gate::allows('gestor_usuarios');
        $isOwnId = $id === auth()->user()->id;

        if ((!$isAdmin && !$isGestorUsuarios) && !$isOwnId) {
            return redirect()->route('profile');
        }

        try {
            $validated = $request->validated();

            $this->userService->userUpdate($validated, $id);

            if (auth()->user()->id === $id) {
                session()->flash('success', "Seu usuário foi atualizado com sucesso!");

                return redirect()->route('profile');
            }

            session()->flash('success', "Usuário atualizado com sucesso!");

            return redirect()->route('users');
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
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
