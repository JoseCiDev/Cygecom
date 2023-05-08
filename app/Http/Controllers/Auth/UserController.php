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

    public function create(array $data)
    {
        $this->validator($data);
        $user = $this->userService->registerUser($data);
        session()->flash('success', "Usuário cadastrado com sucesso!");

        return $user->first();
    }

    public function showRegistrationForm()
    {
        $approvers = $this->getApprovers();

        return view('auth.admin.register', ['approvers' => $approvers]);
    }

    public function showUsers()
    {
        $users = $this->userService->getUsers();

        return view('auth.admin.users', ['users' => $users]);
    }
    public function showUser($id)
    {
        $user = User::with([
            'person',
            'person.address',
            'person.phone',
            'person.identification',
            'profile', 'approver',
        ])->where('id', $id)->whereNull('deleted_at')->first()->toArray();

        $approvers = $this->getApprovers();

        return view('auth.admin.user', ['user' => $user, 'approvers' => $approvers]);
    }

    public function userUpdate(Request $request, int $id)
    {
        $isAdmin = auth()->user()->profile->name === "admin";
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

    private function getApprovers()
    {
        return User::with([
            'person',
        ])->where('profile_id', 1)->whereNull('deleted_at')->get();
    }

    protected function validator(array $data)
    {
        $validator = $this->validatorService->registerValidator($data);

        return $validator;
    }
}
