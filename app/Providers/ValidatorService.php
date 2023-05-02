<?php

namespace App\Providers;

use Error;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorService extends ServiceProvider
{
    public $requiredRules = [
        'name'            => ['required', 'string', 'max:255'],
        'email'           => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'        => ['required', 'string', 'min:8', 'confirmed'],
        'profile_type'    => ['required', 'string', 'max:255'],
        'birthdate'       => ['required', 'date'],
        'street'          => ['required', 'string'],
        'street_number'   => ['required', 'string'],
        'neighborhood'    => ['required', 'string'],
        'postal_code'     => ['required', 'string'],
        'city'            => ['required', 'string'],
        'state'           => ['required', 'string'],
        'country'         => ['required', 'string'],
        'identification' => ['required', 'string'],
        'number'           => ['required', 'string'],
        'phone_type'      => ['required', 'string'],
    ];

    public $requiredRulesMessages = [
        'name.required' => ':attribute é obrigatório.',
        'name.string'   => ':attribute deve ser string.',
        'name.max'      => ':attribute deve ter no máximo :max',

        'email.required' => ':attribute é obrigatório.',
        'email.string'   => ':attribute deve ser string.',
        'email.email'    => 'Por favor insira um e-mail válido.',
        'email.max'      => ':attribute deve ter no máximo :max',
        'email.unique'   => 'Este e-mail já está sendo usado.',

        'password.required'  => ':attribute é obrigatório.',
        'password.string'    => ':attribute deve ser string.',
        'password.min'       => ':attribute deve ter pelo menos :min caracteres.',
        'password.confirmed' => 'As senhas não são iguais.',

        'profile_type.required' => ':attribute é obrigatório.',
        'profile_type.string'   => ':attribute deve ser string.',
        'profile_type.max'      => ':attribute deve ter no máximo :max',

        'birthdate.required' => ':attribute é obrigatório.',
        'birthdate.date'     => ':attribute deve ser uma data válida.',

        'street.required' => ':attribute é obrigatório.',
        'street.string'   => ':attribute deve ser string.',

        'street_number.required' => ':attribute é obrigatório.',
        'street_number.string'   => ':attribute deve ser string.',

        'neighborhood.required' => ':attribute é obrigatório.',
        'neighborhood.string'   => ':attribute deve ser string.',

        'postal_code.required' => ':attribute é obrigatório.',
        'postal_code.string'   => ':attribute deve ser string.',

        'city.required' => ':attribute é obrigatório.',
        'city.string'   => ':attribute deve ser string.',

        'state.required' => ':attribute é obrigatório.',
        'state.string'   => ':attribute deve ser string.',

        'country.required' => ':attribute é obrigatório.',
        'country.string'   => ':attribute deve ser string.',

        'identification.required' => ':attribute é obrigatório.',
        'identification.string'   => ':attribute deve ser string.',

        'number.required' => ':attribute é obrigatório.',
        'number.string'   => ':attribute deve ser string.',

        'phone_type.required' => ':attribute é obrigatório.',
        'phone_type.string'   => ':attribute deve ser string.',
    ];

    public $rulesForUpdate = [
        'name' => ['nullable', 'string', 'max:255'],
        'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
        'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        'password_confirmation' => ['nullable', 'required_with:password', 'same:password'],
        'profile_type' => ['nullable', 'in:admin,normal'],
        'approver_user_id' => ['nullable', 'numeric', 'min:1', 'exists:users,id'],
        'approve_limit' => ['nullable', 'numeric', 'min:0'],
        'birthdate' => ['nullable', 'date'],
        'identification' => ['nullable', 'string', 'max:20'],
        'number' => ['nullable', 'string', 'max:20'],
        'phone_type' => ['nullable', 'string', 'max:20'],
        'postal_code' => ['nullable', 'string', 'max:20'],
        'country' => ['nullable', 'string', 'max:255'],
        'state' => ['nullable', 'string', 'max:255'],
        'city' => ['nullable', 'string', 'max:255'],
        'neighborhood' => ['nullable', 'string', 'max:255'],
        'street' => ['nullable', 'string', 'max:255'],
        'street_number' => ['nullable', 'string'],
        'complement' => ['nullable', 'string', 'max:255'],
    ];

    public $rulesForUpdateMessages = [
        'name.string' => 'O campo :attribute deve ser uma string.',
        'name.max' => 'O campo :attribute deve ter no máximo :max caracteres.',

        'email.email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
        'email.max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        'email.unique' => 'O campo :attribute deve ter único.',

        'password.string' => 'O campo :attribute deve ser uma string.',
        'password.min' => 'O campo :attribute deve ter pelo menos :min caracteres.',
        'password.confirmed' => 'Os campos de senha não correspondem.',

        'password_confirmation' => 'O campo de confirmação de senha é obrigatório ao preencher senha.',

        'profile_type.string' => 'O campo :attribute deve ser uma string.',
        'profile_type.max' => 'O campo :attribute deve ter no máximo :max caracteres.',

        'approver_user_id.number' => 'O campo :attribute deve ser :number.',

        'birthdate.date' => 'O campo :attribute deve ser uma data válida.',

        'street.string' => 'O campo :attribute deve ser uma string.',
        'street_number.string' => 'O campo :attribute deve ser uma string.',
        'neighborhood.string' => 'O campo :attribute deve ser uma string.',
        'postal_code.string' => 'O campo :attribute deve ser uma string.',
        'city.string' => 'O campo :attribute deve ser uma string.',
        'state.string' => 'O campo :attribute deve ser uma string.',
        'country.string' => 'O campo :attribute deve ser uma string.',

        'identification.string' => 'O campo :attribute deve ser uma string.',

        'number.string' => 'O campo :attribute deve ser uma string.',
        'phone_type.string' => 'O campo :attribute deve ser uma string.'
    ];

    public function registerValidator(array $data)
    {
        try {
            $validator = Validator::make($data, $this->requiredRules, $this->requiredRulesMessages);
            return $validator;
        } catch (Exception $error) {
            return back()->withErrors($error->getMessage())->withInput();
        }
    }

    public function updateValidator($id, $data)
    {
        $rules = $this->rulesForUpdate;
        $messages = $this->rulesForUpdateMessages;
        $rules['email'] = ['nullable', 'email', 'max:255', 'unique:users,email,' . $id];

        $validator = Validator::make($data, $rules, $messages);
        return $validator;
        // if ($validator->fails()) {
        // return back()->withErrors($validator->errors()->getMessages())->withInput();
        // return $validator->errors()->getMessages();
        // }
    }
}
