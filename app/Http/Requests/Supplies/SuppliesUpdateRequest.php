<?php

namespace App\Http\Requests\Supplies;

use App\Enums\CompanyGroup;
use Illuminate\Validation\Rule;
use App\Enums\PurchaseRequestStatus;
use Illuminate\Support\Facades\Auth;
use App\Rules\PurchaseOrderIfStatusFinish;
use Illuminate\Foundation\Http\FormRequest;

class SuppliesUpdateRequest extends FormRequest
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
        $status_values = collect(PurchaseRequestStatus::cases())
            ->pluck('value')
            ->filter(fn ($status) => $status !== PurchaseRequestStatus::RASCUNHO->value);

        $rules = [
            'status' => [
                'required',
                Rule::in($status_values),
            ],
            // Chave 'type' é substituído na classe filha
            'type' => [
                'nullable',
                'numeric',
                'required_if:status,' . PurchaseRequestStatus::FINALIZADA->value,
            ],
            'purchase_order' => [
                new PurchaseOrderIfStatusFinish($this->input('status')),
            ],
        ];

        return $rules;
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

            'purchase_order' => 'Ordem de compra inválida.',
            'purchase_request_files.*.path.string' => 'O caminho do arquivo deve ser uma string.',
        ];
    }
}
