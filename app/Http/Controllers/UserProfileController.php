<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\{Request, RedirectResponse};
use App\Http\Requests\User\CreateProfileRequest;
use App\Models\{UserProfile, Ability};
use App\Services\UserProfileService;

class UserProfileController extends Controller
{
    public function __construct(
        private UserProfileService $userProfileService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Tela de criação de perfil com nova coleção de habilidades
     * @return View user-profiles.create
     */
    public function create(): View
    {
        $abilities = Ability::with('users', 'profiles')->get();

        return view('user-profiles.create', ['abilities' => $abilities]);
    }

    /**
     * Cria novo perfil validando integridade para perfis únicos
     * @param CreateProfileRequest $request Valida formato dos dados: name e abilities
     * @return RedirectResponse Retorna para página de submit
     */
    public function store(CreateProfileRequest $request): RedirectResponse
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
     * Display the specified resource.
     */
    public function show(UserProfile $userProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserProfile $userProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserProfile $userProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }
}
