<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\UserControllerInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\UserService;
use App\Providers\ValidatorService;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class UserController extends Controller implements UserControllerInterface
{
    private $userService;
    private $validatorService;

    public function __construct(UserService $userService, ValidatorService $validatorService)
    {
        $this->userService = $userService;
        $this->validatorService = $validatorService;
    }

    use RegistersUsers;
    protected $redirectTo = '/users';

    public function create(array $data)
    {
        $this->validator($data);
        $user = $this->userService->registerUser($data);
        return $user->first();
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showUsers()
    {
        $users = User::with('person', 'profile')->get()->toArray();
        return view('auth.admin.users', ['users' => $users]);
    }
    public function showUser($id)
    {
        $user = User::with(['person', 'person.address', 'person.phone', 'person.identification', 'profile', 'approver'])->where('id', $id)->first()->toArray();
        return view('auth.admin.user', ['user' => $user]);
    }

    public function userUpdate(Request $request, int $id)
    {
        $isAdmin = auth()->user()->profile->profile_name === "admin";
        $isOwnId = $id === auth()->user()->id;

        if (!$isAdmin && !$isOwnId) {
            return redirect()->route('profile');
        }

        try {
            $data = $request->all();
            $this->validatorService->updateValidator($id, $data);
            $this->userService->userUpdate($data, $id);

            if (auth()->user()->id === $id) {
                return redirect()->route('profile');
            }
            return redirect()->route('user', ['id' => $id]);
        } catch (Exception $error) {
            return redirect()->back()->withInput()->withErrors([$error->getMessage()]);
        }
    }

    protected function validator(array $data)
    {
        $validator = $this->validatorService->registerValidator($data);
        return $validator;
    }
}
