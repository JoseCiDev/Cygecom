<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Models\UserProfile;

class UserProfileService
{
    /**
     * @return Builder Query builder de perfis com suas relações
     */
    public function profiles(): Builder
    {
        return UserProfile::with('abilities', 'user.person');
    }

    /**
     * Cria perfil e suas habilidades
     * @param string $name
     * @param Collection|array $abilities
     * @return void
     */
    public function create(string $name, Collection|array $abilities): void
    {
        DB::transaction(function () use ($name, $abilities) {
            $profile = UserProfile::create(['name' => $name]);
            $profile->abilities()->sync($abilities);
        });
    }

    /**
     * Atualiza perfil com habilidades
     * @param UserProfile $userProfile
     * @param Collection|array $abilities
     * @return void
     */
    public function update(UserProfile $userProfile, Collection|array $abilities): void
    {
        DB::transaction(function () use ($userProfile, $abilities) {
            $userProfile->abilities()->sync($abilities);
        });
    }

    public function destroy(int $id, string $name): void
    {
        DB::transaction(function () use ($id, $name) {
            UserProfile::where('id', $id)->where('name', $name)->first()->delete();
        });
    }

    public function profileByName(string $name): Builder
    {
        return UserProfile::with('abilities', 'user.person')->where('name', $name);
    }
}
