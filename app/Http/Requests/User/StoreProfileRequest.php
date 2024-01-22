<?php

namespace App\Http\Requests\User;

use App\Rules\ArrayOfIntenger;
use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:30', 'min:4', 'unique:user_profiles', 'regex:/^[a-z_]+$/u'],
            'abilities' => [new ArrayOfIntenger]
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
            'name.required' => 'Campo "Nome do perfil" é obrigatório.',
            'name.string' => 'Campo "Nome do perfil" deve ser um tipo de dado válido.',
            'name.max' => 'Campo "Nome do perfil" deve ter no máximo :max caracteres.',
            'name.min' => 'Campo "Nome do perfil" deve ter no máximo :min caracteres.',
            'name.unique' => '"Nome do perfil" deve ser único.',
            'name.regex' => '"Nome do perfil" não pode conter espaços, números, acentos, ou caracteres especiais, exceto _ para separação de palavras.',
        ];
    }
}
