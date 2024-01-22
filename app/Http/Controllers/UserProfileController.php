<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\{JsonResponse, RedirectResponse};
use App\Enums\MainProfile;
use App\Http\Requests\User\{UpdateProfileRequest, StoreProfileRequest};
use App\Models\{UserProfile, Ability};
use App\Services\AbilityService;
use App\Services\UserProfileService;

class UserProfileController extends Controller
{
    public function __construct(
        private UserProfileService $userProfileService,
        private AbilityService $abilityService,
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

        $groupedAbilities = $this->abilityService->groupAbilities($abilities);

        $params = [
            'getAbilities' => $groupedAbilities->get('get', collect()),
            'apiAbilities' => $groupedAbilities->get('api', collect()),
            'postAbilities' => $groupedAbilities->get('post', collect()),
            'deleteAbilities' => $groupedAbilities->get('delete', collect()),
            'authorizeAbilities' => $groupedAbilities->get('authorize', collect()),
        ];

        return view('user-profiles.create', $params);
    }

    /**
     * Cria novo perfil validando integridade para perfis únicos
     * @param StoreProfileRequest $request Valida formato dos dados: name e abilities
     * @return RedirectResponse Retorna para página de submit
     */
    public function store(StoreProfileRequest $request): RedirectResponse
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
     * Show the form for editing the specified resource.
     */
    public function edit(UserProfile $userProfile)
    {
        $abilities = Ability::with('users', 'profiles')->get();
        $groupedAbilities = $this->abilityService->groupAbilities($abilities);

        $params = [
            'getAbilities' => $groupedAbilities->get('get', collect()),
            'apiAbilities' => $groupedAbilities->get('api', collect()),
            'postAbilities' => $groupedAbilities->get('post', collect()),
            'deleteAbilities' => $groupedAbilities->get('delete', collect()),
            'authorizeAbilities' => $groupedAbilities->get('authorize', collect()),
            'profile' => $userProfile,

            'abilities' => $abilities
        ];

        return view('user-profiles.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateProfileRequest $request
     * @param UserProfile $userProfile
     * @return RedirectResponse
     */
    public function update(UpdateProfileRequest $request, UserProfile $userProfile): RedirectResponse
    {
        $abilities = collect($request->get('abilities'));

        try {
            if (MainProfile::tryFrom($userProfile->name)) {
                throw new \Exception('Não é possível atualizar esse perfil!');
            }

            $userProfile = $this->userProfileService->profileByName($userProfile->name)->first();
            if (!$userProfile) {
                throw new \Exception('Ops! Esse não perfil existe.');
            }

            if ($abilities->isEmpty()) {
                throw new \Exception("Não é possível atualizar o perfil sem habilidades!");
            }

            $profiles = $this->userProfileService->profiles()->get();
            foreach ($profiles as $profile) {
                $profileName = $profile->name;
                $profileAbilities = $profile->abilities->pluck('id');

                $profileAbilitiesDiff = $profileAbilities->diff($abilities);
                $abilitiesDiff = $abilities->diff($profileAbilities);
                $noDiff = $abilitiesDiff->isEmpty() && $profileAbilitiesDiff->isEmpty();

                $currentProfileUnchanged = $noDiff && $profileName === $userProfile->name;
                if ($currentProfileUnchanged) {
                    throw new \Exception("Você tentou atualizar $profileName sem novas alterações.");
                }

                $alreadyExistProfile = $noDiff && $profileName !== $userProfile->name;
                if ($alreadyExistProfile) {
                    throw new \Exception("Já exite o perfil $profileName que possui as habilidades idênticas. Por favor, analise melhor as necessidades do perfil $userProfile->name!");
                }
            }

            $userProfile->abilities()->sync($abilities);

            session()->flash('success', "Perfil $userProfile->name foi atualizado com sucesso.");
            return redirect()->route('profile.index');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UserProfile $userProfile
     * @return JsonResponse
     */
    public function destroy(UserProfile $userProfile): JsonResponse
    {
        try {
            if (MainProfile::tryFrom($userProfile->name)) {
                throw new \Exception('Não é possível excluir esse perfil!');
            }

            $profile = $this->userProfileService->profileByName($userProfile->name)->first();
            if (!$profile) {
                throw new \Exception('Ops! Esse não perfil existe.');
            }

            $profileUsers = $profile->user->count();
            if ($profileUsers) {
                throw new \Exception("Ops! Desculpe, a exclusão do perfil foi interrompida. Ainda existe(m) $profileUsers usuário(s) com perfil $userProfile->name.");
            }

            $userProfile->delete();

            return response()->json(['message' => "Perfil $userProfile->name foi excluído com sucesso. Recarregando...", 'redirect' => route('profile.index')]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Não foi possível deletar o registro no banco de dados.', 'message' => $th->getMessage()], 500);
        }
    }
}
