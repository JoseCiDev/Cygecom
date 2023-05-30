<x-app>
    <x-slot name="title">
        <h1>Novo Fornecedor</h1>
    </x-slot>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-color box-bordered">

                <div class="box-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="pull-left">Cadastrar novo</h3>
                        </div>
                    </div>
                </div>

                <div class="box-content">
                    <div class="row center-block" style="padding-bottom: 12px;">
                        <h4>DADOS FISCAIS</h4>
                    </div>
                    <div class="row">
                        {{-- CNPJ --}}
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="identification" class="control-label"><sup style="color:red">*</sup>CNPJ</label>
                                <input
                                type="text"
                                name="identification"
                                id="identification"
                                data-rule-required="true"
                                placeholder="00.000.000/0000-00"
                                class="form-control mask_cnpj">
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="identification" class="control-label"><sup style="color:red">*</sup>RAZÃO SOCIAL</label>
                                <input
                                type="text"
                                name="identification"
                                id="identification"
                                data-rule-required="true"
                                placeholder="Informe a razão social deste fornecedor"
                                class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="identification" class="control-label">NOME FANTASIA</label>
                                <input
                                type="text"
                                name="identification"
                                id="identification"
                                data-rule-required="true"
                                placeholder="Informe o nome fantasia deste fornecedor"
                                class="form-control">
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
                                <input
                                type="text"
                                name="number"
                                id="number"
                                placeholder="(00) 0000-0000"
                                class="form-control mask_phone"
                                data-rule-required="true">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="email" class="control-label"><sup style="color:red">*</sup>E-mail</label>
                                <input
                                type="email"
                                name="email"
                                id="email"
                                placeholder="user_email@fornecedor.com.br"
                                class="form-control" data-rule-required="true" data-rule-email="true">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="identification" class="control-label">Responsável</label>
                                <input
                                type="text"
                                name="identification"
                                id="identification"
                                data-rule-required="true"
                                placeholder="Informe o nome para contato"
                                class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row center-block" style="padding-bottom: 10px;">
                        <h4>ENDEREÇO</h4>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="postal_code" class="control-label">CEP</label>
                                <input
                                type="text"
                                name="postal_code"
                                id="postal_code"
                                placeholder="00.000-000"
                                class="form-control mask_cep" >
                            </div>
                        </div>
                        {{-- PAÍS --}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="country" class="control-label">País</label>
                                <input
                                type="text"
                                name="country"
                                id="country"
                                placeholder="País"
                                class="form-control" >
                            </div>
                        </div>
                        {{-- ESTADO UF --}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="state" class="control-label">Estado/UF</label>
                                <input
                                type="text"
                                name="state"
                                id="state"
                                placeholder="UF"
                                class="form-control" >
                            </div>
                        </div>
                        {{-- CIDADE --}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="city" class="control-label">Cidade</label>
                                <input
                                type="text"
                                name="city"
                                id="city"
                                placeholder="Cidade"
                                class="form-control"
                                @if(isset($user))
                                    value="{{ $user['person']['address']['city'] }}"
                                @endif >
                                @error('city')<strong>{{ $message }}</strong>@enderror
                            </div>
                        </div>
                        {{-- BAIRRO --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="neighborhood" class="control-label">Bairro</label>
                                <input
                                type="text"
                                name="neighborhood"
                                id="neighborhood"
                                placeholder="Bairro"
                                class="form-control">
                            </div>
                        </div>
                        {{-- RUA --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="street" class="control-label">Rua</label>
                                <input
                                type="text"
                                name="street"
                                id="street"
                                placeholder="Rua/Avenida/Servidão"
                                class="form-control" >
                            </div>
                        </div>
                        {{-- NUMERO --}}
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="street_number" class="control-label">Número</label>
                                <input
                                type="number"
                                name="street_number"
                                id="street_number"
                                placeholder="Nº"
                                class="form-control">
                            </div>
                        </div>
                        {{-- COMPLEMENTO --}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="complement" class="control-label">Complemento</label>
                                <input
                                type="text"
                                name="complement"
                                id="complement"
                                placeholder="ex: casa"
                                class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions pull-right">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app>
