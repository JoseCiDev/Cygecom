<?php

namespace App\Http\Controllers;

use App\Contracts\ProfileControllerInterface;
use App\Models\Company;
use App\Providers\UserService;
use App\Services\UserProfileService;

class ProfileController extends Controller implements ProfileControllerInterface
{
    public function __construct(
        private UserService $userService,
        private UserProfileService $userProfileService
    ) {
        $this->userService = $userService;
    }

    public function showProfile()
    {
        $user        = $this->userService->getUserById(auth()->user()->id);
        $approvers   = $this->userService->getApprovers('userUpdate', $user->id);
        $costCenters = $this->userService->getCostCenters();
        $profiles = $this->userProfileService->profiles()->get();
        $companies = Company::select('id', 'corporate_name', 'name', 'cnpj', 'group')->get();

        $params = [
            'user' => $user,
            'approvers' => $approvers,
            'costCenters' => $costCenters,
            'profiles' => $profiles,
            'companies' => $companies
        ];

        return view('users.user', $params);
    }
}
