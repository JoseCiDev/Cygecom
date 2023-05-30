<?php

namespace App\Providers;

use App\Contracts\ValidatorServiceInterface;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorService extends ServiceProvider implements ValidatorServiceInterface
{
    public $requiredRules = [
        'name'           => ['required', 'string', 'max:255'],
        'email'          => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'       => ['required', 'string', 'min:8', 'confirmed'],
        'profile_type'   => ['required', 'string', 'max:255'],
        'cpf_cnpj'       => ['required', 'string'],
        'number'         => ['required', 'string'],
        'phone_type'     => ['required', 'string'],
        'cost_center_id' => ['required', 'string'],
        'is_buyer'       => ['nullable', 'boolean'],
    ];

    public $requiredRulesMessages = [
        'name.required' => 'Campo "Nome" é obrigatório.',
        'name.max'      => 'Campo "Nome" deve ter no máximo :max caracteres',

        'email.required' => '"E-mail" é obrigatório',
        'email.email'    => 'E-mail inválido.',
        'email.max'      => 'E-mail deve ter no máximo :max caracteres',
        'email.unique'   => 'Este e-mail já está sendo usado.',

        'password.required'  => '"Senha" é obrigatório.',
        'password.min'       => 'Senha deve ter pelo menos :min caracteres.',
        'password.confirmed' => 'As senhas não são iguais.',

        'profile_type.required' => '"Tipo de usuário" é obrigatório.',
        'profile_type.max'      => '"Tipo de usuário" deve ter no máximo :max',

        'birthdate.date' => 'Data inválida',

        'cpf_cnpj.required' => '"CPF/CNPJ" é obrigatório.',

        'number.required' => '"Telefone/Celular" é obrigatório.',

        'cost_center_id.required' => 'Centro de custo é obrigatório',

        'is_buyer.boolean' => 'A pessoa de ter o campo "é comprador" como verdadeiro ou false.',
    ];

    public $rulesForUpdate = [
        'name'                  => ['nullable', 'string', 'max:255'],
        'email'                 => ['nullable', 'email', 'max:255', 'unique:users,email'],
        'password'              => ['nullable', 'string', 'min:8', 'confirmed'],
        'password_confirmation' => ['nullable', 'required_with:password', 'same:password'],
        'profile_type'          => ['nullable', 'in:admin,normal'],
        'approver_user_id'      => ['nullable', 'numeric', 'min:1', 'exists:users,id'],
        'approve_limit'         => ['nullable', 'numeric', 'min:0'],
        'birthdate'             => ['nullable', 'date'],
        'identification'        => ['nullable', 'string', 'max:20'],
        'number'                => ['nullable', 'string', 'max:20'],
        'phone_type'            => ['nullable', 'string', 'max:20'],
        'postal_code'           => ['nullable', 'string', 'max:20'],
        'country'               => ['nullable', 'string', 'max:255'],
        'state'                 => ['nullable', 'string', 'max:255'],
        'city'                  => ['nullable', 'string', 'max:255'],
        'neighborhood'          => ['nullable', 'string', 'max:255'],
        'street'                => ['nullable', 'string', 'max:255'],
        'street_number'         => ['nullable', 'string'],
        'complement'            => ['nullable', 'string', 'max:255'],
    ];

    public $rulesForUpdateMessages = [
        'name.max' => '"Nome" deve ter no máximo :max caracteres.',

        'email.email'  => 'Endereço de e-mail inválido.',
        'email.max'    => '"E-mail" deve ter no máximo :max caracteres.',
        'email.unique' => 'Insira um e-mail que não esteja em uso',

        'password.min'       => '"Senha" deve ter pelo menos :min caracteres.',
        'password.confirmed' => 'As senhas não correspondem.',

        'password_confirmation' => 'Confirmação de senha necessária',

        'birthdate.date' => 'Data inválida',
    ];

    public $rulesForProduct = [
        'name'                 => ['required', 'string', 'max:255', 'min:3'],
        'description'          => ['nullable', 'string', 'max:255'],
        'unit_price'           => ['nullable', 'numeric', 'min:0'],
        'product_categorie_id' => ['nullable', 'numeric', 'min:1'],
        'updated_by'           => ['nullable', 'numeric', 'min:1'],
    ];

    public $messagesForProduct = [
        'name.required' => 'O nome é obrigatório',
        'name.min'      => 'O nome deve possuir pelo menos :min caracteres.',
        'name.max'      => 'O nome deve possuir no máximo :max caracteres.',

        'unit_price.number' => 'O preço unitário aceita apenas números.',
        'unit_price.min'    => 'O preço unitário não aceita valores negativos.',

        'updated_by.numeric' => 'O ID do usuário que atualizou o produto deve ser numérico.',
        'updated_by.min'     => 'O ID do usuário que atualizou o produto não pode ser negativo.',
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

    public function updateValidator(int $id, array $data)
    {
        $rules          = $this->rulesForUpdate;
        $messages       = $this->rulesForUpdateMessages;
        $rules['email'] = ['nullable', 'email', 'max:255', 'unique:users,email,' . $id];

        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function productValidator(array $data)
    {
        $rules     = $this->rulesForProduct;
        $messages  = $this->messagesForProduct;
        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }
}
