<?php

namespace App\Contracts;

use App\Models\User;

interface UserServiceInterface
{
    public function getUsers();
    public function getApprovers(string $action, int $id = null);
    public function getCostCenters();
    public function registerUser(array $request);
    public function getUserById(int $id): User;
    public function userUpdate(array $data, int $userId);
    public function deleteUser(int $id);
}
