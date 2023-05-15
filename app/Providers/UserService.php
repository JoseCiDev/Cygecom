<?php

namespace App\Providers;

use App\Contracts\UserServiceInterface;
use App\Models\CostCenter;
use App\Models\{Address, IdentificationDocuments, Person, Phone, User, UserProfile};
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
    public function getUsers(): array
    {
        $loggedId = auth()->user()->id;
        return User::with('person', 'profile')->where('id', '!=', $loggedId)->get()->toArray();
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
            $personId = $this->insertGetIdPerson($request);
            $this->registerAddress($personId, $request);
            $this->registerIdentificationDocument($personId, $request);
            $this->registerPhone($personId, $request);

            $user                   = new User();
            $user->email            = $request['email'];
            $user->password         = Hash::make($request['password']);
            $user->profile_id       = $this->getProfileId($request);
            $user->person_id        = $personId;
            $user->approver_user_id = $request['approver_user_id'] ?? null;
            $user->approve_limit    = $request['approve_limit'];
            $user->cost_center_id   = $request['cost_center_id'] ?? null;
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
    private function insertGetIdPerson(array $request)
    {
        $personId = DB::table('people')->insertGetId([
            'name'      => $request['name'],
            'birthdate' => $request['birthdate'],
        ]);

        return $personId;
    }

    private function registerAddress(int $personId, array $data): void
    {
        $addresses = [
            'street'        => $data['street'],
            'street_number' => $data['street_number'],
            'neighborhood'  => $data['neighborhood'],
            'postal_code'   => $data['postal_code'],
            'city'          => $data['city'],
            'state'         => $data['state'],
            'country'       => $data['country'],
            'person_id'     => $personId,
            'complement'    => $data['complement'],
        ];
        DB::table('addresses')->insert($addresses);
    }

    private function registerIdentificationDocument(int $personId, array $data): void
    {
        $identification_documents = [
            'identification' => $data['identification'],
            'person_id'      => $personId,
        ];
        DB::table('identification_documents')->insert($identification_documents);
    }

    private function registerPhone(int $personId, array $data): void
    {
        $phones = [
            'number'     => $data['number'],
            'phone_type' => $data['phone_type'],
            'person_id'  => $personId,
        ];
        DB::table('phones')->insert($phones);
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
