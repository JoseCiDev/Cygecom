<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface UserControllerInterface
{
    public function create(array $data);
    public function showRegistrationForm();
    public function showUsers();
    public function showUser($id);
    public function userUpdate(Request $request, int $id);
}
