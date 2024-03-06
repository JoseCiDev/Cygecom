<?php

namespace App\Providers;

use Illuminate\Validation\Rule;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorService extends ServiceProvider
{
    public $rulesForSupplier = [
        "cpf_cnpj" => ['nullable', 'string', 'min:11'],
        "entity_type" => ['required', 'string', 'in:PF,PJ'],
        "supplier_indication" => ['required', 'string'],
        "market_type" => ['required', 'string'],
        "corporate_name" => ['required', 'string', 'max:255', 'unique:suppliers'],
        "name" => ['nullable', 'string', 'max:255'],
        "email" => ['nullable', 'email'],
        "representative" => ['nullable', 'string'],
        "senior_code" => ['nullable', 'string'],
        "callisto_code" => ['nullable', 'string'],

        'postal_code' => ['nullable', 'string', 'max:20', 'min:7'],
        'country' => ['required', 'string', 'max:255', 'min:3'],
        'state' => ['nullable', 'string', 'max:255'],
        'city' => ['nullable', 'string', 'max:255', 'min:3'],
        'neighborhood' => ['nullable', 'string', 'max:255'],
        'street' => ['nullable', 'string', 'max:255', 'min:1'],
        'street_number' => ['nullable', 'string', 'max:20', 'min:0'],
        'complement' => ['nullable', 'string', 'max:255'],

        'number' => ['nullable', 'string', 'max:20', 'min:8'],
        'phone_type' => ['nullable', 'string', 'max:20'],
    ];

    public $messagesForSupplier = [
        'cpf_cnpj.string' => 'O CPF/CNPJ deve ser uma string.',
        'cpf_cnpj.min' => 'O CPF/CNPJ deve ter no mínimo :min caracteres.',
        'cpf_cnpj.unique' => "O CNPJ já existe em nosso banco de dados e deve ser único. Por favor, verifique novamente o campo.",

        'entity_type.required' => 'O campo Tipo de Entidade é obrigatório.',
        'entity_type.string' => 'O Tipo de Entidade deve ser uma string.',
        'entity_type.in' => 'O Tipo de Entidade deve ser "PF" ou "PJ".',

        'supplier_indication.required' => 'O campo Indicação do Fonecedor é obrigatório.',
        'supplier_indication.string' => 'O Indicação do Fonecedor deve ser uma string.',

        'market_type.required' => 'O campo Tipo de Mercado é obrigatório.',
        'market_type.string' => 'O Tipo de Mercado deve ser uma string.',

        'corporate_name.unique' => 'O campo Razão Social deve ser único.',
        'corporate_name.required' => 'O campo Razão Social é obrigatório.',
        'corporate_name.string' => 'A Razão Social deve ser uma string.',
        'corporate_name.max' => 'A Razão Social deve ter no máximo :max caracteres.',

        'name.string' => 'O nome deve ser uma string.',
        'name.max' => 'O nome deve ter no máximo :max caracteres.',

        'email.email' => 'Digite um endereço de e-mail válido.',

        'representative.string' => 'O representante deve ser uma string.',

        'postal_code.string' => 'O CEP deve ser uma string.',
        'postal_code.max' => 'O CEP deve ter no máximo :max caracteres.',
        'postal_code.min' => 'O CEP deve ter no mínimo :min caracteres.',

        'country.required' => 'O campo País é obrigatório.',
        'country.string' => 'O país deve ser uma string.',
        'country.max' => 'O país deve ter no máximo :max caracteres.',
        'country.min' => 'O país deve ter no mínimo :min caracteres.',

        'state.string' => 'O estado deve ser uma string.',
        'state.max' => 'O estado deve ter no máximo :max caracteres.',

        'city.string' => 'A cidade deve ser uma string.',
        'city.max' => 'A cidade deve ter no máximo :max caracteres.',
        'city.min' => 'A cidade deve ter no mínimo :min caracteres.',

        'neighborhood.string' => 'O bairro deve ser uma string.',
        'neighborhood.max' => 'O bairro deve ter no máximo :max caracteres.',

        'street.string' => 'A rua deve ser uma string.',
        'street.max' => 'A rua deve ter no máximo :max caracteres.',
        'street.min' => 'A rua deve ter no minimo :min caracteres.',

        'street_number.max' => 'O número da rua deve ter no máximo :max caracteres.',
        'street_number.min' => 'O número da rua deve ter no mínimo :min caracteres.',

        'complement.string' => 'O complemento deve ser uma string.',
        'complement.max' => 'O complemento deve ter no máximo :max caracteres.',

        'number.required' => 'O campo Telefone é obrigatório.',
        'number.string' => 'O número de Telefone deve ser uma string.',
        'number.max' => 'O número de Telefone deve ter no máximo :max caracteres.',
        'number.min' => 'O número de Telefone deve ter no mínimo :min caracteres.',

        'phone_type.required' => 'O campo Tipo de Telefone é obrigatório.',
        'phone_type.string' => 'O tipo de Telefone deve ser uma string.',
        'phone_type.max' => 'O tipo de Telefone deve ter no máximo :max caracteres.',
    ];

    public $rulesForSupplierUpdate = [
        "cpf_cnpj" => ['nullable', 'string', 'min:11'],
        "entity_type" => ['required', 'string', 'in:PF,PJ'],
        "supplier_indication" => ['required', 'string'],
        "market_type" => ['required', 'string'],
        "corporate_name" => ['required', 'string', 'max:255'],
        "name" => ['nullable', 'string', 'max:255'],
        "email" => ['nullable', 'email'],
        "representative" => ['nullable', 'string'],
        "senior_code" => ['nullable', 'string'],
        "callisto_code" => ['nullable', 'string'],

        'postal_code' => ['nullable', 'string', 'max:20', 'min:7'],
        'country' => ['required', 'string', 'max:255', 'min:3'],
        'state' => ['nullable', 'string', 'max:255'],
        'city' => ['nullable', 'string', 'max:255', 'min:3'],
        'neighborhood' => ['nullable', 'string', 'max:255'],
        'street' => ['nullable', 'string', 'max:255', 'min:1'],
        'street_number' => ['nullable', 'string', 'max:20', 'min:0'],
        'complement' => ['nullable', 'string', 'max:255'],

        'number' => ['nullable', 'string', 'max:15', 'min:8'],
        'phone_type' => ['nullable', 'string', 'max:20'],
    ];

    public $messagesForSupplierUpdate = [
        'cpf_cnpj.string' => 'O CPF/CNPJ deve ser uma string.',
        'cpf_cnpj.min' => 'O CPF/CNPJ deve ter no mínimo :min caracteres.',

        'entity_type.required' => 'O campo Tipo de Entidade é obrigatório.',
        'entity_type.string' => 'O Tipo de Entidade deve ser uma string.',
        'entity_type.in' => 'O Tipo de Entidade deve ser "PF" ou "PJ".',

        'supplier_indication.required' => 'O campo Indicação do Fonecedor é obrigatório.',
        'supplier_indication.string' => 'O Indicação do Fonecedor deve ser uma string.',

        'market_type.required' => 'O campo Tipo de Mercado é obrigatório.',
        'market_type.string' => 'O Tipo de Mercado deve ser uma string.',

        'corporate_name.required' => 'O campo Razão Social é obrigatório.',
        'corporate_name.string' => 'A Razão Social deve ser uma string.',
        'corporate_name.max' => 'A Razão Social deve ter no máximo :max caracteres.',

        'name.string' => 'O nome deve ser uma string.',
        'name.max' => 'O nome deve ter no máximo :max caracteres.',

        'email.email' => 'Digite um endereço de e-mail válido.',

        'representative.string' => 'O representante deve ser uma string.',

        'postal_code.string' => 'O CEP deve ser uma string.',
        'postal_code.max' => 'O CEP deve ter no máximo :max caracteres.',
        'postal_code.min' => 'O CEP deve ter no mínimo :min caracteres.',

        'country.required' => 'O campo País é obrigatório.',
        'country.string' => 'O país deve ser uma string.',
        'country.max' => 'O país deve ter no máximo :max caracteres.',
        'country.min' => 'O país deve ter no mínimo :min caracteres.',

        'state.string' => 'O estado deve ser uma string.',
        'state.max' => 'O estado deve ter no máximo :max caracteres.',

        'city.string' => 'A cidade deve ser uma string.',
        'city.max' => 'A cidade deve ter no máximo :max caracteres.',
        'city.min' => 'A cidade deve ter no mínimo :min caracteres.',

        'neighborhood.string' => 'O bairro deve ser uma string.',
        'neighborhood.max' => 'O bairro deve ter no máximo :max caracteres.',

        'street.string' => 'A rua deve ser uma string.',
        'street.max' => 'A rua deve ter no máximo :max caracteres.',
        'street.min' => 'A rua deve ter no minimo :min caracteres.',

        'street_number.max' => 'O número da rua deve ter no máximo :max caracteres.',
        'street_number.min' => 'O número da rua deve ter no mínimo :min caracteres.',

        'complement.string' => 'O complemento deve ser uma string.',
        'complement.max' => 'O complemento deve ter no máximo :max caracteres.',

        'number.required' => 'O campo Telefone é obrigatório.',
        'number.string' => 'O número de Telefone deve ser uma string.',
        'number.max' => 'O número de Telefone deve ter no máximo :max caracteres.',
        'number.min' => 'O número de Telefone deve ter no mínimo :min caracteres.',

        'phone_type.required' => 'O campo Tipo de Telefone é obrigatório.',
        'phone_type.string' => 'O tipo de Telefone deve ser uma string.',
        'phone_type.max' => 'O tipo de Telefone deve ter no máximo :max caracteres.',
    ];

    public $rulesForPurchaseRequest = [
        'cost_center_apportionments' => ['required', 'array'],
        'cost_center_apportionments.*.cost_center_id' => ['required', 'numeric', 'min:1'],
        'cost_center_apportionments.*.apportionment_percentage' => ['required_without:cost_center_apportionments.*.apportionment_currency', 'nullable', 'numeric', 'min:0', 'max:100'],
        'cost_center_apportionments.*.apportionment_currency' => ['required_without:cost_center_apportionments.*.apportionment_percentage', 'nullable', 'numeric', 'min:0'],
        'is_comex' => ['required', 'boolean'],
        'reason' => ['required', 'string'],
        'description' => ['nullable', 'string'],
        'desired_date' => ['nullable', 'date'],
        'purchase_request_files' => ['nullable', 'array'],
        'purchase_request_files.*.path' => ['nullable', 'string'],
        'purchase_request_products.*.products.*.link' => ['nullable', 'url', 'max:500']
    ];

    public $messagesForPurchaseRequest = [
        'cost_center_apportionments.required' => 'O campo de rateios de centro de custo é obrigatório.',
        'cost_center_apportionments.array' => 'O campo de rateios de centro de custo deve ser um array.',
        'cost_center_apportionments.*.cost_center_id.required' => 'O ID do centro de custo é obrigatório.',
        'cost_center_apportionments.*.cost_center_id.numeric' => 'O ID do centro de custo deve ser um número.',
        'cost_center_apportionments.*.cost_center_id.min' => 'O ID do centro de custo deve ser no mínimo :min.',
        'cost_center_apportionments.*.apportionment_percentage.required_without' => 'Informe o percentual de rateio ou o valor de rateio.',
        'cost_center_apportionments.*.apportionment_percentage.numeric' => 'O percentual de rateio deve ser um número.',
        'cost_center_apportionments.*.apportionment_percentage.min' => 'O percentual de rateio deve ser no mínimo :min.',
        'cost_center_apportionments.*.apportionment_percentage.max' => 'O percentual de rateio deve ser no máximo :max.',
        'cost_center_apportionments.*.apportionment_currency.required_without' => 'Informe o percentual de rateio ou o valor de rateio.',
        'cost_center_apportionments.*.apportionment_currency.numeric' => 'O valor de rateio deve ser um número.',
        'cost_center_apportionments.*.apportionment_currency.min' => 'O valor de rateio deve ser no mínimo :min.',

        'is_comex.required' => 'O campo de comex é obrigatório.',
        'is_comex.boolean' => 'O campo de comex deve ser um valor booleano.',

        'reason.required' => 'o motivo da compra é obrigatória.',
        'reason.string' => 'o motivo da compra deve ser uma string.',

        'description.string' => 'A descrição deve ser uma string.',

        'desired_date.date' => 'A data desejada deve estar em um formato válido.',

        'purchase_request_files.array' => 'Os arquivos de solicitação de cotação devem ser um array.',

        'purchase_request_files.*.path.string' => 'O caminho do arquivo deve ser uma string.',

        'purchase_request_products.*.products.*.link' => 'Link de produto deve estar em um formato válido.'
    ];
    public $rulesForPurchaseRequestUpdate = [
        'cost_center_apportionments' => ['nullable', 'array'],
        'cost_center_apportionments.*.cost_center_id' => ['nullable', 'numeric', 'min:1'],
        'cost_center_apportionments.*.apportionment_percentage' => ['required_without:cost_center_apportionments.*.apportionment_currency', 'nullable', 'numeric', 'min:0', 'max:100'],
        'cost_center_apportionments.*.apportionment_currency' => ['required_without:cost_center_apportionments.*.apportionment_percentage', 'nullable', 'numeric', 'min:0'],
        'is_comex' => ['nullable', 'boolean'],
        'reason' => ['nullable', 'string'],
        'description' => ['nullable', 'string'],
        'desired_date' => ['nullable', 'date'],
        'purchase_request_files' => ['nullable', 'array'],
        'purchase_request_files.*.path' => ['nullable', 'string'],
    ];

    public $messagesForPurchaseRequestUpdate = [
        'cost_center_apportionments.array' => 'O campo de rateios de centro de custo deve ser um array.',
        'cost_center_apportionments.*.cost_center_id.numeric' => 'O ID do centro de custo deve ser um número.',
        'cost_center_apportionments.*.cost_center_id.min' => 'O ID do centro de custo deve ser no mínimo :min.',
        'cost_center_apportionments.*.apportionment_percentage.required_without' => 'Informe o percentual de rateio ou o valor de rateio.',
        'cost_center_apportionments.*.apportionment_percentage.numeric' => 'O percentual de rateio deve ser um número.',
        'cost_center_apportionments.*.apportionment_percentage.min' => 'O percentual de rateio deve ser no mínimo :min.',
        'cost_center_apportionments.*.apportionment_percentage.max' => 'O percentual de rateio deve ser no máximo :max.',
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

    public function supplier(array $data, $cnpj)
    {
        $rules = $this->rulesForSupplier;
        $messages = $this->messagesForSupplier;

        if (!empty($cnpj)) {
            $uniqueRule = Rule::unique('suppliers')->where(function ($query) use ($data) {
                return $query->where('cpf_cnpj', $data['cpf_cnpj']);
            });

            $rules['cpf_cnpj'][] = $uniqueRule;
        }

        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function supplierUpdate(array $data)
    {
        $rules = $this->rulesForSupplierUpdate;
        $messages = $this->messagesForSupplierUpdate;
        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function purchaseRequest(array $data)
    {
        $rules = $this->rulesForPurchaseRequest;
        $messages = $this->messagesForPurchaseRequest;

        if (isset($data['contract']['name'])) {
            $rules['contract.name'] = ["unique:contracts,name"];
            $messages['contract.name.unique'] = 'Desculpe, já existe outro serviço recorrente com esse nome.';
        }

        if (isset($data['service']['name'])) {
            $rules['service.name'] = ["unique:services,name"];
            $messages['service.name.unique'] = 'Desculpe, já existe outro serviço com esse nome.';
        }

        $validator = Validator::make($data, $rules, $messages);

        $validator->after(function ($validator) use ($data) {
            $totalPercentage = 0;
            $hasPercentage = false;

            foreach ($data['cost_center_apportionments'] as $apportionment) {
                if (isset($apportionment['apportionment_percentage'])) {
                    $totalPercentage += $apportionment['apportionment_percentage'];
                    $hasPercentage = true;
                }
            }

            if ($hasPercentage && $totalPercentage != 100) {
                $validator->errors()->add('cost_center_apportionments', 'A soma das porcentagens de rateio deve ser igual a 100%.');
            }
        });

        return $validator;
    }

    public function purchaseRequestUpdate(array $data)
    {
        $rules = $this->rulesForPurchaseRequestUpdate;
        $messages = $this->messagesForPurchaseRequestUpdate;
        $validator = Validator::make($data, $rules, $messages);

        if (isset($data['cost_center_apportionments'])) {
            $validator->after(function ($validator) use ($data) {
                $totalPercentage = 0;
                $hasPercentage = false;

                foreach ($data['cost_center_apportionments'] as $apportionment) {
                    if (isset($apportionment['apportionment_percentage'])) {
                        $totalPercentage += $apportionment['apportionment_percentage'];
                        $hasPercentage = true;
                    }
                }

                if ($hasPercentage && $totalPercentage != 100) {
                    $validator->errors()->add('cost_center_apportionments', 'A soma das porcentagens de rateio deve ser igual a 100%.');
                }
            });
        }

        return $validator;
    }
}
