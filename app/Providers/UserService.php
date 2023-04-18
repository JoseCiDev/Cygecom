<?php

namespace App\Providers;

use App\Models\User;
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

    protected function getProfileId($data)
    {
        $profileId = DB::table('user_profiles')->where('profile_name', $data['profile_type'])->pluck('id')->first();
        return $profileId;
    }
}
