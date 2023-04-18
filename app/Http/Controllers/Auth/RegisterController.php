<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Validators\PersonValidator;
use App\Providers\UserService;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    use RegistersUsers;
    protected $redirectTo = '/';

    protected function create(array $data)
    {
        $validator = $this->validator($data);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        $user = $this->userService->registerUser($data);

        return $user->first();
    }

    protected function validator(array $data)
    {
        return PersonValidator::registerValidator($data);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}
