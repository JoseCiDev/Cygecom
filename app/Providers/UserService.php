<?php

namespace App\Providers;

use App\Contracts\UserServiceInterface;
use App\Models\CostCenter;
use App\Models\{Person, Phone, User, UserCostCenterPermission, UserProfile};
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Support\ServiceProvider;

class UserService extends ServiceProvider implements UserServiceInterface
{
    public function getUserById(int $id): User
    {
        return User::with(['person', 'person.phone', 'profile', 'approver', 'person.costCenter', 'deletedByUser', 'updatedByUser'])->where('id', $id)->first();
    }

    /**
     * @return array Retorna um array com todos usuários, exceto logado.
     */
    public function getUsers()
    {
        $loggedId = auth()->user()->id;

        return User::with('person', 'profile')->where('id', '!=', $loggedId)->whereNull('deleted_at')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection retorna potenciais usuários aprovadores, exceto logado
     */
    public function getApprovers(string $action, int $id = null)
    {
        $isUserUpdate = $action === 'userUpdate';
        $query        = User::with(['person'])->where('profile_id', 1)->whereNull('deleted_at');

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
        return CostCenter::all();
    }

    public function registerUser(array $request): User
    {
        return DB::transaction(function () use ($request) {
            $phoneId             = $this->createPhone($request);
            $request['phone_id'] = $phoneId;
            $person              = $this->createPerson($request);

            $user                   = new User();
            $user->email            = $request['email'];
            $user->password         = Hash::make($request['password']);
            $user->profile_id       = $this->getProfileId($request);
            $user->person_id        = $person->id;
            $user->approver_user_id = $request['approver_user_id'] ?? null;
            $user->approve_limit    = $request['approve_limit'];
            $user->save();

            if (auth()->user()->profile->isAdmin) {
                $costCenterPermissions = $request['user_cost_center_permissions'];
                $this->saveUserCostCenterPermissions($costCenterPermissions, $user->id);
            }

            return $user;
        });
    }

    public function userUpdate(array $data, int $userId)
    {
        DB::beginTransaction();

        try {
            $user   = $this->getUserById($userId);
            $person = $user->person;
            $phone  = $user->person->phone;

            $this->saveUser($user, $data);
            $this->savePerson($person, $data);
            $this->savePhone($phone, $data);

            if (auth()->user()->profile->isAdmin) {
                $costCenterPermissions = $data['user_cost_center_permissions'];
                $this->saveUserCostCenterPermissions($costCenterPermissions, $user->id);
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollback();

            throw $error;
        }
    }
    public function deleteUser(int $id)
    {
        $user             = User::find($id);
        $user->deleted_at = Carbon::now();
        $user->deleted_by = auth()->user()->id;
        $user->save();
    }

    /**
     * Funções auxiliares para atualizar usuário:
     */
    private function saveUser(User $user, array $data)
    {
        $user->update([
            'email'            => $data['email'] ?? $user->email,
            'password'         => isset($data['password']) ? Hash::make($data['password']) : $user->password,
            'profile_id'       => isset($data['profile_type']) ? UserProfile::firstWhere('name', $data['profile_type'])->id : $user->profile_id,
            'approver_user_id' => isset($data['approver_user_id']) ? User::where('id', $data['approver_user_id'])->value('id') : $user->approver_user_id,
            'approve_limit'    => $data['approve_limit'],
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

    /**
     * Funções auxiliares para criação de usuário:
     */
    private function createPerson(array $request): Person
    {
        return Person::create($request);
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
