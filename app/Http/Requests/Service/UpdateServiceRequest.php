<?php

namespace App\Http\Requests\Service;

use App\Rules\{PurchaseOrderIfStatusFinish, CostCenterApportionmentPercentage};
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
        $rules = [
            'service.*.name' => ['unique:services.name'],
            'cost_center_apportionments' => ['nullable', 'array'],
            'cost_center_apportionments.*.cost_center_id' => ['nullable', 'numeric', 'min:1'],
            'cost_center_apportionments.*.apportionment_percentage' => new CostCenterApportionmentPercentage(
                $this->input('cost_center_apportionments.*.apportionment_percentage'),
                $this->input('cost_center_apportionments.*.apportionment_currency')
            ),
            'cost_center_apportionments.*.apportionment_currency' => ['required_without:cost_center_apportionments.*.apportionment_percentage', 'nullable', 'numeric', 'min:0'],
            'is_comex' => ['nullable', 'boolean'],
            'reason' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'desired_date' => ['nullable', 'date'],
            'purchase_request_files' => ['nullable', 'array'],
            'purchase_request_files.*.path' => ['nullable', 'string'],
            'purchase_order' => new PurchaseOrderIfStatusFinish($this->input('status')),
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
            'service.name' => 'Desculpe, já existe outro serviço pontual com esse nome.',
            'cost_center_apportionments.array' => 'O campo de rateios de centro de custo deve ser um array.',
            'cost_center_apportionments.*.cost_center_id.numeric' => 'O ID do centro de custo deve ser um número.',
            'cost_center_apportionments.*.cost_center_id.min' => 'O ID do centro de custo deve ser no mínimo :min.',
            'cost_center_apportionments.*.apportionment_currency.required_without' => 'Informe o percentual de rateio ou o valor de rateio.',
            'cost_center_apportionments.*.apportionment_currency.numeric' => 'O valor de rateio deve ser um número.',
            'cost_center_apportionments.*.apportionment_currency.min' => 'O valor de rateio deve ser no mínimo :min.',

            'is_comex.boolean' => 'O campo de comex deve ser um valor booleano.',

            'reason.string' => 'o motivo da compra deve ser uma string.',

            'description.string' => 'A descrição deve ser uma string.',

            'desired_date.date' => 'A data desejada deve estar em um formato válido.',

            'purchase_request_files.array' => 'Os arquivos de solicitação de cotação devem ser um array.',
            'purchase_request_files.*.path.string' => 'O caminho do arquivo deve ser uma string.',
        ];
    }
}
