<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class UserService extends ServiceProvider
{
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

    public function updateTableWhereId($table, $where, $id, $data)
    {
        $data['updated_at'] = Carbon::now()->setTimezone('America/Sao_Paulo');

        if ($this->isProfileTypeUpdate($data)) {
            $data['profile_id'] = $this->getIdOfProfileType($data['profile_name']);
            unset($data['profile_name']);
        }

        if ($this->isPasswordUpdate($data)) {
            $data['password'] = Hash::make($data['password']);
            unset($data['password_confirmation']);
        }

        return DB::table($table)->where($where, $id)->update($data);
    }


    public function removeToken($request)
    {
        return $request->except('_token');
    }
    public function removeNullData($data)
    {
        return  array_filter($data, function ($value) {
            return $value !== null;
        });
    }

    public function existDataContent($data)
    {
        return count($data) > 0;
    }

    public function getUserById($id)
    {
        return User::with(['person', 'person.address', 'person.phone', 'person.identification', 'profile', 'approver'])->where('id', $id)->first();
    }

    private function insertGetIdPerson($request)
    {
        $personId = DB::table('people')->insertGetId([
            'name' => $request['name'],
            'birthdate' => $request['birthdate'],
        ]);
        return $personId;
    }

    private function registerAddress(int $personId, array $data): void
    {
        $addresses = [
            'street' => $data['street'],
            'street_number' => $data['street_number'],
            'neighborhood' => $data['neighborhood'],
            'postal_code' => $data['postal_code'],
            'city' => $data['city'],
            'state' => $data['state'],
            'country' => $data['country'],
            'person_id' => $personId,
            'complement' => $data['complement']
        ];
        DB::table('addresses')->insert($addresses);
    }

    private function registerIdentificationDocument(int $personId, array $data): void
    {
        $identification_documents = [
            'identification' => $data['document_number'],
            'person_id' => $personId,
        ];
        DB::table('identification_documents')->insert($identification_documents);
    }

    private function registerPhone(int $personId, array $data): void
    {
        $phones = [
            'number' => $data['phone'],
            'phone_type' => $data['phone_type'],
            'person_id' => $personId,
        ];
        DB::table('phones')->insert($phones);
    }

    private function getProfileId($data)
    {
        $profileId = DB::table('user_profiles')->where('profile_name', $data['profile_type'])->pluck('id')->first();
        return $profileId;
    }
    private function isProfileTypeUpdate($data)
    {
        return isset($data['profile_name']) && $data['profile_name'] !== null;
    }
    private function isPasswordUpdate($data)
    {
        return isset($data['password']) && $data['password'] !== null;
    }

    private function getIdOfProfileType($profile_name_value)
    {
        return DB::table('user_profiles')->where('profile_name', $profile_name_value)->value('id');
    }

    protected function isAdmin()
    {
        return auth()->user()->profile->profile_name === 'admin';
    }
}
