<?php

namespace App\Http\Controllers;

use App\Http\Validators\MainValidator;
use App\Providers\UserService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function showProfile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request, UserService $userService, MainValidator $mainValidator)
    {
        $data = $mainValidator->validateUpdate($request);
        $data = $userService->removeToken($request);
        $data = $userService->removeNullData($data);
        if (!$userService->existDataContent($data)) return redirect(route('profile'));

        $user_id = auth()->user()->id;
        $person_id = auth()->user()->person_id;

        $updateAction = $data['updateAction'];
        unset($data['updateAction']);

        switch ($updateAction) {
            case 'address':
                $this->userService->updateTableWhereId('addresses', 'person_id', $user_id, $data);
                break;
            case 'person':
                $this->userService->updateTableWhereId('people', 'id', $person_id, $data);
                break;
            case 'identification':
                $this->userService->updateTableWhereId('identification_documents', 'person_id', $user_id, $data);
                break;
            case 'phone':
                $this->userService->updateTableWhereId('phones', 'person_id', $user_id, $data);
                break;
            case 'user':
                $this->userService->updateTableWhereId('users', 'id', $user_id, $data);
                break;
        }
        return redirect(route('profile'));
    }
}
