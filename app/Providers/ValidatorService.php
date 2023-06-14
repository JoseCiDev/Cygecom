<?php

namespace App\Providers;

use App\Contracts\ValidatorServiceInterface;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorService extends ServiceProvider implements ValidatorServiceInterface
{
    public $requiredRules = [
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

    public $requiredRulesMessages = [
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

    public $rulesForUpdate = [
        'name'                         => ['nullable', 'string', 'max:255'],
        'email'                        => ['nullable', 'email', 'max:255', 'unique:users,email'],
        'password'                     => ['nullable', 'string', 'min:8', 'confirmed'],
        'password_confirmation'        => ['nullable', 'required_with:password', 'same:password'],
        'profile_type'                 => ['nullable', 'in:admin,normal'],
        'approver_user_id'             => ['nullable', 'numeric', 'min:1', 'exists:users,id'],
        'approve_limit'                => ['nullable', 'numeric', 'min:0'],
        'birthdate'                    => ['nullable', 'date'],
        'identification'               => ['nullable', 'string', 'max:20'],
        'number'                       => ['nullable', 'string', 'max:20'],
        'phone_type'                   => ['nullable', 'string', 'max:20'],
        'postal_code'                  => ['nullable', 'string', 'max:20'],
        'country'                      => ['nullable', 'string', 'max:255'],
        'state'                        => ['nullable', 'string', 'max:255'],
        'city'                         => ['nullable', 'string', 'max:255'],
        'neighborhood'                 => ['nullable', 'string', 'max:255'],
        'street'                       => ['nullable', 'string', 'max:255'],
        'street_number'                => ['nullable', 'string'],
        'complement'                   => ['nullable', 'string', 'max:255'],
        "user_cost_center_permissions" => ['nullable', 'array'],
    ];

    public $rulesForUpdateMessages = [
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

    public $rulesForProduct = [
        'name'                 => ['required', 'string', 'max:255', 'min:3'],
        'description'          => ['nullable', 'string', 'max:255'],
        'unit_price'           => ['nullable', 'numeric', 'min:0'],
        'product_categorie_id' => ['nullable', 'numeric', 'min:1'],
        'updated_by'           => ['nullable', 'numeric', 'min:1'],
    ];

    public $messagesForProduct = [
        'name.required' => 'O nome é obrigatório',
        'name.min'      => 'O nome deve possuir pelo menos :min caracteres.',
        'name.max'      => 'O nome deve possuir no máximo :max caracteres.',

        'unit_price.number' => 'O preço unitário aceita apenas números.',
        'unit_price.min'    => 'O preço unitário não aceita valores negativos.',

        'updated_by.numeric' => 'O ID do usuário que atualizou o produto deve ser numérico.',
        'updated_by.min'     => 'O ID do usuário que atualizou o produto não pode ser negativo.',
    ];

    public $rulesForSupplier = [
        "cpf_cnpj"            => ['required', 'string', 'min:11'],
        "entity_type"         => ['required', 'string', 'in:PF,PJ'],
        "supplier_indication" => ['required', 'string', 'in:M,S,A'],
        "market_type"         => ['required', 'string'],
        "corporate_name"      => ['required', 'string', 'max:255'],
        "name"                => ['nullable', 'string', 'max:255'],
        "email"               => ['nullable', 'email'],
        "representative"      => ['nullable', 'string'],

        'postal_code'   => ['required', 'string', 'max:20'],
        'country'       => ['required', 'string', 'max:255'],
        'state'         => ['required', 'string', 'max:255'],
        'city'          => ['required', 'string', 'max:255'],
        'neighborhood'  => ['required', 'string', 'max:255'],
        'street'        => ['required', 'string', 'max:255'],
        'street_number' => ['required', 'string', 'max:20'],
        'complement'    => ['nullable', 'string', 'max:255'],

        'number'     => ['required', 'string', 'max:20'],
        'phone_type' => ['required', 'string', 'max:20'],
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
        'supplier_indication.in'       => 'O Indicação do Fonecedor deve ser "M", "S" ou "A".',

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

        'country.required' => 'O campo País é obrigatório.',
        'country.string'   => 'O país deve ser uma string.',
        'country.max'      => 'O país deve ter no máximo :max caracteres.',

        'state.required' => 'O campo Estado é obrigatório.',
        'state.string'   => 'O estado deve ser uma string.',
        'state.max'      => 'O estado deve ter no máximo :max caracteres.',

        'city.required' => 'O campo Cidade é obrigatório.',
        'city.string'   => 'A cidade deve ser uma string.',
        'city.max'      => 'A cidade deve ter no máximo :max caracteres.',

        'neighborhood.required' => 'O campo Bairro é obrigatório.',
        'neighborhood.string'   => 'O bairro deve ser uma string.',
        'neighborhood.max'      => 'O bairro deve ter no máximo :max caracteres.',

        'street.required' => 'O campo Rua é obrigatório.',
        'street.string'   => 'A rua deve ser uma string.',
        'street.max'      => 'A rua deve ter no máximo :max caracteres.',

        'street_number.required' => 'O campo Número é obrigatório.',
        'street_number.string'   => 'O número da rua deve ser uma string.',
        'street_number.max'      => 'O número da rua deve ter no máximo :max caracteres.',

        'complement.string' => 'O complemento deve ser uma string.',
        'complement.max'    => 'O complemento deve ter no máximo :max caracteres.',

        'number.required' => 'O campo Telefone é obrigatório.',
        'number.string'   => 'O número de Telefone deve ser uma string.',
        'number.max'      => 'O número de Telefone deve ter no máximo :max caracteres.',

        'phone_type.required' => 'O campo Tipo de Telefone é obrigatório.',
        'phone_type.string'   => 'O tipo de Telefone deve ser uma string.',
        'phone_type.max'      => 'O tipo de Telefone deve ter no máximo :max caracteres.',
    ];

    public $rulesForQuoteRequest = [
        'cost_center_apportionments'                            => ['required', 'array'],
        'cost_center_apportionments.*.cost_center_id'           => ['required', 'numeric', 'min:1'],
        'cost_center_apportionments.*.apportionment_percentage' => ['required_without:cost_center_apportionments.*.apportionment_currency', 'nullable', 'numeric', 'min:0', 'max:100'],
        'cost_center_apportionments.*.apportionment_currency'   => ['required_without:cost_center_apportionments.*.apportionment_percentage', 'nullable', 'numeric', 'min:0'],
        'is_service'                                            => ['required', 'boolean'],
        'is_supplies_quote'                                     => ['required', 'boolean'],
        'is_comex'                                              => ['required', 'boolean'],
        'local_description'                                     => ['required', 'string'],
        'reason'                                                => ['required', 'string'],
        'description'                                           => ['nullable', 'string'],
        'desired_date'                                          => ['nullable', 'date'],
        'quote_request_files'                                   => ['nullable', 'array'],
        'quote_request_files.*.path'                            => ['nullable', 'string'],
    ];

    public $messagesForQuoteRequest = [
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

        'is_service.required' => 'O campo de serviço é obrigatório.',
        'is_service.boolean'  => 'O campo de serviço deve ser um valor booleano.',

        'is_supplies_quote.required' => 'O campo de cotação de suprimentos é obrigatório.',
        'is_supplies_quote.boolean'  => 'O campo de cotação de suprimentos deve ser um valor booleano.',

        'is_comex.required' => 'O campo de comex é obrigatório.',
        'is_comex.boolean'  => 'O campo de comex deve ser um valor booleano.',

        'local_description.required' => 'A descrição local é obrigatória.',
        'local_description.string'   => 'A descrição local deve ser uma string.',

        'reason.required' => 'o motivo da compra é obrigatória.',
        'reason.string'   => 'o motivo da compra deve ser uma string.',

        'description.string' => 'A descrição deve ser uma string.',

        'desired_date.date' => 'A data desejada deve estar em um formato válido.',

        'quote_request_files.array'         => 'Os arquivos de solicitação de cotação devem ser um array.',
        'quote_request_files.*.path.string' => 'O caminho do arquivo deve ser uma string.',
    ];

    public function registerValidator(array $data)
    {
        try {
            $validator = Validator::make($data, $this->requiredRules, $this->requiredRulesMessages);

            return $validator;
        } catch (Exception $error) {
            return back()->withErrors($error->getMessage())->withInput();
        }
    }

    public function updateValidator(int $id, array $data)
    {
        $rules          = $this->rulesForUpdate;
        $messages       = $this->rulesForUpdateMessages;
        $rules['email'] = ['nullable', 'email', 'max:255', 'unique:users,email,' . $id];

        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function productValidator(array $data)
    {
        $rules     = $this->rulesForProduct;
        $messages  = $this->messagesForProduct;
        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function supplier(array $data)
    {
        $rules     = $this->rulesForSupplier;
        $messages  = $this->messagesForSupplier;
        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }

    public function quoteRequest(array $data)
    {
        $rules     = $this->rulesForQuoteRequest;
        $messages  = $this->messagesForQuoteRequest;
        $validator = Validator::make($data, $rules, $messages);

        return $validator;
    }
}
