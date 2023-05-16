<?php

namespace App\Providers;

use App\Contracts\UserServiceInterface;
use App\Models\CostCenter;
use App\Models\{Address, IdentificationDocuments, Person, Phone, User, UserProfile};
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Support\ServiceProvider;

class UserService extends ServiceProvider implements UserServiceInterface
{
    public function getUserById(int $id): User
    {
        return User::with(['person', 'person.address', 'person.phone', 'person.identification', 'profile', 'approver', 'costCenter'])->where('id', $id)->first();
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
        $query = User::with(['person'])->where('profile_id', 1)->whereNull('deleted_at');

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
            $person = $this->createPerson($request);
            $this->createAddress($person, $request);
            $this->createIdentificationDocument($person, $request);
            $this->createPhone($person, $request);

            $user = new User();
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            $user->profile_id = $this->getProfileId($request);
            $user->person_id = $person->id;
            $user->approver_user_id = $request['approver_user_id'] ?? null;
            $user->approve_limit = $request['approve_limit'];
            $user->cost_center_id = $request['cost_center_id'];
            $user->save();

            return $user;
        });
    }

    public function userUpdate(array $data, int $userId)
    {
        DB::beginTransaction();

        try {
            $user           = $this->getUserById($userId);
            $person         = $user->person;
            $address        = $user->person->address;
            $phone          = $user->person->phone;
            $identification = $user->person->identification;

            $this->saveUser($user, $data);
            $this->savePerson($person, $data);
            $this->saveAddress($address, $data);
            $this->savePhone($phone, $data);
            $this->saveIdentification($identification, $data);

            DB::commit();
        } catch (Exception $error) {
            DB::rollback();
            throw $error;
        }
    }
    public function deleteUser(int $id)
    {
        $user = User::find($id);
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
            'approve_limit'    => $data['approve_limit'] ?? $user->approve_limit,
            'cost_center_id'   => isset($data['cost_center_id']) ? CostCenter::where('id', $data['cost_center_id'])->value('id') : $user->cost_center_id,
        ]);
    }

    private function savePerson(Person $person, array $data)
    {
        $person->update($data);
    }

    private function saveAddress(Address $address, array $data)
    {
        $address->update($data);
    }

    private function savePhone(Phone $phone, array $data)
    {
        $phone->update($data);
    }

    private function saveIdentification(IdentificationDocuments $identification, array $data)
    {
        $identification->update($data);
    }

    /**
     * Funções auxiliares para criação de usuário:
     */
    private function createPerson(array $request): Person
    {
        return Person::create($request);
    }

    private function createAddress(Person $person, array $request): void
    {
        $address = new Address($request);
        $person->address()->save($address);
    }

    private function createIdentificationDocument(Person $person, array $request): void
    {
        $identificationDocument = new IdentificationDocuments($request);
        $person->identification()->save($identificationDocument);
    }

    private function createPhone(Person $person, array $request): void
    {
        $phone = new Phone($request);
        $person->phone()->save($phone);
    }
    private function getProfileId(array $data)
    {
        $profileId = DB::table('user_profiles')->where('name', $data['profile_type'])->pluck('id')->first();

        return $profileId;
    }

    private function getCostCenterId($data)
    {
        $costCenterId = isset($data['cost_center_id']) ?
            DB::table('cost_centers')->where('name', $data['cost_center_id'])->pluck('id')->first() :
            null;

        return $costCenterId;
    }
}
