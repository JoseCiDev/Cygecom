<?php

namespace App\Http\Controllers;

use App\Contracts\ProfileControllerInterface;
use App\Providers\UserService;

class ProfileController extends Controller implements ProfileControllerInterface
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showProfile()
    {
        $user        = $this->userService->getUserById(auth()->user()->id);
        $approvers   = $this->userService->getApprovers('userUpdate', $user->id);
        $costCenters = $this->userService->getCostCenters();

        return view('profile', compact('user', 'approvers', 'costCenters'));
    }
}
