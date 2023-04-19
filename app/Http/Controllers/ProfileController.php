<?php

namespace App\Http\Controllers;

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

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'updateAction' => 'required',
        ]);

        $data = $this->removeToken($request);
        $data = $this->removeNullData($data);
        if (!$this->existDataContent($data)) return redirect(route('profile'));

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

    protected function removeToken($request)
    {
        return $request->except('_token');
    }
    protected function removeNullData($data)
    {
        return  array_filter($data, function ($value) {
            return $value !== null;
        });
    }

    protected function existDataContent($data)
    {
        return count($data) > 0;
    }
}
