<?php

namespace App\Providers;

use App\Contracts\UserServiceInterface;
use App\Models\Address;
use App\Models\IdentificationDocuments;
use App\Models\Person;
use App\Models\Phone;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Support\ServiceProvider;



class UserService extends ServiceProvider implements UserServiceInterface
{
    public function getUserById($id): User
    {
        return User::with(['person', 'person.address', 'person.phone', 'person.identification', 'profile', 'approver'])->where('id', $id)->first();
    }

    public function getUsers()
    {
        return User::with('person', 'profile')->get()->toArray();
    }

    public function registerUser(array $request)
    {
        $user = DB::transaction(function () use ($request) {
            $personId = $this->insertGetIdPerson($request);
            $this->registerAddress($personId, $request);
            $this->registerIdentificationDocument($personId, $request);
            $this->registerPhone($personId, $request);

            $user = new User();
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            $user->profile_id = $this->getProfileId($request);
            $user->person_id = $personId;
            $user->approver_user_id = $request['approver_user_id'];
            $user->approve_limit = $request['approve_limit'];
            $user->save();

            return $user;
        });

        return $user;
    }

    public function userUpdate(array $data, int $userId)
    {
        DB::beginTransaction();

        try {
            $user = $this->getUserById($userId);
            $person = $user->person;
            $address = $user->person->address;
            $phone = $user->person->phone;
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
            'email' => $data['email'] ?? $user->email,
            'password' => isset($data['password']) ? Hash::make($data['password']) : $user->password,
            'profile_id' => isset($data['profile_type']) ? UserProfile::firstWhere('profile_name', $data['profile_type'])->id : $user->profile_id,
            'approver_user_id' => isset($data['approver_user_id']) ? User::where('id', $data['approver_user_id'])->value('id') : $user->approver_user_id,
            'approve_limit' => $data['approve_limit'] ?? $user->approve_limit,
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
    private function insertGetIdPerson($request)
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

    private function getProfileId($data)
    {
        $profileId = DB::table('user_profiles')->where('profile_name', $data['profile_type'])->pluck('id')->first();
        return $profileId;
    }
}
