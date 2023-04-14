<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class PersonService extends ServiceProvider
{
    public function registerPerson(Request $request): int
    {
        $data = $request->input();
        unset($data['_token']);

        $validator = (new PersonValidator())->validate($data);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        $personId = DB::transaction(function () use ($data) {
            $personId = DB::table('people')->insertGetId([
                'name' => $data['name'],
                'birthdate' => $data['birthdate'],
            ]);

            $this->registerAddress($personId, $data);
            $this->registerIdentificationDocument($personId, $data);
            $this->registerPhone($personId, $data);

            return $personId;
        });

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
}

class PersonValidator
{
    public function validate(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'street' => ['required', 'string'],
            'street_number' => ['required', 'string'],
            'neighborhood' => ['required', 'string'],
            'postal_code' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'document_number' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'phone_type' => ['required', 'string'],
        ]);
    }
}
