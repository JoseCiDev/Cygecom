<?php

namespace App\Http\Requests\Supplies;

use Illuminate\Validation\Rule;
use App\Enums\PurchaseRequestStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{PurchaseOrderIfStatusFinish, PurchaseRequestRequiredPrice};

class UpdateServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $auth_rules = [
            $this->purchaseRequest->user_id !== Auth::id()
        ];

        return ! in_array(false, $auth_rules);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $enumValues = collect(PurchaseRequestStatus::cases())->pluck('value')->all();

        return [
            'status' => [
                'required',
                Rule::in($enumValues),
            ],
            'service.price' => [
                'nullable',
                'numeric',
                'required_if:status,' . PurchaseRequestStatus::FINALIZADA->value,
            ],
            'purchase_order' => [
                new PurchaseOrderIfStatusFinish($this->input('status')),
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
            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'Status inválido.',

            'service.price.required_if' => 'O valor total é obrigatório se a solicitação for finalizada.',
            'service.price.numeric' => 'Valor total inválido.',

            'purchase_order' => 'A ordem de compra é inválida.',
            'purchase_request_files.*.path.string' => 'O caminho do arquivo deve ser uma string.',
        ];
    }
}
