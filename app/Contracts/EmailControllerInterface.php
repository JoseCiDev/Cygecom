<?php

namespace App\Contracts;

use App\Providers\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface EmailControllerInterface
{
    public function store(Request $request): RedirectResponse;
    public function index(UserService $userService);
}
