<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

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
}
