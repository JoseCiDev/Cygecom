<?php

namespace App\Http\Controllers;

use App\Http\Validators\PersonValidator;
use App\Models\User;
use App\Providers\UserService;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function showUsers()
    {
        $users = User::with('person', 'profile')->get()->toArray();
        return view('auth.admin.users', ['users' => $users]);
    }
    public function showUser($id)
    {
        $user = User::with(['person', 'person.address', 'person.phone', 'person.identification', 'profile', 'approver'])->where('id', $id)->first()->toArray();
        return view('auth.admin.user', ['user' => $user]);
    }

    public function userUpdate(Request $request, UserService $userService, ProfileController $profileController)
    {
        $data = $profileController->validUpdateRequest($request);
        $data = $userService->removeToken($request);
        $data = $userService->removeNullData($data);
        if (!$userService->existDataContent($data)) return redirect(route('profile'));
        dd($data);
    }
}
