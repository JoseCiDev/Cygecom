<?php

namespace App\Contracts;

use App\Models\User;
use App\Providers\{UserService, ValidatorService};
use Illuminate\Http\Request;

interface UserControllerInterface
{
    public function __construct(UserService $userService, ValidatorService $validatorService);
    public function create(array $data): User|string;
    public function showRegistrationForm();
    public function showUsers();
    public function showUser(int $id);
    public function update(Request $request, int $id);
}
