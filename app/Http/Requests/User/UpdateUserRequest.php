<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{ProfileType, ArrayOfIntenger};

class UpdateUserRequest extends FormRequest
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
                'nullable',
                'string',
                'max:255',
                Rule::unique(table: 'people')
                    ->ignore(id: $this->user->person->id)
                    ->withoutTrashed()
            ],
            'name' => [
                'nullable',
                'string',
                'max:255'
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique(table: 'users')
                    ->ignore(id: $this->user->id)
                    ->withoutTrashed()
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed'
            ],
            'password_confirmation' => [
                'nullable',
                'required_with:password',
                'same:password'
            ],
            'profile_type' => [
                'nullable',
                'string',
                new ProfileType
            ],
            'approver_user_id' => [
                'nullable',
                'numeric',
                'min:1',
                'exists:users,id'
            ],
            'approve_limit' => [
                'nullable',
                'numeric',
                'min:100'
            ],
            'birthdate' => [
                'nullable',
                'date'
            ],
            'identification' => [
                'nullable',
                'string',
                'max:20'
            ],
            'number' => [
                'nullable',
                'string',
                'max:20'
            ],
            'phone_type' => [
                'nullable',
                'string',
                'max:20'
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
            'cpf_cnpj.unique' => 'Insira um CPF/CNPJ que não esteja em uso',

            'name.max' => '"Nome" deve ter no máximo :max caracteres.',

            'email.email' => 'Endereço de e-mail inválido.',
            'email.max' => '"E-mail" deve ter no máximo :max caracteres.',
            'email.unique' => 'Insira um e-mail que não esteja em uso',

            'password.min' => '"Senha" deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'As senhas não correspondem.',

            'password_confirmation' => 'Confirmação de senha necessária',

            'birthdate.date' => 'Data inválida',
        ];
    }
}
