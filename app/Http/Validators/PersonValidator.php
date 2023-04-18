<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;

class PersonValidator
{
    public static function registerValidator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'profile_type' => ['required', 'string', 'max:255'],
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
            ],
            [
                'email.unique' => 'Este e-mail já está sendo usado.',
            ]
        );
    }
}
