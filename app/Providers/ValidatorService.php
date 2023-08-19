<?php

namespace App\Providers;

use App\Contracts\ValidatorServiceInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorService extends ServiceProvider implements ValidatorServiceInterface
{
    public $requiredRulesForUser = [
        'name'                         => ['required', 'string', 'max:255'],
        'email'                        => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'                     => ['required', 'string', 'min:8', 'confirmed'],
        'profile_type'                 => ['required', 'string', 'max:255'],
        'cpf_cnpj'                     => ['required', 'string'],
        'number'                       => ['required', 'string'],
        'phone_type'                   => ['required', 'string'],
        'cost_center_id'               => ['required', 'string'],
        'is_buyer'                     => ['nullable', 'boolean'],
        "user_cost_center_permissions" => ['nullable', 'array'],
    ];

    public $requiredRulesForUserMessages = [
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

        "user_cost_center_permissions.array" => "O campo permissões do centro de custo do usuário deve ser um array.",
    ];

    public $rulesForUserUpdate = [
        'name'                         => ['nullable', 'string', 'max:255'],
        'email'                        => ['nullable', 'email', 'max:255', 'unique:users,email'],
        'password'                     => ['nullable', 'string', 'min:8', 'confirmed'],
        'password_confirmation'        => ['nullable', 'required_with:password', 'same:password'],
        'profile_type'                 => ['nullable', 'in:admin,normal,suprimentos_hkm,suprimentos_inp'],
        'approver_user_id'             => ['nullable', 'numeric', 'min:1', 'exists:users,id'],
        'approve_limit'                => ['nullable', 'numeric', 'min:100'],
        'birthdate'                    => ['nullable', 'date'],
        'identification'               => ['nullable', 'string', 'max:20'],
        'number'                       => ['nullable', 'string', 'max:20'],
        'phone_type'                   => ['nullable', 'string', 'max:20'],
        "user_cost_center_permissions" => ['nullable', 'array'],
    ];

    public $rulesForUserUpdateMessages = [
        'name.max' => '"Nome" deve ter no máximo :max caracteres.',

        'email.email'  => 'Endereço de e-mail inválido.',
        'email.max'    => '"E-mail" deve ter no máximo :max caracteres.',
        'email.unique' => 'Insira um e-mail que não esteja em uso',

        'password.min'       => '"Senha" deve ter pelo menos :min caracteres.',
        'password.confirmed' => 'As senhas não correspondem.',

        'password_confirmation' => 'Confirmação de senha necessária',

        'birthdate.date' => 'Data inválida',

        "user_cost_center_permissions.array" => "O campo permissões do centro de custo do usuário deve ser um array.",
    ];

    public $rulesForSupplier = [
        "cpf_cnpj"            => ['required', 'string', 'min:11'],
        "entity_type"         => ['required', 'string', 'in:PF,PJ'],
        "supplier_indication" => ['required', 'string'],
        "market_type"         => ['required', 'string'],
        "corporate_name"      => ['required', 'string', 'max:255', 'unique:suppliers'],
        "name"                => ['nullable', 'string', 'max:255'],
        "email"               => ['nullable', 'email'],
        "representative"      => ['nullable', 'string'],
        "senior_code"         => ['nullable', 'string'],
        "callisto_code"         => ['nullable', 'string'],

        'postal_code'   => ['required', 'string', 'max:20', 'min:7'],
        'country'       => ['required', 'string', 'max:255', 'min:3'],
        'state'         => ['required', 'string', 'max:255'],
        'city'          => ['required', 'string', 'max:255', 'min:3'],
        'neighborhood'  => ['required', 'string', 'max:255'],
        'street'        => ['required', 'string', 'max:255', 'min:1'],
        'street_number' => ['nullable', 'string', 'max:20', 'min:0'],
        'complement'    => ['nullable', 'string', 'max:255'],

        'number'     => ['nullable', 'string', 'max:20', 'min:8'],
        'phone_type' => ['nullable', 'string', 'max:20'],
    ];

    public $messagesForSupplier = [
        'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
        'cpf_cnpj.string'   => 'O CPF/CNPJ deve ser uma string.',
        'cpf_cnpj.min'      => 'O CPF/CNPJ deve ter no mínimo :min caracteres.',

        'entity_type.required' => 'O campo Tipo de Entidade é obrigatório.',
        'entity_type.string'   => 'O Tipo de Entidade deve ser uma string.',
        'entity_type.in'       => 'O Tipo de Entidade deve ser "PF" ou "PJ".',

        'supplier_indication.required' => 'O campo Indicação do Fonecedor é obrigatório.',
        'supplier_indication.string'   => 'O Indicação do Fonecedor deve ser uma string.',

        'market_type.required' => 'O campo Tipo de Mercado é obrigatório.',
        'market_type.string'   => 'O Tipo de Mercado deve ser uma string.',

        'corporate_name.unique' => 'O campo Razão Social deve ser único.',
        'corporate_name.required' => 'O campo Razão Social é obrigatório.',
        'corporate_name.string'   => 'A Razão Social deve ser uma string.',
        'corporate_name.max'      => 'A Razão Social deve ter no máximo :max caracteres.',

        'name.string' => 'O nome deve ser uma string.',
        'name.max'    => 'O nome deve ter no máximo :max caracteres.',

        'email.email' => 'Digite um endereço de e-mail válido.',

        'representative.string' => 'O representante deve ser uma string.',

        'postal_code.required' => 'O campo CEP é obrigatório.',
        'postal_code.string'   => 'O CEP deve ser uma string.',
        'postal_code.max'      => 'O CEP deve ter no máximo :max caracteres.',
        'postal_code.min'      => 'O CEP deve ter no mínimo :min caracteres.',

        'country.required' => 'O campo País é obrigatório.',
        'country.string'   => 'O país deve ser uma string.',
        'country.max'      => 'O país deve ter no máximo :max caracteres.',
        'country.min'      => 'O país deve ter no mínimo :min caracteres.',

        'state.required' => 'O campo Estado é obrigatório.',
        'state.string'   => 'O estado deve ser uma string.',
        'state.max'      => 'O estado deve ter no máximo :max caracteres.',

        'city.required' => 'O campo Cidade é obrigatório.',
        'city.string'   => 'A cidade deve ser uma string.',
        'city.max'      => 'A cidade deve ter no máximo :max caracteres.',
        'city.min'      => 'A cidade deve ter no mínimo :min caracteres.',

        'neighborhood.required' => 'O campo Bairro é obrigatório.',
        'neighborhood.string'   => 'O bairro deve ser uma string.',
        'neighborhood.max'      => 'O bairro deve ter no máximo :max caracteres.',

        'street.required' => 'O campo Rua é obrigatório.',
        'street.string'   => 'A rua deve ser uma string.',
        'street.max'      => 'A rua deve ter no máximo :max caracteres.',
        'street.min'      => 'A rua deve ter no minimo :min caracteres.',

        'street_number.max' => 'O número da rua deve ter no máximo :max caracteres.',
        'street_number.min' => 'O número da rua deve ter no mínimo :min caracteres.',

        'complement.string' => 'O complemento deve ser uma string.',
        'complement.max'    => 'O complemento deve ter no máximo :max caracteres.',

        'number.required' => 'O campo Telefone é obrigatório.',
        'number.string'   => 'O número de Telefone deve ser uma string.',
        'number.max'      => 'O número de Telefone deve ter no máximo :max caracteres.',
        'number.min'      => 'O número de Telefone deve ter no mínimo :min caracteres.',

        'phone_type.required' => 'O campo Tipo de Telefone é obrigatório.',
        'phone_type.string'   => 'O tipo de Telefone deve ser uma string.',
        'phone_type.max'      => 'O tipo de Telefone deve ter no máximo :max caracteres.',
    ];

    public $rulesForSupplierUpdate = [
        "cpf_cnpj"            => ['required', 'string', 'min:11'],
        "entity_type"         => ['required', 'string', 'in:PF,PJ'],
        "supplier_indication" => ['required', 'string'],
        "market_type"         => ['required', 'string'],
        "corporate_name"      => ['required', 'string', 'max:255'],
        "name"                => ['nullable', 'string', 'max:255'],
        "email"               => ['nullable', 'email'],
        "representative"      => ['nullable', 'string'],
        "senior_code"         => ['nullable', 'string'],
        "callisto_code"         => ['nullable', 'string'],

        'postal_code'   => ['required', 'string', 'max:20', 'min:7'],
        'country'       => ['required', 'string', 'max:255', 'min:3'],
        'state'         => ['required', 'string', 'max:255'],
        'city'          => ['required', 'string', 'max:255', 'min:3'],
        'neighborhood'  => ['required', 'string', 'max:255'],
        'street'        => ['required', 'string', 'max:255', 'min:1'],
        'street_number' => ['nullable', 'string', 'max:20', 'min:0'],
        'complement'    => ['nullable', 'string', 'max:255'],

        'number'     => ['nullable', 'string', 'max:15', 'min:8'],
        'phone_type' => ['nullable', 'string', 'max:20'],
    ];

    public $messagesForSupplierUpdate = [
        'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
        'cpf_cnpj.string'   => 'O CPF/CNPJ deve ser uma string.',
        'cpf_cnpj.min'      => 'O CPF/CNPJ deve ter no mínimo :min caracteres.',

        'entity_type.required' => 'O campo Tipo de Entidade é obrigatório.',
        'entity_type.string'   => 'O Tipo de Entidade deve ser uma string.',
        'entity_type.in'       => 'O Tipo de Entidade deve ser "PF" ou "PJ".',

        'supplier_indication.required' => 'O campo Indicação do Fonecedor é obrigatório.',
        'supplier_indication.string'   => 'O Indicação do Fonecedor deve ser uma string.',

        'market_type.required' => 'O campo Tipo de Mercado é obrigatório.',
        'market_type.string'   => 'O Tipo de Mercado deve ser uma string.',

        'corporate_name.required' => 'O campo Razão Social é obrigatório.',
        'corporate_name.string'   => 'A Razão Social deve ser uma string.',
        'corporate_name.max'      => 'A Razão Social deve ter no máximo :max caracteres.',

        'name.string' => 'O nome deve ser uma string.',
        'name.max'    => 'O nome deve ter no máximo :max caracteres.',

        'email.email' => 'Digite um endereço de e-mail válido.',

        'representative.string' => 'O representante deve ser uma string.',

        'postal_code.required' => 'O campo CEP é obrigatório.',
        'postal_code.string'   => 'O CEP deve ser uma string.',
        'postal_code.max'      => 'O CEP deve ter no máximo :max caracteres.',
        'postal_code.min'      => 'O CEP deve ter no mínimo :min caracteres.',

        'country.required' => 'O campo País é obrigatório.',
        'country.string'   => 'O país deve ser uma string.',
        'country.max'      => 'O país deve ter no máximo :max caracteres.',
        'country.min'      => 'O país deve ter no mínimo :min caracteres.',

        'state.required' => 'O campo Estado é obrigatório.',
        'state.string'   => 'O estado deve ser uma string.',
        'state.max'      => 'O estado deve ter no máximo :max caracteres.',

        'city.required' => 'O campo Cidade é obrigatório.',
        'city.string'   => 'A cidade deve ser uma string.',
        'city.max'      => 'A cidade deve ter no máximo :max caracteres.',
        'city.min'      => 'A cidade deve ter no mínimo :min caracteres.',

        'neighborhood.required' => 'O campo Bairro é obrigatório.',
        'neighborhood.string'   => 'O bairro deve ser uma string.',
        'neighborhood.max'      => 'O bairro deve ter no máximo :max caracteres.',

        'street.required' => 'O campo Rua é obrigatório.',
        'street.string'   => 'A rua deve ser uma string.',
        'street.max'      => 'A rua deve ter no máximo :max caracteres.',
        'street.min'      => 'A rua deve ter no minimo :min caracteres.',

        'street_number.max' => 'O número da rua deve ter no máximo :max caracteres.',
        'street_number.min' => 'O número da rua deve ter no mínimo :min caracteres.',

        'complement.string' => 'O complemento deve ser uma string.',
        'complement.max'    => 'O complemento deve ter no máximo :max caracteres.',

        'number.required' => 'O campo Telefone é obrigatório.',
        'number.string'   => 'O número de Telefone deve ser uma string.',
        'number.max'      => 'O número de Telefone deve ter no máximo :max caracteres.',
        'number.min'      => 'O número de Telefone deve ter no mínimo :min caracteres.',

        'phone_type.required' => 'O campo Tipo de Telefone é obrigatório.',
        'phone_type.string'   => 'O tipo de Telefone deve ser uma string.',
        'phone_type.max'      => 'O tipo de Telefone deve ter no máximo :max caracteres.',
    ];

    public $rulesForPurchaseRequest = [
        'cost_center_apportionments'                            => ['required', 'array'],
        'cost_center_apportionments.*.cost_center_id'           => ['required', 'numeric', 'min:1'],
        'cost_center_apportionments.*.apportionment_percentage' => ['required_without:cost_center_apportionments.*.apportionment_currency', 'nullable', 'numeric', 'min:0', 'max:100'],
        'cost_center_apportionments.*.apportionment_currency'   => ['required_without:cost_center_apportionments.*.apportionment_percentage', 'nullable', 'numeric', 'min:0'],
        'is_comex'                                              => ['required', 'boolean'],
        'reason'                                                => ['required', 'string'],
        'description'                                           => ['nullable', 'string'],
        'desired_date'                                          => ['nullable', 'date'],
        'purchase_request_files'                                => ['nullable', 'array'],
        'purchase_request_files.*.path'                         => ['nullable', 'string'],
    ];

    public $messagesForPurchaseRequest = [
        'cost_center_apportionments.required'                                    => 'O campo de rateios de centro de custo é obrigatório.',
        'cost_center_apportionments.array'                                       => 'O campo de rateios de centro de custo deve ser um array.',
        'cost_center_apportionments.*.cost_center_id.required'                   => 'O ID do centro de custo é obrigatório.',
        'cost_center_apportionments.*.cost_center_id.numeric'                    => 'O ID do centro de custo deve ser um número.',
        'cost_center_apportionments.*.cost_center_id.min'                        => 'O ID do centro de custo deve ser no mínimo :min.',
        'cost_center_apportionments.*.apportionment_percentage.required_without' => 'Informe o percentual de rateio ou o valor de rateio.',
        'cost_center_apportionments.*.apportionment_percentage.numeric'          => 'O percentual de rateio deve ser um número.',
        'cost_center_apportionments.*.apportionment_percentage.min'              => 'O percentual de rateio deve ser no mínimo :min.',
        'cost_center_apportionments.*.apportionment_percentage.max'              => 'O percentual de rateio deve ser no máximo :max.',
        'cost_center_apportionments.*.apportionment_currency.required_without'   => 'Informe o percentual de rateio ou o valor de rateio.',
        'cost_center_apportionments.*.apportionment_currency.numeric'            => 'O valor de rateio deve ser um número.',
        'cost_center_apportionments.*.apportionment_currency.min'                => 'O valor de rateio deve ser no mínimo :min.',

        'is_comex.required' => 'O campo de comex é obrigatório.',
        'is_comex.boolean'  => 'O campo de comex deve ser um valor booleano.',

        'reason.required' => 'o motivo da compra é obrigatória.',
        'reason.string'   => 'o motivo da compra deve ser uma string.',

        'description.string' => 'A descrição deve ser uma string.',

        'desired_date.date' => 'A data desejada deve estar em um formato válido.',

        'purchase_request_files.array'         => 'Os arquivos de solicitação de cotação devem ser um array.',

        'purchase_request_files.*.path.string' => 'O caminho do arquivo deve ser uma string.',
    ];
    public $rulesForPurchaseRequestUpdate = [
        'cost_center_apportionments'                            => ['nullable', 'array'],
        'cost_center_apportionments.*.cost_center_id'           => ['nullable', 'numeric', 'min:1'],
        'cost_center_apportionments.*.apportionment_percentage' => ['required_without:cost_center_apportionments.*.apportionment_currency', 'nullable', 'numeric', 'min:0', 'max:100'],
        'cost_center_apportionments.*.apportionment_currency'   => ['required_without:cost_center_apportionments.*.apportionment_percentage', 'nullable', 'numeric', 'min:0'],
        'is_comex'                                              => ['nullable', 'boolean'],
        'reason'                                                => ['nullable', 'string'],
        'description'                                           => ['nullable', 'string'],
        'desired_date'                                          => ['nullable', 'date'],
        'purchase_request_files'                                => ['nullable', 'array'],
        'purchase_request_files.*.path'                         => ['nullable', 'string'],
    ];

    public $messagesForPurchaseRequestUpdate = [
        'cost_center_apportionments.array'                                       => 'O campo de rateios de centro de custo deve ser um array.',
        'cost_center_apportionments.*.cost_center_id.numeric'                    => 'O ID do centro de custo deve ser um número.',
        'cost_center_apportionments.*.cost_center_id.min'                        => 'O ID do centro de custo deve ser no mínimo :min.',
        'cost_center_apportionments.*.apportionment_percentage.required_without' => 'Informe o percentual de rateio ou o valor de rateio.',
        'cost_center_apportionments.*.apportionment_percentage.numeric'          => 'O percentual de rateio deve ser um número.',
        'cost_center_apportionments.*.apportionment_percentage.min'              => 'O percentual de rateio deve ser no mínimo :min.',
        'cost_center_apportionments.*.apportionment_percentage.max'              => 'O percentual de rateio deve ser no máximo :max.',
        'cost_center_apportionments.*.apportionment_currency.required_without'   => 'Informe o percentual de rateio ou o valor de rateio.',
        'cost_center_apportionments.*.apportionment_currency.numeric'            => 'O valor de rateio deve ser um número.',
        'cost_center_apportionments.*.apportionment_currency.min'                => 'O valor de rateio deve ser no mínimo :min.',

        'is_comex.boolean'  => 'O campo de comex deve ser um valor booleano.',

        'reason.string'   => 'o motivo da compra deve ser uma string.',

        'description.string' => 'A descrição deve ser uma string.',

        'desired_date.date' => 'A data desejada deve estar em um formato válido.',

        'purchase_request_files.array'         => 'Os arquivos de solicitação de cotação devem ser um array.',
        'purchase_request_files.*.path.string' => 'O caminho do arquivo deve ser uma string.',
    ];

    public function registerValidator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, $this->requiredRulesForUser, $this->requiredRulesForUserMessages);
    }

    public function updateValidator(int $id, array $data)
    {
        $rules = $this->rulesForUserUpdate;
        $messages = $this->rulesForUserUpdateMessages;
        $rules['email'] = ['nullable', 'email', 'max:255', 'unique:users,email,' . $id];

        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function supplier(array $data)
    {
        $rules = $this->rulesForSupplier;
        $messages  = $this->messagesForSupplier;
        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function supplierUpdate(array $data)
    {
        $rules = $this->rulesForSupplierUpdate;
        $messages  = $this->messagesForSupplierUpdate;
        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function purchaseRequest(array $data)
    {
        $rules = $this->rulesForPurchaseRequest;
        $messages  = $this->messagesForPurchaseRequest;
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

            if ($hasPercentage && $totalPercentage !== 100) {
                $validator->errors()->add('cost_center_apportionments', 'A soma das porcentagens de rateio deve ser igual a 100%.');
            }
        });

        return $validator;
    }

    public function purchaseRequestUpdate(array $data)
    {
        $rules = $this->rulesForPurchaseRequestUpdate;
        $messages  = $this->messagesForPurchaseRequestUpdate;
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

                if ($hasPercentage && $totalPercentage !== 100) {
                    $validator->errors()->add('cost_center_apportionments', 'A soma das porcentagens de rateio deve ser igual a 100%.');
                }
            });
        }

        return $validator;
    }
}
