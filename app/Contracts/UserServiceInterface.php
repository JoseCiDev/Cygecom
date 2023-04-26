<?php

namespace App\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    public function registerUser(array $request);
    public function getUserById(int $id): User;
    public function userUpdate(array $data, int $userId);
}
