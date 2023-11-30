<?php

namespace App\Http\Requests\Supplies;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CompanyGroup;
use App\Enums\PurchaseRequestStatus;

class SuppliesParamsRequest extends FormRequest
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
        $companiesGroups = collect(CompanyGroup::cases())->pluck('value')->join(',');
        $statusValues = collect(PurchaseRequestStatus::cases())->pluck('value')
            ->filter(fn ($status) => $status !== PurchaseRequestStatus::RASCUNHO->value)
            ->join(',');

        $rules = [
            'status' => ['nullable', 'array', "in:$statusValues"],
            'companies-group' => ['nullable', 'array', "in:$companiesGroups"]
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
            'status.in' => 'Status inválido!',
            'companies-group.in' => 'Grupo deve ser INP ou HKM!',
        ];
    }
}
