<?php

namespace App\Contracts;

use App\Models\User;
use App\Providers\UserService;
use App\Providers\ValidatorService;
use Illuminate\Http\Request;

interface UserControllerInterface
{
    public function __construct(UserService $userService, ValidatorService $validatorService);
    public function create(array $data): User|string;
    public function showRegistrationForm();
    public function showUsers();
    public function showUser(int $id);
    public function userUpdate(Request $request, int $id);
}
