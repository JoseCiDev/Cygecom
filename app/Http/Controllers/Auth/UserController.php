<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\UserControllerInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\{UserService, ValidatorService};
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class UserController extends Controller implements UserControllerInterface
{
    use RegistersUsers;

    private $userService;

    private $validatorService;

    public function __construct(UserService $userService, ValidatorService $validatorService)
    {
        $this->userService      = $userService;
        $this->validatorService = $validatorService;
    }

    protected $redirectTo = '/users';
    /**
     * @abstract Responsável por registrar usuário, junto com suas relações: Phone, People e UserCostCenterPermission
     * @param array $data Recebe $data pelo trait RegistersUsers do método register: $request->all();
     * @return User|string Retorna usuário logado para manter autenticação, podendo retornar os erros no redirect;
     */
    public function create(array $data): User|string
    {
        try {
            $this->validator($data);
            $user = $this->userService->registerUser($data);
            session()->flash('success', "Usuário cadastrado com sucesso!");

            return $user->first();
        } catch (Exception $error) {
            redirect()->back()->withErrors(['Não foi possível fazer o registro no banco de dados.', $error->getMessage()]);

            return auth()->user();
        }
    }

    public function showRegistrationForm()
    {
        $approvers   = $this->getApprovers('register');
        $costCenters = $this->getCostCenters();

        return view('auth.admin.register', ['approvers' => $approvers, 'costCenters' => $costCenters]);
    }

    public function showUsers()
    {
        $users = $this->userService->getUsers();

        return view('auth.admin.users', ['users' => $users]);
    }
    public function showUser(int $id)
    {
        $user = User::with([
            'person',
            'person.phone',
            'person.costCenter',
            'profile',
            'approver',
            'userCostCenterPermission.costCenter',
        ])->where('id', $id)->whereNull('deleted_at')->first();

        $approvers   = $this->getApprovers('userUpdate', $id);
        $costCenters = $this->getCostCenters();

        return view('auth.admin.user', ['user' => $user, 'approvers' => $approvers, 'costCenters' => $costCenters]);
    }

    public function update(Request $request, int $id)
    {
        $isAdmin = auth()->user()->profile->name === 'admin';
        $isOwnId = $id === auth()->user()->id;

        if (!$isAdmin && !$isOwnId) {
            return redirect()->route('profile');
        }

        try {
            $data = $request->all();

            $validator = $this->validatorService->updateValidator($id, $data);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors()->getMessages())->withInput();
            }

            $this->userService->userUpdate($data, $id);

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

    public function delete(int $id)
    {
        try {
            $this->userService->deleteUser($id);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors(['Não foi deletar o registro no banco de dados.', $error->getMessage()]);
        }

        session()->flash('success', "Usuário deletado com sucesso!");

        return redirect()->route('users');
    }

    private function getApprovers($action, int $id = null)
    {
        $query = $this->userService->getApprovers($action, $id = null);

        return $query;
    }

    public function getCostCenters()
    {
        return $this->userService->getCostCenters();
    }

    /**
     * @abstract função necessária para sobreescrever validator padrão;
     * @param array $data Recebe array da request para validação;
     */
    private function validator(array $data)
    {
        $validator = $this->validatorService->registerValidator($data);

        return $validator;
    }
}
