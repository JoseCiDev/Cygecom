<?php

namespace App\Contracts;

use Illuminate\View\View;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use App\Providers\UserService;
use App\Http\Requests\User\{StoreUserRequest, UpdateUserRequest};
use App\Services\UserProfileService;
use App\Models\User;

interface UserControllerInterface
{
    public function __construct(UserService $userService, UserProfileService $userProfileService);
    public function index(): View;
    public function create(): View;
    public function store(StoreUserRequest $request): JsonResponse;
    public function edit(int $id): View;
    public function update(UpdateUserRequest $request, User $user): JsonResponse;
    public function destroy(int $id): RedirectResponse;
}
