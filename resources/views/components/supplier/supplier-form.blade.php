<style>
    hr {
        margin: 12px 0px;
    }
</style>

<form method="POST" action=" {{ $isRegister ? route('supplierRegister') : route('supplierUpdate', ['id' => $id]) }}"
    class="form-validate" id="supplier-form">
    @csrf

    <div class="row center-block" style="padding-bottom: 12px;">
        <h4>DADOS FISCAIS</h4>
    </div>
    <div class="row">

        <div class="col-sm-2">
            <div class="form-group">
                <label for="cpf_cnpj" class="control-label">CNPJ</label>
                <input value="{{ $supplier?->cpf_cnpj }}" type="text" name="cpf_cnpj" id="cpf_cnpj"
                    placeholder="00.000.000/0000-00" class="form-control cpf-cnpj" data-rule-required="true"
                    minLength="18">
            </div>
            <input type="hidden" name="entity_type" value="PJ">
        </div>

        <div class="col-sm-5">
            <div class="form-group">
                <label for="corporate_name" class="control-label">Razão social</label>
                <input value="{{ $supplier?->corporate_name }}" type="text" name="corporate_name" id="corporate_name"
                    placeholder="Informe a razão social deste fornecedor" class="form-control" data-rule-required="true"
                    data-rule-minlength="3">
            </div>
        </div>

        <div class="col-sm-5">
            <div class="form-group">
                <label for="name" class="control-label">Nome fantasia</label>
                <input value="{{ $supplier?->name }}" type="text" name="name" id="name"
                    placeholder="Informe o nome fantasia deste fornecedor" class="form-control"
                    data-rule-required="true" data-rule-minlength="3">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="description" class="control-label">Descrição</label>
                <textarea name="description" id="description" placeholder="Descreva a função da empresa" rows="3"
                    class="form-control no-resize">{{ $supplier?->description }}</textarea>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Tipo de mercado<sup style="color:red">*</sup></label>
                <div class="row">
                    <input @if ($supplier?->market_type === 'nacional') checked @endif class="icheck-me" type="radio"
                        name="market_type" id="nacional" value="nacional" data-skin="minimal">
                    <label class="form-check-label" for="nacional">Mercado nacional</label>
                </div>
                <div class="row">
                    <input @if ($supplier?->market_type === 'externo') checked @endif class="icheck-me" type="radio"
                        name="market_type" id="externo" value="externo" data-skin="minimal">
                    <label class="form-check-label" for="externo">Mercado externo</label>
                </div>
                <div class="row">
                    <input @if ($supplier?->market_type === 'prospec') checked @endif class="icheck-me" type="radio"
                        name="market_type" id="prospec" value="prospec" data-skin="minimal">
                    <label class="form-check-label" for="prospec">Prospecção</label>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Indicação do fornecedor<sup style="color:red">*</sup></label>
                <div class="row">
                    <input @if ($supplier?->supplier_indication === 'M') checked @endif class="icheck-me" type="radio"
                        name="supplier_indication" id="materia-prima" value="M" data-skin="minimal">
                    <label class="form-check-label" for="materia-prima">Matéria-prima</label>
                </div>
                <div class="row">
                    <input @if ($supplier?->supplier_indication === 'S') checked @endif class="icheck-me" type="radio"
                        name="supplier_indication" id="servico" value="S" data-skin="minimal">
                    <label class="form-check-label" for="servico">Serviço</label>
                </div>
                <div class="row">
                    <input @if ($supplier?->supplier_indication === 'A') checked @endif class="icheck-me" type="radio"
                        name="supplier_indication" id="ambos" value="A" data-skin="minimal">
                    <label class="form-check-label" for="ambos">Ambos</label>
                </div>
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
                <input value="{{ $supplier?->address->postal_code }}" type="text" name="postal_code"
                    id="postal_code" placeholder="00.000-000" class="form-control postal-code"
                    data-rule-required="true" data-rule-minlength="10">
            </div>
        </div>
        {{-- PAÍS --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="country" class="control-label">País</label>
                <input value="{{ $supplier?->address->country }}" type="text" name="country"
                    id="country" placeholder="País" class="form-control" data-rule-required="true">
            </div>
        </div>
        {{-- ESTADO UF --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="state" class="control-label">Estado/UF</label>
                <input value="{{ $supplier?->address->state }}" type="text" name="state" id="state"
                    placeholder="UF" class="form-control" data-rule-required="true">
            </div>
        </div>
        {{-- CIDADE --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="city" class="control-label">Cidade</label>
                <input value="{{ $supplier?->address->city }}" type="text" name="city" id="city"
                    placeholder="Cidade" class="form-control" data-rule-required="true">
            </div>
        </div>
    </div>
    <div class="row">
        {{-- BAIRRO --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="neighborhood" class="control-label">Bairro</label>
                <input value="{{ $supplier?->address->neighborhood }}" type="text" name="neighborhood"
                    id="neighborhood" placeholder="Bairro" class="form-control" data-rule-required="true">
            </div>
        </div>
        {{-- RUA --}}
        <div class="col-sm-4">
            <div class="form-group">
                <label for="street" class="control-label">Rua</label>
                <input value="{{ $supplier?->address->street }}" type="text" name="street"
                    id="street" placeholder="Rua/Avenida/Servidão" class="form-control"
                    data-rule-required="true">
            </div>
        </div>
        {{-- NUMERO --}}
        <div class="col-sm-2">
            <div class="form-group" style="margin-bottom:5px;">
                <label for="street_number" class="control-label">Número</label>
                <input
                    value="{{ $supplier?->address->street_number }}"
                    @readonly(collect($supplier)->isNotEmpty() && $supplier->address->street_number === null)
                    type="text" name="street_number"
                    id="street_number" placeholder="Nº" class="form-control street-number"
                    data-rule-required="true"
                >
                {{-- checkbox sem numero --}}
                <div class="no-limit"
                    style="
                    display: flex;
                    align-items: center;
                    margin-top: 5px;
                    gap: 5px;
                ">
                    <input type="checkbox" id="checkbox-has-no-street-number" class="checkbox-has-no-street-number"
                        style="margin:0"
                        @checked(collect($supplier)->isNotEmpty() && $supplier->address->street_number === null)
                    >
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
                    id="complement" placeholder="ex: casa" class="form-control">
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
                <input value="{{ $supplier?->phone->number }}" type="text" name="number" id="number"
                    placeholder="(00) 0000-0000" class="form-control phone-number" data-rule-required="true"
                    minLength="14">
                <input type="hidden" name="phone_type" id="commercial" value="commercial">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="email" class="control-label">E-mail</label>
                <input value="{{ $supplier?->email }}" type="email" name="email" id="email"
                    placeholder="user_email@fornecedor.com.br" class="form-control" data-rule-email="true"
                    data-rule-required="true">
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="representative" class="control-label">Responsável/Representante</label>
                <input value="{{ $supplier?->representative }}" type="text" name="representative"
                    id="representative" placeholder="Informe o nome para contato" class="form-control"
                    data-rule-required="true">
            </div>
        </div>
    </div>

    <hr>

    <div class="row center-block">
        <h4>Valores para Callisto</h4>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="supplier_type_callisto" class="control-label">Tipo de fornecedor:</label>
                <input value="{{ $supplier?->supplier_type_callisto }}" type="text" name="supplier_type_callisto"
                    id="supplier_type_callisto" class="form-control" data-rule-required="true">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="payment_type_callisto" class="control-label">Tipo de pagamento:</label>
                <input value="{{ $supplier?->payment_type_callisto }}" type="text" name="payment_type_callisto"
                    id="payment_type_callisto" class="form-control" data-rule-required="true">
            </div>
        </div>
    </div>

    <div class="col form-actions pull-right">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
    </div>
</form>


<script>
    $(() => {
        const $identificationDocument = $('.cpf-cnpj');
        const $postalCode = $('.postal-code');
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

        // masks
        $identificationDocument.imask({
            mask: '00.000.000/0000-00'
        });
        $postalCode.imask({
            mask: '00.000-000'
        });
        $streetNumber.imask({
            mask: Number,
        });
        $phoneNumber.imask({
            mask: [{
                    mask: '(00) 0000-0000'
                },
                {
                    mask: '(00) 00000-0000'
                }
            ]
        });
    });
</script>
