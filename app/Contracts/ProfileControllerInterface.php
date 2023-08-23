<?php

namespace App\Contracts;

use App\Providers\UserService;

interface ProfileControllerInterface
{
    public function __construct(UserService $userService);
    public function showProfile();
}
