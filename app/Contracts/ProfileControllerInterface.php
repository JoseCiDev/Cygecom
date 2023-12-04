<?php

namespace App\Contracts;

use App\Providers\UserService;
use App\Services\UserProfileService;

interface ProfileControllerInterface
{
    public function __construct(
        UserService $userService,
        UserProfileService $userProfileService
    );
    public function showProfile();
}
