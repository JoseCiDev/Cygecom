<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreAbilitiesRequest;
use App\Models\{UserProfile, User, Ability};
use App\Providers\UserService;

class AbilitiesController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abilities = Ability::with('users', 'profiles')->get();
        $profiles = UserProfile::with('abilities', 'user.person')->get();
        $users = User::with('abilities', 'person')->whereNull('deleted_at')->get();

        $params = [
            'abilities' => $abilities,
            'profiles' => $profiles,
            'users' => $users
        ];

        return view('abilities', $params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAbilitiesRequest $request
     */
    public function storeJson(StoreAbilitiesRequest $request, int $userId)
    {
        $validated = $request->validated();
        $abilities = $validated['abilities'] ?? [];

        $user = $this->userService->getUserById($userId);
        $userProfileAbilities = $user->profile->abilities->pluck('id');

        if ($userProfileAbilities->intersect($abilities)->isNotEmpty()) {
            return response()->json(['error' => 'Não é possível adicionar habilidades já existentes no perfil do usuário.'], 400);
        }

        $user->abilities()->sync($abilities);

        return response()->json($user, 200);
    }
}
