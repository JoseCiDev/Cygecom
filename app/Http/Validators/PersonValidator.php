<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class PersonValidator
{
    public static function registerPersonValidate(array $data)
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
