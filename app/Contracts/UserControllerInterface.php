<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\View\View;
use App\Providers\UserService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\User\{StoreUserRequest, UpdateUserRequest};

interface UserControllerInterface
{
    public function __construct(UserService $userService);
    public function index(): View;
    public function create(): View;
    public function store(StoreUserRequest $request): RedirectResponse;
    public function edit(int $id): View;
    public function update(UpdateUserRequest $request, User $user): RedirectResponse;
    public function destroy(User $user): RedirectResponse;
}
