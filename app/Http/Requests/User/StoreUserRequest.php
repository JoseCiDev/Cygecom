<?php

namespace App\Http\Requests\User;

use App\Rules\{ArrayOfIntenger, ProfileType, UniqueCpfCnpj, UniqueEmail};
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cpf_cnpj' => [
                'required',
                'string',
                'max:255',
                new UniqueCpfCnpj,
            ],
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'max:255',
                'email',
                new UniqueEmail
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
            'profile_type' => [
                'required',
                'string',
                'max:255',
                new ProfileType
            ],
            'number' => [
                'required',
                'string'
            ],
            'phone_type' => [
                'required',
                'string'
            ],
            'cost_center_id' => [
                'required',
                'string'
            ],
            'is_buyer' => [
                'nullable',
                'boolean'
            ],
            'user_cost_center_permissions' => [
                'nullable',
                new ArrayOfIntenger
            ],
            'supplies_cost_centers' => [
                'nullable',
                new ArrayOfIntenger
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Campo "Nome" é obrigatório.',
            'name.max' => 'Campo "Nome" deve ter no máximo :max caracteres',

            'email.required' => '"E-mail" é obrigatório',
            'email.email' => 'E-mail inválido.',
            'email.max' => 'E-mail deve ter no máximo :max caracteres',
            'email.unique' => 'Este e-mail já está sendo usado.',

            'profile_type.required' => '"Tipo de usuário" é obrigatório.',
            'profile_type.max' => '"Tipo de usuário" deve ter no máximo :max',

            'birthdate.date' => 'Data inválida',

            'cpf_cnpj.required' => '"CPF/CNPJ" é obrigatório.',
            'cpf_cnpj.unique' => 'Desculpe, já existe um usuário cadastrado com esse CPF/CNPJ. Por favor, verifique o campo novamente.',

            'number.required' => '"Telefone/Celular" é obrigatório.',

            'cost_center_id.required' => 'Centro de custo é obrigatório',

            'is_buyer.boolean' => 'A pessoa de ter o campo "é comprador" como verdadeiro ou false.',
        ];
    }
}
