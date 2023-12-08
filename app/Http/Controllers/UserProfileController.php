<?php

namespace App\Http\Controllers;

use App\Enums\MainProfile;
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
        $profiles = $this->userProfileService->profiles()->get();
        return view('user-profiles.index', ['profiles' => $profiles]);
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
    public function destroy(string $name): RedirectResponse
    {
        try {
            if (MainProfile::tryFrom($name)) {
                throw new \Exception('Não é possível excluir esse perfil!');
            }

            $profile = $this->userProfileService->profileByName($name)->first();
            if (!$profile) {
                throw new \Exception('Ops! Esse não perfil existe.');
            }

            $profileUsers = $profile->user->count();
            if ($profileUsers) {
                throw new \Exception("Ops! Desculpe, a exclusão do perfil foi interrompida. Ainda existe(m) $profileUsers usuário(s) com perfil $name.");
            }

            $this->userProfileService->destroy($profile->id, $profile->name);

            session()->flash('success', "Perfil $name foi excluído com sucesso.");
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
