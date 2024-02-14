<?php

namespace App\Http\Requests\Supplies;

class UpdateServiceRequest extends SuppliesUpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['service.price'] = $rules['type'];
        unset($rules['type']);

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = parent::messages();

        $messages['service.price.required_if'] = 'O valor total é obrigatório se a solicitação for finalizada.';
        $messages['service.price.numeric'] = 'Valor total inválido.';

        return $messages;
    }
}
