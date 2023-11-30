<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreAbilitiesRequest;
use App\Models\{UserProfile, Ability};
use App\Providers\UserService;
use Illuminate\Http\Request;

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
        $users = $this->userService->getUsers()
            ->whereHas('profile', function ($query) {
                return $query->where('name', '!=', 'admin');
            })->get();

        $params = [
            'abilities' => $abilities,
            'profiles' => $profiles,
            'users' => $users
        ];

        return view('authorizations.abilities', $params);
    }

    public function profile()
    {
        $abilities = Ability::with('users', 'profiles')->get();

        return view('authorizations.profile', ['abilities' => $abilities]);
    }

    public function create(Request $request)
    {
        return redirect()->back();
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
