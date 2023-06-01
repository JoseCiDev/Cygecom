<form method="POST" action=" {{ $isRegister ? route('supplierRegister') : route('supplierUpdate', ['id' => $id]) }}">
    @csrf

    <div class="row center-block" style="padding-bottom: 12px;">
        <h4>DADOS FISCAIS</h4>
    </div>
    <div class="row">

        <div class="col-sm-2">
            <div class="form-group">
                <label for="cpf_cnpj" class="control-label"><sup style="color:red">*</sup>CNPJ</label>
                <input value="{{$supplier->cpf_cnpj}}"
                        type="text" name="cpf_cnpj" id="cpf_cnpj" placeholder="00.000.000/0000-00" class="form-control mask_cnpj @error('cpf_cnpj') border-red @enderror">
            </div>
            <input type="hidden" name="entity_type" value="PJ">
        </div>

        <div class="col-sm-5">
            <div class="form-group">
                <label for="corporate_name" class="control-label"><sup style="color:red">*</sup>Razão social</label>
                <input value="{{$supplier->corporate_name}}"
                        type="text" name="corporate_name" id="corporate_name" placeholder="Informe a razão social deste fornecedor" class="form-control @error('corporate_name') border-red @enderror">
            </div>
        </div>

        <div class="col-sm-5">
            <div class="form-group">
                <label for="name" class="control-label">Nome fantasia</label>
                <input value="{{$supplier->name}}" 
                        type="text" name="name" id="name" placeholder="Informe o nome fantasia deste fornecedor" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="description" class="control-label">Descrição</label>
                <textarea name="description" id="description" placeholder="Descreva a função da empresa" rows="3" class="form-control no-resize">{{$supplier->description}}</textarea>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Tipo de mercado</label>
                <div class="row @error('market_type') border-red @enderror">
                    <input @if ($supplier->market_type === 'nacional') checked @endif
                            class="icheck-me" type="radio" name="market_type" id="nacional" value="nacional"  data-skin="minimal">
                    <label class="form-check-label" for="nacional">Mercado nacional</label>
                </div>
                <div class="row @error('market_type') border-red @enderror">
                    <input  @if ($supplier->market_type === 'externo') checked @endif 
                            class="icheck-me" type="radio" name="market_type" id="externo" value="externo" data-skin="minimal">
                    <label class="form-check-label" for="externo">Mercado externo</label>
                </div>
                <div class="row @error('market_type') border-red @enderror">
                    <input  @if ($supplier->market_type === 'prospec') checked @endif 
                            class="icheck-me" type="radio" name="market_type" id="prospec" value="prospec" data-skin="minimal">
                    <label class="form-check-label" for="prospec">Prospecção</label>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Indicação do fornecedor</label>
                <div class="row  @error('supplier_indication') border-red @enderror">
                    <input @if ($supplier->supplier_indication === 'M') checked @endif 
                            class="icheck-me" type="radio" name="supplier_indication" id="materia-prima" value="M"  data-skin="minimal">
                    <label class="form-check-label" for="materia-prima">Matéria-prima</label>
                </div>
                <div class="row  @error('supplier_indication') border-red @enderror">
                    <input @if ($supplier->supplier_indication === 'S') checked @endif 
                            class="icheck-me" type="radio" name="supplier_indication" id="servico" value="S" data-skin="minimal">
                    <label class="form-check-label" for="servico">Serviço</label>
                </div>
                <div class="row  @error('supplier_indication') border-red @enderror">
                    <input @if ($supplier->supplier_indication === 'A') checked @endif 
                            class="icheck-me" type="radio" name="supplier_indication" id="ambos" value="A" data-skin="minimal">
                    <label class="form-check-label" for="ambos">Ambos</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row center-block" style="padding-bottom: 10px;">
        <h4>ENDEREÇO</h4>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                <label for="postal_code" class="control-label"><sup style="color:red">*</sup>CEP</label>
                <input value="{{$supplier->address->postal_code ?? null}}"
                        type="text" name="postal_code" id="postal_code" placeholder="00.000-000" class="form-control mask_cep @error('postal_code') border-red @enderror" >
            </div>
        </div>
        {{-- PAÍS --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="country" class="control-label"><sup style="color:red">*</sup>País</label>
                <input value="{{$supplier->address->country ?? null}}"
                        type="text" name="country" id="country" placeholder="País" class="form-control @error('country') border-red @enderror" >
            </div>
        </div>
        {{-- ESTADO UF --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="state" class="control-label"><sup style="color:red">*</sup>Estado/UF</label>
                <input value="{{$supplier->address->state ?? null}}"
                        type="text" name="state" id="state" placeholder="UF" class="form-control @error('state') border-red @enderror" >
            </div>
        </div>
        {{-- CIDADE --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="city" class="control-label"><sup style="color:red">*</sup>Cidade</label>
                <input value="{{$supplier->address->city ?? null}}"
                        type="text" name="city" id="city" placeholder="Cidade" class="form-control @error('city') border-red @enderror" >
            </div>
        </div>
        {{-- BAIRRO --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="neighborhood" class="control-label"><sup style="color:red">*</sup>Bairro</label>
                <input value="{{$supplier->address->neighborhood ?? null}}"
                        type="text" name="neighborhood" id="neighborhood" placeholder="Bairro" class="form-control @error('neighborhood') border-red @enderror">
            </div>
        </div>
        {{-- RUA --}}
        <div class="col-sm-4">
            <div class="form-group">
                <label for="street" class="control-label"><sup style="color:red">*</sup>Rua</label>
                <input value="{{$supplier->address->street ?? null}}"
                        type="text" name="street" id="street" placeholder="Rua/Avenida/Servidão" class="form-control @error('street') border-red @enderror" >
            </div>
        </div>
        {{-- NUMERO --}}
        <div class="col-sm-2">
            <div class="form-group">
                <label for="street_number" class="control-label"><sup style="color:red">*</sup>Número</label>
                <input value="{{$supplier->address->street_number ?? null}}"
                        type="number" name="street_number" id="street_number" placeholder="Nº" class="form-control @error('street_number') border-red @enderror">
            </div>
        </div>
        {{-- COMPLEMENTO --}}
        <div class="col-sm-3">
            <div class="form-group">
                <label for="complement" class="control-label">Complemento</label>
                <input value="{{$supplier->address->complement ?? null}}"
                        type="text" name="complement" id="complement" placeholder="ex: casa" class="form-control">
            </div>
        </div>
    </div>

    <div class="row center-block" style="padding-bottom: 10px;">
        <h4>CONTATO</h4>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="number" class="control-label"><sup style="color:red">*</sup>Telefone</label>
                <input value="{{$supplier->phone->number ?? null}}"
                        type="text" name="number" id="number" placeholder="(00) 0000-0000" class="form-control mask_phone @error('number') border-red @enderror">
                <input type="hidden" name="phone_type" id="commercial" value="commercial" >
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="email" class="control-label">E-mail</label>
                <input value="{{$supplier->email ?? null}}"
                        type="email" name="email" id="email" placeholder="user_email@fornecedor.com.br" class="form-control @error('email') border-red @enderror" data-rule-email="true">
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <label for="representative" class="control-label">Responsável</label>
                <input value="{{$supplier->representative}}"
                        type="text" name="representative" id="representative" placeholder="Informe o nome para contato" class="form-control">
            </div>
        </div>
    </div>

    <div class="row center-block">
        <h4>Valores para Callisto</h4>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="supplier_type_callisto" class="control-label">Tipo de fornecedor (Callisto):</label>
                <input value="{{$supplier->supplier_type_callisto}}"
                        type="text" name="supplier_type_callisto" id="supplier_type_callisto" class="form-control">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="payment_type_callisto" class="control-label">Tipo de pagamento (Callisto):</label>
                <input value="{{$supplier->payment_type_callisto}}"
                        type="text" name="payment_type_callisto" id="payment_type_callisto" class="form-control">
            </div>
        </div>
    </div>

    <div class="col form-actions pull-right">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
    </div>
</form>