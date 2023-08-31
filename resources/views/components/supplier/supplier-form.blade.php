<style>
    hr {
        margin: 12px 0px;
    }
</style>
@php
    $route = $isRegister ? route('supplier.register') : route('supplier.update', ['id' => $id]);
@endphp
<form method="POST" action="{{ $route }}" class="form-validate" id="supplier-form" data-cy="supplier-form">
    @csrf

    <div class="row center-block" style="padding-bottom: 12px;">
        <div class="col-sm-6">
            <h4>DADOS FISCAIS</h4>
        </div>
        <div class="col-sm-6">
            <div class="pull-right">
                <fieldset> Consulte aqui o cartão CNPJ: </fieldset>
                <a style="display: block; color: #c49f51"
                    href="https://solucoes.receita.fazenda.gov.br/servicos/cnpjreva/cnpjreva_solicitacao.asp"
                    target="_blank" rel="noopener noreferrer">Clique aqui para a pesquisa do cartão CNPJ</a>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-2">
            <x-InputCnpj :cnpj="$supplier?->cpf_cnpj" :supplier="$supplier?->id" name="cpf_cnpj" id="cpf_cnpj" data-cy="cpf_cnpj" />
            <input type="hidden" name="entity_type" value="PJ" data-cy="entity_type">
        </div>

        <div class="col-sm-5">
            <div class="form-group">
                <label for="corporate_name" class="control-label">Razão social</label>
                <input value="{{ $supplier?->corporate_name }}" type="text" name="corporate_name" id="corporate_name"
                    data-cy="corporate_name" placeholder="Informe a razão social deste fornecedor" class="form-control"
                    data-rule-required="true" data-rule-minlength="3">
            </div>
        </div>

        <div class="col-sm-5">
            <div class="form-group">
                <label for="name" class="control-label">Nome fantasia</label>
                <input value="{{ $supplier?->name }}" type="text" name="name" id="name" data-cy="name"
                    placeholder="Informe o nome fantasia deste fornecedor" class="form-control" data-rule-minlength="3">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="description" class="control-label">Descrição</label>
                <textarea name="description" id="description" data-cy="description" placeholder="Descreva a função da empresa"
                    rows="3" class="form-control no-resize">{{ $supplier?->description }}</textarea>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="market-type" class="control-label">Tipo de mercado</label>
                <fieldset id="market-type" data-rule-required="true">
                    <div class="row">
                        <input @checked($supplier?->market_type === 'Nacional') class="icheck-me" type="radio"
                            name="market_type" id="nacional" data-cy="nacional" value="Nacional" data-skin="minimal" required>
                        <label class="form-check-label" for="nacional">Mercado nacional</label>
                    </div>
                    <div class="row">
                        <input @checked($supplier?->market_type === 'Externo') class="icheck-me" type="radio"
                            name="market_type" id="externo" data-cy="externo" value="Externo" data-skin="minimal" required>
                        <label class="form-check-label" for="externo">Mercado externo</label>
                    </div>
                    <div class="row">
                        <input @checked($supplier?->market_type === 'Prospecção') class="icheck-me" type="radio"
                            name="market_type" id="prospec" data-cy="prospec" value="Prospecção" data-skin="minimal" required>
                        <label class="form-check-label" for="prospec">Prospecção</label>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="supplier-indication" class="control-label">Indicação do fornecedor</label>
                <fieldset id="supplier-indication" data-rule-required="true">
                    <div class="row">
                        <input @checked($supplier?->supplier_indication === 'Matéria Prima') class="icheck-me" type="radio"
                            name="supplier_indication" id="materia-prima" data-cy="materia-prima" value="Matéria Prima" data-skin="minimal" required>
                        <label class="form-check-label" for="materia-prima">Matéria-prima</label>
                    </div>
                    <div class="row">
                        <input @checked($supplier?->supplier_indication === 'Serviço') class="icheck-me" type="radio"
                            name="supplier_indication" id="servico" data-cy="servico" value="Serviço" data-skin="minimal" required>
                        <label class="form-check-label" for="servico">Serviço</label>
                    </div>
                    <div class="row">
                        <input @checked($supplier?->supplier_indication === 'Ambos') class="icheck-me" type="radio"
                            name="supplier_indication" id="ambos" value="Ambos" data-cy="ambos" data-skin="minimal" required>
                        <label class="form-check-label" for="ambos">Ambos</label>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <hr>

    <div class="row center-block" style="padding-bottom: 10px;">
        <h4>ENDEREÇO</h4>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                <label for="postal_code" class="control-label">CEP</label>
                <x-InputCep name="postal_code" id="postal_code" data-cy="postal_code" :value="$supplier?->address->postal_code" />
            </div>
        </div>
        {{-- PAÍS --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="country" class="control-label">País</label>
                <input value="{{ $supplier?->address->country }}" type="text" name="country" id="country"
                    data-cy="country" placeholder="País" class="form-control" data-rule-required="true">
            </div>
        </div>
        {{-- ESTADO UF --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="state" class="control-label">Estado/UF</label>
                <input value="{{ $supplier?->address->state }}" type="text" name="state" id="state"
                    data-cy="state" placeholder="UF" class="form-control" data-rule-required="true">
            </div>
        </div>
        {{-- CIDADE --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="city" class="control-label">Cidade</label>
                <input value="{{ $supplier?->address->city }}" type="text" name="city" id="city"
                    data-cy="city" placeholder="Cidade" class="form-control" data-rule-required="true">
            </div>
        </div>
    </div>
    <div class="row">
        {{-- BAIRRO --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="neighborhood" class="control-label">Bairro</label>
                <input value="{{ $supplier?->address->neighborhood }}" type="text" name="neighborhood"
                    id="neighborhood" data-cy="neighborhood" placeholder="Bairro" class="form-control"
                    data-rule-required="true">
            </div>
        </div>
        {{-- RUA --}}
        <div class="col-sm-4">
            <div class="form-group">
                <label for="street" class="control-label">Rua</label>
                <input value="{{ $supplier?->address->street }}" type="text" name="street" id="street"
                    data-cy="street" placeholder="Rua/Avenida/Servidão" class="form-control"
                    data-rule-required="true">
            </div>
        </div>
        {{-- NUMERO --}}
        <div class="col-sm-2">
            <div class="form-group" style="margin-bottom:5px;">
                <label for="street_number" class="control-label">Número</label>
                <input value="{{ $supplier?->address->street_number }}" @readonly(collect($supplier)->isNotEmpty() && $supplier->address->street_number === null) type="text"
                    name="street_number" id="street_number" data-cy="street_number" placeholder="Nº"
                    class="form-control street-number" data-rule-required="true">
                {{-- checkbox sem numero --}}
                <div class="no-limit"
                    style="
                    display: flex;
                    align-items: center;
                    margin-top: 5px;
                    gap: 5px;
                ">
                    <input type="checkbox" id="checkbox-has-no-street-number" data-cy="checkbox-has-no-street-number"
                        class="checkbox-has-no-street-number" style="margin:0" @checked(collect($supplier)->isNotEmpty() && $supplier->address->street_number === null)>
                    <label for="checkbox-has-no-street-number" style="margin:0; font-size:13px">
                        Sem número.
                    </label>
                </div>
            </div>
        </div>
        {{-- COMPLEMENTO --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="complement" class="control-label">Complemento</label>
                <input value="{{ $supplier?->address->complement }}" type="text" name="complement"
                    id="complement" data-cy="complement" placeholder="ex: casa" class="form-control">
            </div>
        </div>
    </div>

    <hr>

    <div class="row center-block" style="padding-bottom: 10px;">
        <h4>CONTATO</h4>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="number" class="control-label">Telefone</label>
                <input value="{{ $supplier?->phone?->number }}" type="text" name="number" id="number"
                    data-cy="number" placeholder="(00) 0000-0000" class="form-control phone-number"
                    data-rule-required="true" minLength="10" maxLength="20">
                <input type="hidden" name="phone_type" id="commercial" value="commercial" data-cy="commercial">

                {{-- checkbox numero estrangeiro --}}
                <div class="international-number"
                    style="
                        display: flex;
                        align-items: center;
                        margin-top: 5px;
                        gap: 5px;
                    ">
                    <input type="checkbox" id="checkbox-international-number" data-cy="checkbox-international-number"
                        value="{{ $supplier?->phone?->is_international ? '1' : '0' }}" @checked($supplier?->phone?->is_international)
                        class="checkbox-international-number" style="margin:0" name="is_international">
                    <label for="checkbox-international-number" style="margin:0; font-size:13px">
                        Número de telefone Internacional.
                    </label>
                </div>

            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="email" class="control-label">E-mail</label>
                <input value="{{ $supplier?->email }}" type="email" name="email" id="email" data-cy="email"
                    placeholder="user_email@fornecedor.com.br" class="form-control" data-rule-email="true">
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="representative" class="control-label">Responsável/Representante</label>
                <input value="{{ $supplier?->representative }}" type="text" name="representative"
                    id="representative" data-cy="representative" placeholder="Informe o nome para contato" class="form-control" >
            </div>
        </div>
    </div>

    <hr>

    @if ($supplier)
        <div class="row">
            <div class="col-sm-3">
                <label for="qualification" class="control-label">Qualificação do fornecedor</label>
                <select name="qualification" id="qualification" data-cy="qualification" class="chosen-select form-control">
                    <option value="" selected >Selecione uma opção </option>
                    @foreach ($supplierQualificationStatus as $qualification)
                        <option value="{{ $qualification->value }}" @selected($supplier?->qualification === $qualification)>
                            {{ $qualification->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <label for="tributary_observation" class="control-label">Observações tributárias</label>
                    <textarea name="tributary_observation" id="tributary_observation" data-cy="tributary_observation" placeholder="Observações tributárias" rows="3"
                        class="form-control no-resize">{{ $supplier?->tributary_observation }}</textarea>
                </div>
            </div>
        </div>

        <hr>
    @endif

    <div class="col form-actions pull-right">
        <button type="submit" class="btn btn-primary" data-cy="btn-supplier-submit">Salvar</button>
    </div>
</form>

@if ($isAPI)
    <script src="{{ asset('js/purchase-request/register-supplier-by-api.js') }}"></script>
@endif

<script>
    $(() => {
        function setAddressRules() {
            const isChecked = $(this).is(':checked');
            const $address = $('#postal_code, #state, #city, #neighborhood, #street, #street_number');
            isChecked ? $address.removeRequired() : $address.makeRequired();
        }

        $('#is-international-supplier').on('change', setAddressRules)
    });
</script>

<script>
    $(() => {
        const $phoneNumber = $('.phone-number');
        const $streetNumber = $('.street-number');
        const $checkboxHasNoStreetNumber = $('.checkbox-has-no-street-number');

        // checkbox sem número
        $checkboxHasNoStreetNumber.on('click', function() {
            const isChecked = $(this).is(':checked');
            $streetNumber.data('rule-required', !isChecked);
            $streetNumber.valid();
            if (isChecked) {
                $(this).data('last-value', $streetNumber.val());
                $(this).closest('.form-group').removeClass('has-error');
                $(this).closest('.form-group').removeClass('has-success');
            }
            const currentValue = isChecked ? null : $(this).data('last-value');
            $streetNumber.prop('readonly', isChecked).val(currentValue).valid();
        });

        $streetNumber.imask({
            mask: Number,
        });

        // checkbox número internacional (mudança mascara)
        const $checkboxInternationalNumber = $('#checkbox-international-number');
        const checkboxInternationalNumberValue = $checkboxInternationalNumber.val();

        let phoneMask;

        if (checkboxInternationalNumberValue === "0") {
            phoneMask = $phoneNumber.imask({
                mask: [{
                        mask: '(00) 0000-0000'
                    },
                    {
                        mask: '(00) 00000-0000'
                    }
                ]
            });
        }

        $checkboxInternationalNumber.on('click', function() {
            const isChecked = $(this).is(':checked');
            $phoneNumber.valid();

            const valueToSend = isChecked ? "1" : "0";
            $(this).val(valueToSend);

            if (isChecked) {
                if ($phoneNumber.val()) {
                    $(this).closest('.form-group').removeClass('has-error');
                    $(this).closest('.form-group').removeClass('has-success');
                }
                phoneMask.destroy();
            } else {
                phoneMask = $phoneNumber.imask({
                    mask: [{
                            mask: '(00) 0000-0000'
                        },
                        {
                            mask: '(00) 00000-0000'
                        }
                    ]
                });
            }
        })
    });
</script>
