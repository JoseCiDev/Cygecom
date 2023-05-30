<x-app>

<style>
    #suppliers-container .box-content {
        border-bottom: none;
        border-top: 2px solid #204e81;
    }
    #suppliers-container .box-content.btn-container {
        border-top: none;
        border-bottom: 2px solid #204e81;
    }
</style>

    <x-slot name="title">
        <h1>Nova Cotação</h1>
    </x-slot>

    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Formulário para preenchimento das informações necessárias para abrir uma requisição de compra. Para cada CNPJ, é possível cadastrar vários produtos de uma mesma categoria. É preciso também informar a quantidade de cada produto. Se preferir, pode ser inserido um link de sugestão de produto.
    </div>

    <div class="start-contaienr">
        <div class="col-sm-12">
            <div class="row center-block" style="padding-bottom: 10px;">
                <h4>DADOS SOLICITAÇÃO</h4>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <label for="form-check" class="control-label" style="margin-bottom: 12px;">Já existe uma solicitação aberta para inicar a nova cotação?</label>
                    <div class="form-check" style="display:inline;">
                        <input
                            class="radio_request"
                            id="radio-request"
                            type="radio"
                            name="has_request"
                            value="1"
                            servicesdata-skin="minimal"
                            style="background-color:black; margin-left:10px;"
                        >
                        <label class="radio-has-request" for="services" style="margin-right:15px;">SIM</label>

                        <input checked
                            class="radio-has-request"
                            id="radio-has-request"
                            type="radio"
                            name="has_request"
                            value="0"
                            productsdata-skin="minimal"
                        >
                        <label class="form-check-label" for="personal">NÃO</label>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- SELECIONAR SOLICITAÇÃO - SE EXISTIR --}}
                {{-- <div class="col-sm-6" style="margin-top:10px;">
                    <div class="form-group">
                        <label
                            for="textfield" class="control-label"
                            style="margin-right:5px;"
                        >
                            SOLICITAÇÃO
                        </label>
                        <select name="request[][cnpj]" id="s2" class='select2-me' style="width:80%" data-placeholder="Escolha uma solicitação">
                            <option value=""></option>
                            <option value="1">Nº 102 - Suprimentos - INP Filial - RECURSOS HUMANOS - 4.8</option>
                            <option value="3">HKM - 06.354.562/0001-10 </option>
                            <option value="4">HKM - 06.354.562/0001-10 </option>
                        </select>
                    </div>
                </div> --}}
            </div>

            <hr>

            <div class="box-content">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h4>CONTRATANTE</h4>
                </div>
                <div class="row cnpj-row" data-cnpj="1">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="textfield" class="control-label">Centro de custo da despesa</label>
                            <div class="select">
                                <select
                                name="request[][cost_center]"
                                id="batatinhas"
                                placeholder="Ex: SMART MATRIZ - Conferência de Saída" class='select2-me' style="width:100%;">
                                    <option value="" disalbed></option>
                                    <option value="1" disalbed>INP Filial - CONGRESSO E EVENTOS - 3.3</option>
                                    <option value="2" disalbed>INP Filial - RECURSOS HUMANOS - 4.8</option>
                                    <option value="3" disalbed>INP Filial - FINANCEIRO - 4.4</option>
                                    <option value="4" disalbed>INP Filial - MARKETING - 3.5</option>
                                    <option value="5" disalbed>INP Filial - P&D - 3.4</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="unit_price" class="control-label"><sup style="color:red">*</sup>Rateio</label>
                            <div class="input-group">
                                <span class="input-group-addon">%</span>
                                <input type="number" name="unit_price" id="unit_price_percentage" placeholder="0.00" class="form-control" min="0">
                                @error('unit_price') <p><strong>{{ $message }}</strong></p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="unit_price" class="control-label"><sup style="color:red">*</sup>Rateio</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="number" name="unit_price" id="unit_price_currency" placeholder="0.00" class="form-control" min="0">
                                @error('unit_price') <p><strong>{{ $message }}</strong></p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-1" hidden style="margin-top: 28px;">
                        <button class="btn btn-icon btn-small btn-danger delete-cnpj">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>

                    {{-- ADICIONAR CNPJ --}}
                    <div class="col-sm-1">
                        <div class="form-actions pull-right" style="margin-top:10px;">
                            <a class="btn btn-primary add-cnpj-btn">
                                <i class="glyphicon glyphicon-plus"></i>
                            </a>
                        </div>
                    </div>

                </div>

                <hr>

                <div class="row">
                    <div class="col-sm-4">
                        {{-- TIPO DE PRODUTO/SERVIÇO --}}
                        <label for="form-check" class="control-label" style="margin-right:10px;">
                            Cotação de:
                        </label>
                        <div class="form-check" style="display:inline;">
                            {{-- SERVICES --}}
                            <input
                            class="radio_request1" type="radio" name="a" value="services" data-skin="minimal"
                            style="background-color:black;">
                            <label class="form-check-label" for="services" style="margin-right:15px;">Serviços</label>
                            {{-- PRODUTOS --}}
                            <input checked
                            class="radio_request1" type="radio" name="a"value="products" data-skin="minimal">
                            <label class="form-check-label" for="personal">Produtos</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- CATEGORIA DO PRODUTO --}}
                    <div class="col-sm-4" style="margin-top:15px;">
                        <div class="form-group">
                            <label for="textfield" class="control-label">CATEGORIA DO PRODUTO</label>
                            <select name="request[][product_categorie]" id="s2"class='select2-me'style="width:100%"data-placeholder="Informe a categoria">
                                <option value=""></option>
                                <option value="3">Materiais de escritório</option>
                                <option value="4">Materiais de limpeza</option>
                                <option value="5">Brindes</option>
                            </select>
                        </div>
                    </div>
                </div>

        </div>
    </div>

    {{-- fim --}}

    <div class="col-sm-12 suppliers_block">
        <div class="box box-color box-bordered colored" id="suppliers-container">
            <div class="box-title">
                <h3 id="cnpj-title">
                    <i class="glyphicon glyphicon-briefcase"></i>
                    FORNECEDORES
                </h3>
                <div class="actions">
                    <a href="{{ route('supplierRegister') }}"
                        target="_blank"
                        class="btn btn-mini"
                        style="padding: 0px 5px 0px 5px;"
                    >
                        <h5 id="cnpj-title pull-right">
                            Cadastrar Novo
                            <i style="margin-left:5px;" class="glyphicon glyphicon-new-window"></i>
                        </h5>
                    </a>
                </div>
            </div>
            <div class="box-content supplier-row-1" >
                <div data-product="1">
                    <div class="row center-block" style="margin-bottom:10px;">
                        <button class="btn btn-icon btn-small btn-danger delete-supplier"
                        style="margin-bottom:5px; margin-right:10px; display:none">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        <h4 style="display: inline;">Fornecedor 1</h4>
                    </div>
                    <div class="row">
                        {{-- FORNECEDOR --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="textfield" class="control-label">Fornecedor (CNPJ - RAZÃO SOCIAL)</label>
                                <select name="request[][products][][product_mame]" id="s2" class='select2-me select-supplier' style="width:100%;" data-placeholder="Escolha uma produto">
                                    <option value=""></option>
                                    <option value="01">12.345.678/0001-01 - FORNECEDOR 01</option>
                                    <option value="02">12.345.678/0002-02 - FORNECEDOR 02</option>
                                    <option value="03">12.345.678/0003-03 - FORNECEDOR 03</option>
                                </select>
                            </div>
                        </div>
                        {{-- VENDEDOR --}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="name" class="control-label">Vendedor/Atendente</label>
                                <input
                                type="text"
                                name="request[][products][][suggestion_url]"
                                id="name"
                                placeholder="Pessoa responsável pela cotação"
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2" >
                            </div>
                        </div>
                        {{-- TELEFONE --}}
                        <div class="col-sm-2">
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
                        {{-- E-MAIL --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name" class="control-label">E-mail</label>
                                <input
                                type="text"
                                name="request[][products][][suggestion_url]"
                                id="name"
                                placeholder="user_email@vendedor.com.br"
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2" >
                            </div>
                        </div>
                        {{-- TOTAL --}}
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="name" class="control-label">Valor total (R$)</label>
                                <input
                                type="text"
                                name="request[][products][][suggestion_url]"
                                id="name"
                                placeholder="R$0,00 "
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2" >
                            </div>
                        </div>
                        {{-- ADICIONAR OBSERVAÇÃO --}}
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="request[][products][][product_observation]" class="checkbox-obs">
                                        Adicionar observação
                                    </label>
                                </div>
                                <div class="text-area" hidden >
                                    <textarea name="textarea" rows="2" style="resize:none;" placeholder="Informações complementares podem ser adicionadas a este campo." class="form-control text-area"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <hr> --}}
            </div>

            {{-- supplier row 2 --}}
            <div class="box-content supplier-row-2" hidden>
                <div data-product="1">
                    <div class="row center-block" style="margin-bottom:10px;">
                        <button class="btn btn-icon btn-small btn-danger delete-supplier"
                        style="margin-bottom:5px; margin-right:10px;">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        <h4 style="display: inline;">Fornecedor 2</h4>
                    </div>
                    <div class="row">
                        {{-- PRODUTO --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="textfield" class="control-label">Fornecedor (CNPJ - RAZÃO SOCIAL)</label>
                                <select name="request[][products][][product_mame]" id="s2" class='select2-me select-supplier' style="width:100%;" data-placeholder="Escolha uma produto">
                                    <option value=""></option>
                                    <option value="01">12.345.678/0001-01 - FORNECEDOR 01</option>
                                    <option value="02">12.345.678/0002-02 - FORNECEDOR 02</option>
                                    <option value="03">12.345.678/0003-03 - FORNECEDOR 03</option>
                                </select>
                            </div>
                        </div>
                        {{-- MODELO --}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="name" class="control-label">Vendedor/Atendente</label>
                                <input
                                type="text"
                                name="request[][products][][suggestion_url]"
                                id="name"
                                placeholder="Pessoa responsável pela cotação"
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2" >
                            </div>
                        </div>
                        <div class="col-sm-2">
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
                        {{-- E-MAIL CONTATO --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name" class="control-label">E-mail</label>
                                <input
                                type="text"
                                name="request[][products][][suggestion_url]"
                                id="name"
                                placeholder="user_email@vendedor.com.br"
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2" >
                            </div>
                        </div>
                        {{-- Valor total --}}
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="name" class="control-label">Valor total (R$)</label>
                                <input
                                type="text"
                                name="request[][products][][suggestion_url]"
                                id="name"
                                placeholder="R$0,00 "
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="request[][products][][product_observation]" class="checkbox-obs">
                                        Adicionar observação
                                    </label>
                                </div>
                                <div class="text-area" hidden >
                                    <textarea name="textarea" rows="2" style="resize:none;" placeholder="Informações complementares podem ser adicionadas a este campo." class="form-control text-area"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <hr> --}}
            </div>

            {{-- supplier row 3 --}}
            <div class="box-content supplier-row-3" hidden>
                <div data-product="1">
                    <div class="row center-block" style="margin-bottom:10px;">
                        <button class="btn btn-icon btn-small btn-danger delete-supplier"
                        style="margin-bottom:5px; margin-right:10px;">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        <h4 style="display: inline;">Fornecedor 3</h4>
                    </div>
                    <div class="row">
                        {{-- PRODUTO --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="textfield" class="control-label">Fornecedor (CNPJ - RAZÃO SOCIAL)</label>
                                <select name="request[][products][][product_mame]" id="s2" class='select2-me select-supplier' style="width:100%;" data-placeholder="Escolha uma produto">
                                    <option value=""></option>
                                    <option value="01">12.345.678/0001-01 - FORNECEDOR 01</option>
                                    <option value="02">12.345.678/0002-02 - FORNECEDOR 02</option>
                                    <option value="03">12.345.678/0003-03 - FORNECEDOR 03</option>
                                </select>
                            </div>
                        </div>
                        {{-- MODELO --}}
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="name" class="control-label">Vendedor/Atendente</label>
                                <input
                                type="text"
                                name="request[][products][][suggestion_url]"
                                id="name"
                                placeholder="Pessoa responsável pela cotação"
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2" >
                            </div>
                        </div>
                        <div class="col-sm-2">
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
                        {{-- E-MAIL CONTATO --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name" class="control-label">E-mail</label>
                                <input
                                type="text"
                                name="request[][products][][suggestion_url]"
                                id="name"
                                placeholder="user_email@vendedor.com.br"
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2" >
                            </div>
                        </div>
                        {{-- Valor total --}}
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="name" class="control-label">Valor total (R$)</label>
                                <input
                                type="text"
                                name="request[][products][][suggestion_url]"
                                id="name"
                                placeholder="R$0,00 "
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="request[][products][][product_observation]" class="checkbox-obs">
                                        Adicionar observação
                                    </label>
                                </div>
                                <div class="text-area" hidden >
                                    <textarea name="textarea" rows="2" style="resize:none;" placeholder="Informações complementares podem ser adicionadas a este campo." class="form-control text-area"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <hr> --}}

            </div>

            {{-- btn ADICIONAR FORNECEDOR --}}
            <div class="box-content btn-container">
                <div class="col-md-6">
                    <a class="btn btn pull-left btn-large add-supplier">+ Adicionar fornecedor</a>
                </div>
            </div>


        </div>
    </div>

    <div class="col-sm-12 product-block" id="produto-container">
        <div class="box box-color box-bordered colored" data-cnpj="1">
            <div class="box-title">
                <h3 id="cnpj-title">
                    <i class="glyphicon glyphicon-tag"></i>
                    PRODUTOS
                </h3>
                <div class="actions">
                    <a href="#" class="btn btn-mini content-remove">
                        <i class="fa fa-times"></i>
                    </a>
                    <a href="#" class="btn btn-mini content-slideUp">
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
            </div>
            <div class="box-content">
                <div class="full-product-line product-form" data-product="1">
                    <div class="row" style="margin-bottom:10px;">
                        <div class="product-row">
                            <div class="col-sm-1" style="margin-top: 23px; width:5.3%;">
                                <button class="btn btn-icon btn-danger delete-product">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                            {{-- PRODUTO --}}
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="textfield" class="control-label">Nome/Descrição</label>
                                    <select name="request[][products][][product_mame]" id="s2" class='select2-me' style="width:100%;" data-placeholder="Escolha uma produto">
                                        <option value=""></option>
                                        <option value="01">Caixa organizadora (50L- ref: 1214) ou CAIXA ORGANIZADOR 50L PLASVALE REF.1482</option>
                                        <option value="02">Dispenser para caixa de luva c/ 1 unidade</option>
                                        <option value="03">Calice de plastico graduado 15ml</option>
                                        <option value="04">Carrinho Estética (grande) Luxo CGO c/3 bandeja ref.573 na cor branca</option>
                                        <option value="05">Calice de vidro graduado sem calibração rastreável- 60ML</option>
                                        <option value="06">Gral de porcelana 305ml</option>
                                        <option value="07">Gral de porcelana 180ml</option>
                                        <option value="08">Becker de Plastico (J Prolab)- 1 litros</option>
                                    </select>
                                </div>
                            </div>
                            {{-- MODELO --}}
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="name" class="control-label">Modelo</label>
                                    <input
                                    type="text"
                                    name="request[][products][][suggestion_url]"
                                    id="name"
                                    placeholder="Ex: Exemplo Modelo"
                                    class="form-control"
                                    data-rule-required="true"
                                    data-rule-minlength="2" >
                                </div>
                            </div>
                            {{-- COR --}}
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="name" class="control-label">Cor</label>
                                    <input
                                    type="text"
                                    name="request[][products][][suggestion_url]"
                                    id="name"
                                    placeholder="Ex: Bege Claro"
                                    class="form-control"
                                    data-rule-required="true"
                                    data-rule-minlength="2" >
                                </div>
                            </div>
                            {{-- TAMANHO --}}
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label for="name" class="control-label">Tamanho</label>
                                    <input
                                    type="text"
                                    name="request[][products][][suggestion_url]"
                                    id="name"
                                    placeholder="Ex: M"
                                    class="form-control"
                                    data-rule-required="true"
                                    data-rule-minlength="2" >
                                </div>
                            </div>
                            {{-- QUANTIDADE --}}
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label for="qtd" class="control-label">Qtd.</label>
                                    <input name="request[][products][][qtd]" type="number" placeholder="00" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- btn ADICIONAR PRODUTO --}}
                <div class="row product-form">
                    <div class="col-md-6">
                        <a class="btn btn pull-left btn-large add-product-btn" id="add-product-btn">+ Adicionar produto</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- SERVICES --}}
    <div class="col-sm-12 service-block" id="servico-container" >
        <div class="box box-color box-bordered colored">
            <div class="box-title">
                <h3 id="service-title">
                    <i class="glyphicon glyphicon-wrench"></i>
                    Serviços
                </h3>
                <div class="actions">
                    <a href="#" class="btn btn-mini content-remove">
                        <i class="fa fa-times"></i>
                    </a>
                    <a href="#" class="btn btn-mini content-slideUp">
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
            </div>
            <div class="box-content">
                <div class="service-form">
                    <div class="row">
                        <div class="service-row">
                            {{-- SERVIÇO --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="a" class="control-label">Descrição</label>
                                    <input
                                    type="text"
                                    name="a"
                                    id="a"
                                    placeholder="Descreva o serviço a ser contratado"
                                    class="form-control"
                                    data-rule-required="true"
                                    data-rule-minlength="2" >
                                </div>
                            </div>
                            {{-- LOCAL SERVIÇO --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="a" class="control-label">Local</label>
                                    <input
                                    type="text"
                                    name="b"
                                    id="a"
                                    placeholder="Informe o local onde será prestado o serviço"
                                    class="form-control"
                                    data-rule-required="true"
                                    data-rule-minlength="2" >
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- VIGÊNCIA DO SERVIÇO --}}
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="birthdate" class="control-label">Data início</label>
                                <input
                                type="date"
                                name="birthdate"
                                id="birthdate"
                                placeholder="Data de nascimento"
                                class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="birthdate" class="control-label">Data final</label>
                                <input
                                type="date"
                                name="birthdate"
                                id="birthdate"
                                placeholder="Data de nascimento"
                                class="form-control">
                            </div>
                        </div>
                        {{-- Vigencia --}}
                        <div class="service-row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="textfield" class="control-label">Recorrência</label>
                                    <select name="request[][cnpj]" id="s2" class='select2-me'
                                    style="width:100%; padding-top:2px;" data-placeholder="Pagamento do serviço">
                                        <option value=""></option>
                                        <option value="1">ÚNICA</option>
                                        <option value="3">MENSAL</option>
                                        <option value="4">ANUAL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="request[][products][][product_observation]" class="checkbox-obs">
                                        Adicionar observação
                                    </label>
                                </div>
                                <div class="text-area" hidden >
                                    <textarea name="textarea" rows="2"
                                    style="resize:none;"
                                    placeholder="Informações complementares podem ser adicionadas a este campo." class="form-control text-area"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="service-form">
                {{-- btn ADICIONAR SERVIÇO --}}
                <div class="row service-form">
                    <div class="col-md-6">
                        <a class="btn btn pull-left btn-large add-service-btn" id="add-service-btn">+ Adicionar serviço</a>
                    </div>
                </div>
            </div>

            {{-- SERVIÇO 2 --}}
            <div class="box-content" hidden>
                <div class="service-form">
                    <div class="row">
                        <div class="service-row">
                            {{-- SERVIÇO --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="a" class="control-label">Descrição</label>
                                    <input
                                    type="text"
                                    name="a"
                                    id="a"
                                    placeholder="Descreva o serviço a ser contratado"
                                    class="form-control"
                                    data-rule-required="true"
                                    data-rule-minlength="2" >
                                </div>
                            </div>
                            {{-- LOCAL SERVIÇO --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="a" class="control-label">Local</label>
                                    <input
                                    type="text"
                                    name="b"
                                    id="a"
                                    placeholder="Informe o local onde será prestado o serviço"
                                    class="form-control"
                                    data-rule-required="true"
                                    data-rule-minlength="2" >
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- VIGÊNCIA DO SERVIÇO --}}
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="birthdate" class="control-label">Data início</label>
                                <input
                                type="date"
                                name="birthdate"
                                id="birthdate"
                                placeholder="Data de nascimento"
                                class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="birthdate" class="control-label">Data final</label>
                                <input
                                type="date"
                                name="birthdate"
                                id="birthdate"
                                placeholder="Data de nascimento"
                                class="form-control">
                            </div>
                        </div>
                        {{-- Vigencia --}}
                        <div class="service-row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="textfield" class="control-label">Recorrência</label>
                                    <select name="request[][cnpj]" id="s2" class='select2-me'
                                    style="width:100%; padding-top:2px;" data-placeholder="Pagamento do serviço">
                                        <option value=""></option>
                                        <option value="1">ÚNICA</option>
                                        <option value="3">MENSAL</option>
                                        <option value="4">ANUAL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="request[][products][][product_observation]" class="checkbox-obs">
                                        Adicionar observação
                                    </label>
                                </div>
                                <div class="text-area" hidden >
                                    <textarea name="textarea" rows="2"
                                    style="resize:none;"
                                    placeholder="Informações complementares podem ser adicionadas a este campo." class="form-control text-area"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="service-form">
                {{-- btn ADICIONAR SERVIÇO --}}
                <div class="row service-form">
                    <div class="col-md-6">
                        <a class="btn btn pull-left btn-large add-service-btn" id="add-service-btn">+ Adicionar serviço</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- SERVIÇO 2 --}}

    <div class="form-actions pull-right" style="margin-top:20px;">
        <button type="submit" class="btn btn-primary">SALVAR</button>
        <a href="{{ url()->previous() }}" class="btn">CANCELAR</a>
    </div>

</x-app>


{{-- ADD +1 PROD--}}
<script>
    $(document).ready(function() {
        const $productRowTemplate = $(".full-product-line").last()
        // definindo um evento que remove o produto do qual o btn faz parte
        $(document).on('click', '.delete-product', function() {
            $(this).parent().parent().remove();
            checkDeleteButtonVisibility();
        });

        $(document).on('click', ".add-product-btn", function() {
            const $containerCnpj = $(this).parentsUntil("[data-cnpj]").last();
            const $products = $containerCnpj.find("[data-product]")
            const $lastProduct = $products.last();
            const $firstProduct = $products.first();
            let productCount = $lastProduct.data("product") + 1;
            const $newProductRow = $productRowTemplate.clone();
            $newProductRow.data('product', productCount);
            $newProductRow.find(":text").val("");
            $newProductRow.find('.select2-container').remove();
            $newProductRow.find('.select2-me').attr('id', 's2-' + productCount).select2();
            $newProductRow.find('h4').text('Produto ' + (productCount));
            $lastProduct.after($newProductRow);
            checkDeleteButtonVisibility();
        });

        function updateProductNumbers() {
            $('.full-product-line').each(function(index) {
                $(this).find('h4').text('Produto ' + (index + 1));
                $(this).data('product', index + 1);
            });
            productCount = $('.full-product-line').length;
        }

        // verifica se lenght==1 pra botao delete product
        // esconde ou mostra caso 1 ou maior
        function checkDeleteButtonVisibility() {
            const $containerCnpj = $("[data-cnpj]");
            $containerCnpj.each(function() {
                const $products = $(this).find("[data-product]");
                const $deleteButton = $(this).find('.delete-product');
                if ($products.length === 1) {
                    $deleteButton.hide();
                } else {
                    $deleteButton.show();
                }
            });
        }
    });
</script>

{{-- DISPLAY OBS --}}
<script>
    $(document).ready(function() {
        $(document).on('change', ".checkbox-obs", function() {
        $isChecked = $(this).is(":checked");
            $(this)
                .parentsUntil("[data-product]")
                .last()
                .find(".text-area")
                .toggle($isChecked);
        });
    });
</script>

{{-- Add +1 CENTRO DE CUSTO --}}
<script>
    $(document).ready(function() {
        let cnpjCount = 1;
        $(document).on('click', '.add-cnpj-btn', function() {
            const cnpjRow = $('.cnpj-row').last();
            const clonedRow = cnpjRow.clone();
            clonedRow.find('.add-cnpj-btn').remove();
            clonedRow.find('.col-sm-1').removeAttr('hidden');
            clonedRow.find("input, select").val("");
            clonedRow.find('.select2-container').remove();
            clonedRow.find('.select2-me').each(function() {
                $(this).attr({
                    id: Math.random()
                });
            }).select2();
            cnpjRow.after(clonedRow);
            cnpjCount++;
        });
        $(document).on('click', '.delete-cnpj', function() {
            const cnpjRow = $(this).closest('.cnpj-row');
            cnpjRow.remove();
            cnpjCount--;
        });
    });
</script>

{{-- input service / product --}}
<script>
    $(document).ready(function() {
        $('.radio_request1').change(function() {
            const selectedValue = $(this).val();
            $('#produto-container, #servico-container').hide();
            if (selectedValue === 'products') {
                $('#produto-container').show();
            } else if (selectedValue === 'services') {
                $('#servico-container').show();
            }
        }).trigger('change');
    });
</script>

{{-- ADD SUPPLIER --}}
<script>
    $(document).ready(function() {
        $(".add-supplier").click(function() {
            const nextComponent = $(".box-content:hidden:first");
            nextComponent.removeAttr("hidden");

            const prevComponent = nextComponent.prev(".box-content");
            prevComponent.find(".delete-supplier").show();
        });

        $(".delete-supplier").click(function() {
            const currentComponent = $(this).closest(".box-content");
            currentComponent.hide();

            const nextComponent = currentComponent.next(".box-content");
            nextComponent.find(".add-supplier").show();
        });
    });
</script>

{{-- desabilita um dos "rateios" qnd outro estiver preenchido --}}
<script>
    $(document).ready(function() {
        // se percentual preenchido
        $('#unit_price_percentage').on('input', function() {
            if ($(this).val()) {
                $('#unit_price_currency').prop('disabled', true);
            }
            else {
                $('#unit_price_currency').prop('disabled', false);
            }
        });
        // se moeda
        $('#unit_price_currency').on('input', function() {
            if ($(this).val()) {
                $('#unit_price_percentage').prop('disabled', true);
            } else {
                $('#unit_price_percentage').prop('disabled', false);
            }
        });
    });
  </script>
