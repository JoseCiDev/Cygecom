<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\User\{StoreAbilitiesRequest, CreateProfileRequest};
use App\Models\Ability;
use App\Providers\UserService;
use App\Services\UserProfileService;

class AbilitiesController extends Controller
{
    public function __construct(
        private UserService $userService,
        private UserProfileService $userProfileService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $abilities = Ability::with('users', 'profiles')->get();
        $profiles = $this->userProfileService->profiles()->get();
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

    public function profile(): View
    {
        $abilities = Ability::with('users', 'profiles')->get();

        return view('authorizations.profile', ['abilities' => $abilities]);
    }

    /**
     * Tela que mostra todas habilidades do usuário
     * @param int $id ID usado para encontrar usuário
     * @return View Tela de habilidades do usuário encontrado
     */
    public function user(int $id): View
    {
        $user = $this->userService->getUserById($id);

        return view('authorizations.user', ['user' => $user]);
    }

    /**
     * Cria novo perfil validando integridade para perfis únicos
     * @param CreateProfileRequest $request Valida formato dos dados: name e abilities
     * @return RedirectResponse Retorna para página de submit
     */
    public function create(CreateProfileRequest $request): RedirectResponse
    {
        $name = $request->get('name');
        $abilities = collect($request->get('abilities'));

        try {
            if ($abilities->isEmpty()) {
                throw new \Exception("Não é possível criar um perfil sem habilidades!");
            }

            $profiles = $this->userProfileService->profiles()->get();

            foreach ($profiles as $profile) {
                $profileName = $profile->name;
                $profileAbilities = $profile->abilities->pluck('id');

                $profileAbilitiesDiff = $profileAbilities->diff($abilities);
                $abilitiesDiff = $abilities->diff($profileAbilities);

                if ($abilitiesDiff->isEmpty() && $profileAbilitiesDiff->isEmpty()) {
                    throw new \Exception("Já exite o perfil $profileName que possui as habilidades idênticas. Por favor, analise melhor as necessidades do novo perfil $name!");
                }
            }

            $this->userProfileService->create($name, $abilities);
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors(["Não foi possível criar o perfil $name.", $exception->getMessage()]);
        }

        session()->flash('success', "Perfil $name criado com sucesso!");
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
