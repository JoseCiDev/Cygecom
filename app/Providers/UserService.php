<?php

namespace App\Providers;

use App\Contracts\UserServiceInterface;
use App\Models\{CostCenter, Person, Phone, User, UserCostCenterPermission, UserProfile};
use Exception;
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

class UserService extends ServiceProvider implements UserServiceInterface
{
    public function getUserById(int $id): User
    {
        return User::with([
            'abilities',
            'person.phone',
            'profile.abilities',
            'approver',
            'person.costCenter',
            'deletedByUser',
            'updatedByUser'
        ])->whereNull('deleted_at')->where('id', $id)->first();
    }

    /**
     * @return Builder Retorna um query builder de todos usuários, exceto excluídos.
     */
    public function getUsers(): Builder
    {
        return User::with([
            'abilities',
            'person.phone',
            'profile.abilities',
            'approver',
            'person.costCenter',
            'deletedByUser',
            'updatedByUser'
        ])->whereNull('deleted_at');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection retorna potenciais usuários aprovadores, exceto logado
     */
    public function getApprovers(string $action, int $id = null)
    {
        $isUserUpdate = $action === 'user.update';
        $query = User::whereHas('profile', function ($query) {
            $query->where('name', 'diretor');
        })->whereNull('deleted_at')->with('profile');

        if ($isUserUpdate && $id !== null) {
            $query->where('id', '!=', $id);
        }

        return $query->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection retorna todos os centros de custo disponíveis
     */
    public function getCostCenters()
    {
        return CostCenter::with('company')->get();
    }

    public function registerUser(array $request): User
    {
        return DB::transaction(function () use ($request) {
            $currentProfile = auth()->user()->profile->name;

            $phoneId = $this->createPhone($request);
            $request['phone_id'] = $phoneId;
            $person = $this->updateOrCreatePerson($request);

            $user = new User();
            $user->email = $request['email'];
            $user->password  = Hash::make($request['password']);
            $user->user_profile_id = $this->getProfileId($request);
            $user->person_id = $person->id;
            $user->approver_user_id = $request['approver_user_id'] ?? null;
            $user->approve_limit = $request['approve_limit'] ?? null;
            $user->is_buyer = $request['is_buyer'] ?? false;
            $user->can_associate_requester = $request['can_associate_requester'] ?? false;

            $user->save();

            if ($currentProfile === 'admin' || $currentProfile === 'gestor_usuarios') {
                $costCenterPermissions = $request['user_cost_center_permissions'] ?? null;

                if ($costCenterPermissions !== null) {
                    $this->saveUserCostCenterPermissions($costCenterPermissions, $user->id);
                }
            }

            return $user;
        });
    }

    public function userUpdate(array $data, int $userId)
    {
        DB::beginTransaction();

        try {
            $currentProfile = auth()->user()->profile->name;
            $user = $this->getUserById($userId);
            $person = $user->person;
            $phone = $user->person->phone;
            $isOwnUser = auth()->user()->id === $user->id;

            $this->saveUser($user, $data);
            $this->savePerson($person, $data);
            $this->savePhone($phone, $data);

            if ($currentProfile === 'admin' || $currentProfile === 'gestor_usuarios') {
                $costCenterPermissions = $data['user_cost_center_permissions'] ?? null;

                if (!$costCenterPermissions && !$isOwnUser) {
                    throw new Exception('Não foi possível o atualizar usuário. Por favor, adicione no mínimo um centro de custo.');
                }

                if ($costCenterPermissions !== null) {
                    $this->saveUserCostCenterPermissions($costCenterPermissions, $user->id);
                }
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollback();

            throw $error;
        }
    }
    public function deleteUser(int $id)
    {
        $user = User::with('person')->find($id);
        $person = $user->person;
        $currentUserId = auth()->user()->id;

        if ($user) {
            $user->update([
                'deleted_at' => now(),
                'deleted_by' => $currentUserId
            ]);
            $user->save();

            if ($person) {
                $person->update([
                    'deleted_at' => now(),
                    'deleted_by' => $currentUserId
                ]);
                $person->save();
            }
        }
    }

    /**
     * Funções auxiliares para atualizar usuário:
     */
    private function saveUser(User $user, array $data)
    {
        $email = $data['email'] ?? $user->email;
        $password = isset($data['password']) ? Hash::make($data['password']) : $user->password;

        $profile = isset($data['profile_type']) ? UserProfile::firstOrCreate(['name' => $data['profile_type']]) : $user->profile;
        $profileId = $profile->id;

        $approverUserId = isset($data['approver_user_id']) ? User::find($data['approver_user_id'])->id : $user->approver_user_id;
        $approveLimit = $data['approve_limit'] ?? null;

        $isBuyer = $data['is_buyer'] ?? $user->is_buyer;

        $canAssociateRequester = $data['can_associate_requester'] ?? $user->can_associate_requester;

        $user->update([
            'email' => $email,
            'password' => $password,
            'user_profile_id' => $profileId,
            'approver_user_id' => $approverUserId,
            'approve_limit' => $approveLimit,
            'is_buyer' => $isBuyer,
            'can_associate_requester' => $canAssociateRequester,
        ]);
    }

    private function savePerson(Person $person, array $data)
    {
        $person->update($data);
    }

    private function savePhone(Phone $phone, array $data)
    {
        $phone->update($data);
    }

    /**
     * @param array $data Contêm valores inteiros que representam os cost_center_id's
     * @abstract Responsável por criar ou remover relações de usuário com centro de custo
     */
    private function saveUserCostCenterPermissions(array $data, int $userId): void
    {
        $existingPermissions = UserCostCenterPermission::where('user_id', $userId)->pluck('cost_center_id')->toArray();
        $newPermissions      = array_diff($data, $existingPermissions);
        $removedPermissions  = array_diff($existingPermissions, $data);

        foreach ($newPermissions as $costCenterId) {
            UserCostCenterPermission::create(['user_id' => $userId, 'cost_center_id' => $costCenterId]);
        }

        UserCostCenterPermission::whereIn('cost_center_id', $removedPermissions)->where('user_id', $userId)->delete();
    }

    private function updateOrCreatePerson(array $request): Person
    {
        return Person::updateOrCreate(['cpf_cnpj' => $request['cpf_cnpj']], [
            'name' => $request['name'],
            'phone_id' => $request['phone_id'],
            'birthdate' => $request['birthdate'] ?? null,
            'cost_center_id' => $request['cost_center_id'],
            'deleted_at' => null,
            'deleted_by' => null
        ]);
    }

    private function createPhone(array $request): int
    {
        $phone = new Phone($request);
        $phone->save();

        return $phone->id;
    }
    private function getProfileId(array $data)
    {
        $profileId = DB::table('user_profiles')->where('name', $data['profile_type'])->pluck('id')->first();

        return $profileId;
    }
}
