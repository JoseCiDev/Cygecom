<?php

namespace App\Http\Controllers;

use App\Providers\UserService;

class ProfileController extends Controller
{
    public function showProfile(UserService $userService)
    {
        $user = $userService->getUserById(auth()->user()->id);
        return view('profile', ['user' => $user]);
    }
}
