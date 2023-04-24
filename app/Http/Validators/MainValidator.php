<?php

namespace App\Http\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainValidator
{
    public $requiredRules = [
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
    ];
    public $requiredRulesMessages = [
        'name.required' => ':attribute é obrigatório.',
        'name.string' => ':attribute deve ser string.',
        'name.max' => ':attribute deve ter no máximo :max',

        'email.required' => ':attribute é obrigatório.',
        'email.string' => ':attribute deve ser string.',
        'email.email' => 'Por favor insira um e-mail válido.',
        'email.max' => ':attribute deve ter no máximo :max',
        'email.unique' => 'Este e-mail já está sendo usado.',

        'password.required' => ':attribute é obrigatório.',
        'password.string' => ':attribute deve ser string.',
        'password.min' => ':attribute deve ter pelo menos :min caracteres.',
        'password.confirmed' => 'As senhas não são iguais.',

        'profile_type.required' => ':attribute é obrigatório.',
        'profile_type.string' => ':attribute deve ser string.',
        'profile_type.max' => ':attribute deve ter no máximo :max',

        'birthdate.required' => ':attribute é obrigatório.',
        'birthdate.date' => ':attribute deve ser uma data válida.',

        'street.required' => ':attribute é obrigatório.',
        'street.string' => ':attribute deve ser string.',

        'street_number.required' => ':attribute é obrigatório.',
        'street_number.string' => ':attribute deve ser string.',

        'neighborhood.required' => ':attribute é obrigatório.',
        'neighborhood.string' => ':attribute deve ser string.',

        'postal_code.required' => ':attribute é obrigatório.',
        'postal_code.string' => ':attribute deve ser string.',

        'city.required' => ':attribute é obrigatório.',
        'city.string' => ':attribute deve ser string.',

        'state.required' => ':attribute é obrigatório.',
        'state.string' => ':attribute deve ser string.',

        'country.required' => ':attribute é obrigatório.',
        'country.string' => ':attribute deve ser string.',

        'document_number.required' => ':attribute é obrigatório.',
        'document_number.string' => ':attribute deve ser string.',

        'phone.required' => ':attribute é obrigatório.',
        'phone.string' => ':attribute deve ser string.',

        'phone_type.required' => ':attribute é obrigatório.',
        'phone_type.string' => ':attribute deve ser string.',
    ];

    public $rules = [
        'name' => ['string', 'max:255'],
        'email' => ['string', 'email', 'max:255', 'unique:users'],
        'password' => ['string', 'min:8', 'confirmed'],
        'profile_type' => ['string', 'max:255'],
        'birthdate' => ['date'],
        'street' => ['string'],
        'street_number' => ['string'],
        'neighborhood' => ['string'],
        'postal_code' => ['string'],
        'city' => ['string'],
        'state' => ['string'],
        'country' => ['string'],
        'document_number' => ['string'],
        'phone' => ['string'],
        'phone_type' => ['string'],
    ];

    public $rulesMessages = [
        'name.string' => 'O campo :attribute deve ser uma string.',
        'name.max' => 'O campo :attribute deve ter no máximo :max caracteres.',

        'email.string' => 'O campo :attribute deve ser uma string.',
        'email.email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
        'email.max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        'email.unique' => 'Este e-mail já está sendo usado.',

        'password.string' => 'O campo :attribute deve ser uma string.',
        'password.min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
        'password.confirmed' => 'Os campos de senha não correspondem.',

        'profile_type.string' => 'O campo :attribute deve ser uma string.',
        'profile_type.max' => 'O campo :attribute deve ter no máximo :max caracteres.',

        'birthdate.date' => 'O campo :attribute deve ser uma data válida.',

        'street.string' => 'O campo :attribute deve ser uma string.',
        'street_number.string' => 'O campo :attribute deve ser uma string.',
        'neighborhood.string' => 'O campo :attribute deve ser uma string.',
        'postal_code.string' => 'O campo :attribute deve ser uma string.',
        'city.string' => 'O campo :attribute deve ser uma string.',
        'state.string' => 'O campo :attribute deve ser uma string.',
        'country.string' => 'O campo :attribute deve ser uma string.',

        'document_number.string' => 'O campo :attribute deve ser uma string.',

        'phone.string' => 'O campo :attribute deve ser uma string.',
        'phone_type.string' => 'O campo :attribute deve ser uma string.'
    ];

    public $rulesForUpdate = [
        'name' => ['string', 'max:255'],
        'email' => ['string', 'email', 'max:255'],
        'password' => ['string', 'min:8', 'confirmed'],
        'profile_type' => ['string', 'max:255'],
        'birthdate' => ['date'],
        'street' => ['string'],
        'street_number' => ['string'],
        'neighborhood' => ['string'],
        'postal_code' => ['string'],
        'city' => ['string'],
        'state' => ['string'],
        'country' => ['string'],
        'document_number' => ['string'],
        'phone' => ['string'],
        'phone_type' => ['string'],
    ];

    public $rulesForUpdateMessages = [
        'name.string' => 'O campo :attribute deve ser uma string.',
        'name.max' => 'O campo :attribute deve ter no máximo :max caracteres.',

        'email.string' => 'O campo :attribute deve ser uma string.',
        'email.email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
        'email.max' => 'O campo :attribute deve ter no máximo :max caracteres.',

        // 'password.string' => 'O campo :attribute deve ser uma string.',
        'password.min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
        'password.confirmed' => 'Os campos de senha não correspondem.',

        'profile_type.string' => 'O campo :attribute deve ser uma string.',
        'profile_type.max' => 'O campo :attribute deve ter no máximo :max caracteres.',

        'birthdate.date' => 'O campo :attribute deve ser uma data válida.',

        'street.string' => 'O campo :attribute deve ser uma string.',
        'street_number.string' => 'O campo :attribute deve ser uma string.',
        'neighborhood.string' => 'O campo :attribute deve ser uma string.',
        'postal_code.string' => 'O campo :attribute deve ser uma string.',
        'city.string' => 'O campo :attribute deve ser uma string.',
        'state.string' => 'O campo :attribute deve ser uma string.',
        'country.string' => 'O campo :attribute deve ser uma string.',

        'document_number.string' => 'O campo :attribute deve ser uma string.',

        'phone.string' => 'O campo :attribute deve ser uma string.',
        'phone_type.string' => 'O campo :attribute deve ser uma string.'
    ];
    public function registerValidator(array $data)
    {
        $validator = Validator::make($data, $this->requiredRules, $this->requiredRulesMessages);
        return $validator;
    }

    public function validateUpdateProfile(Request $request)
    {
        $rules = $this->rules;
        $messages = $this->rulesMessages;
        return $request->validate($rules, $messages);
    }
    public function validateUpdateUserRequest(Request $request)
    {
        $rules = $this->rulesForUpdate;
        $messages = $this->rulesForUpdateMessages;
        return $request->validate($rules, $messages);
    }
}
