<x-app>

    <x-slot name="title">
        <h1>Nova Cotação</h1>
    </x-slot>

    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Formulário para preenchimento das informações necessárias para abrir uma requisição de compra.
        Para cada CNPJ, é possível cadastrar vários produtos de uma mesma categoria. É preciso também informar a
        quantidade de cada produto. Se preferir, pode ser inserido um link de sugestão de produto.
    </div>

    <div class="main-container">
        <form method="POST" action="{{ route('quotationRegister') }}">
            @csrf

            <div class="col-sm-12">

                <div class="row center-block" style="padding-bottom: 10px;">
                    <h4>DADOS SOLICITAÇÃO</h4>
                </div>

                {{-- JA TEM SOLICITACAO --}}
                <div class="row">
                    <div class="col-sm-6">
                        <label for="form-check" class="control-label" style="margin-bottom: 12px;">
                            Já existe uma solicitação aberta para inicar a nova cotação?
                        </label>
                        <div class="form-check" style="display:inline;">
                            <input class="radio_request" id="radio-request" type="radio" name="has_request"
                                value="1" servicesdata-skin="minimal"
                                style="background-color:black; margin-left:10px;">
                            <label class="radio-has-request" for="services" style="margin-right:15px;">SIM</label>
                            <input checked class="radio-has-request" id="radio-has-request" type="radio"
                                name="has_request" value="0" productsdata-skin="minimal">
                            <label class="form-check-label" for="personal">NÃO</label>
                        </div>
                    </div>
                </div>

                {{-- <div class="row">
                    SELECIONAR SOLICITAÇÃO - SE EXISTIR
                    <div class="col-sm-6" style="margin-top:10px;">
                        <div class="form-group">
                            <label
                                for="textfield" class="control-label"
                                style="margin-right:5px;"
                            >
                                SOLICITAÇÃO
                            </label>
                            <select
                                name="[cnpj]" id="s2"
                                class='select2-me'
                                style="width:80%"
                                data-placeholder="Escolha uma solicitação"
                            >
                                <option value=""></option>
                                <option value="1">Nº 102 - Suprimentos - INP Filial - RECURSOS HUMANOS - 4.8</option>
                                <option value="3">HKM - 06.354.562/0001-10 </option>
                                <option value="4">HKM - 06.354.562/0001-10 </option>
                            </select>
                        </div>
                    </div>
                </div> --}}

                <hr>

                <div class="box-content">
                    <div class="row center-block" style="padding-bottom: 10px;">
                        <h4>CONTRATANTE</h4>
                    </div>

                    <div class="row cnpj-row" data-cnpj="1">

                        {{-- CENTRO DE CUSTO --}}
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="textfield" class="control-label">Centro de custo da despesa</label>
                                <div class="select">
                                    <select name="cost_center_apportionments[0][cost_center_id]"
                                        placeholder="Ex: SMART MATRIZ - Conferência de Saída"
                                        class='select2-me cost-center' style="width:100%;">
                                        <option value="" disalbed></option>
                                        @foreach ($costCenters as $costCenter)
                                            @php
                                                $costCenterCompanyName = $costCenter['company']['corporate_name'];
                                                $costCenterName = $costCenter['name'];
                                                $costCenterSeniorCode = $costCenter['senior_code'];
                                            @endphp
                                            <option value={{ $costCenter['id'] }}>
                                                {{ $costCenterCompanyName . ' - ' . $costCenterName . ' - ' . $costCenterSeniorCode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- RATEIO (%) --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="unit_price_percentage" class="control-label">Rateio</label>
                                <div class="input-group">
                                    <span class="input-group-addon">%</span>
                                    <input type="number" name="cost_center_apportionments[0][unit_price_percentage]"
                                        id="unit-price-percentage" placeholder="0.00" class="form-control"
                                        min="0">
                                    @error('unit_price')
                                        <p><strong>{{ $message }}</strong></p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- RATEIO (R$) --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="unit_price_currency" class="control-label">Rateio</label>
                                <div class="input-group">
                                    <span class="input-group-addon">R$</span>
                                    <input type="number" name="cost_center_apportionments[0][unit_price_currency]"
                                        id="unit-price-currency" placeholder="0.00" class="form-control" min="0">
                                    @error('unit_price')
                                        <p><strong>{{ $message }}</strong></p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- BTN DELETE --}}
                        <div class="col-sm-1" hidden style="margin-top: 28px;">
                            <button class="btn btn-icon btn-small btn-danger delete-cnpj">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </div>

                        {{-- ADICIONAR CNPJ --}}
                        <div class="col-sm-1">
                            <div class="form-actions pull-right" style="margin-top:10px;">
                                <a class="btn btn-primary btn-add add-cost_center_apportionment">
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
                                {{-- SERVICOS --}}
                                <input class="radio_request1" type="radio" name="is_service" value="1"
                                    data-skin="minimal" style="background-color:black;">
                                <label class="form-check-label" for="services" style="margin-right:15px;">
                                    Serviços
                                </label>

                                {{-- PRODUTOS --}}
                                <input checked class="radio_request1" type="radio" name="is_service" value="0"
                                    data-skin="minimal">
                                <label class="form-check-label" for="personal">
                                    Produtos
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- BLOCO FORNECEDOR --}}
            <div class="col-sm-12 suppliers-block">
                <div class="box box-color box-bordered colored" id="suppliers-container">
                    <div class="box-title">
                        <h3 id="supplier-title" class="supplier-title">
                            <i class="glyphicon glyphicon-briefcase"></i>
                            FORNECEDOR 1
                        </h3>
                        <div class="actions">
                            <a href="#" class="btn btn-mini delete-supplier-block">
                                <i class="fa fa-times"></i>
                            </a>
                            <a href="#" class="btn btn-mini content-slideUp">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                    </div>

                    <div class="box-content supplier-row-1">
                        <div data-product="1">

                            <div class="row">

                                {{-- CNPJ/NOME FORNECEDOR --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="supplier" class="control-label">Fornecedor (CNPJ - RAZÃO
                                            SOCIAL)</label>
                                        <select name="suppliers[0][id]" id="supplier"
                                            class='select2-me select-supplier' style="width:100%;"
                                            data-placeholder="Escolha uma produto">
                                            <option value=""></option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier['id'] }}">{{ $supplier['corporate_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- VENDEDOR/ATENDENTE --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="attendant" class="control-label">Vendedor/Atendente</label>
                                        <input type="text" id="attendant" name="suppliers[0][attendant]"
                                            placeholder="Pessoa responsável pela cotação" class="form-control"
                                            data-rule-required="true" data-rule-minlength="2">
                                    </div>
                                </div>

                                {{-- TELEFONE --}}
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="phone-number" class="control-label">Telefone</label>
                                        <input type="text" name="suppliers[0][phone_number]" id="phone-number"
                                            placeholder="(00) 0000-0000" class="form-control mask_phone"
                                            data-rule-required="true">
                                    </div>
                                </div>

                                {{-- E-MAIL --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="email" class="control-label">E-mail</label>
                                        <input type="text" name="suppliers[0][email]" id="email"
                                            placeholder="user_email@vendedor.com.br" class="form-control"
                                            data-rule-required="true" data-rule-minlength="2">
                                    </div>
                                </div>

                                {{-- TOTAL --}}
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="ammount" class="control-label">Valor total (R$)</label>
                                        <input type="text" id="amount" placeholder="R$0,00 "
                                            class="form-control" data-rule-required="true" data-rule-minlength="2">
                                    </div>
                                </div>

                                {{-- ADICIONAR OBSERVAÇÃO --}}
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="obs-checkbox" class="checkbox-obs">
                                                Adicionar observação
                                            </label>
                                        </div>
                                        <div class="text-area" hidden>
                                            <textarea name="observation" rows="2" style="resize:none;"
                                                placeholder="Informações complementares podem ser adicionadas a este campo." class="form-control text-area"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- BLOCO PRODUTOS --}}
                        <div class="col-sm-12 product-block" id="produto-container" style="margin-top:15px;">
                            <div>

                                <div class="box-title"
                                    style="
                                    background-color:rgba(244, 244, 244, 0.531);
                                    border: 2px solid rgb(158, 158, 158);
                                ">
                                    <h3 id="product-title" style="color:rgb(80, 80, 80)">
                                        <i class="glyphicon glyphicon-tag"></i>
                                        PRODUTOS
                                    </h3>
                                    <div class="actions">
                                        <a href="#" class="btn btn-mini content-slideUp">
                                            <i class="fa fa-angle-down" style="color:grey;"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="box-content"
                                    style="
                                    background-color:rgba(244, 244, 244, 0.531);
                                    border: 2px solid rgb(158, 158, 158);
                                    border-top: 0px;
                                ">
                                    <div class="full-product-line product-form" data-product="1">
                                        <div class="row">
                                            <div class="product-row">
                                                <div class="col-sm-1" style="margin-top: 23px; width:5.3%;">
                                                    <button class="btn btn-icon btn-danger delete-product">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </div>

                                                {{-- CATEGORIA PRODUTO --}}
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="product-category"
                                                            class="control-label">Categoria</label>
                                                        <select name="suppliers[0][products][0][product_categorie_id]"
                                                            id="product-category" class='select2-me'
                                                            style="width:100%;"
                                                            data-placeholder="Escolha uma produto">
                                                            <option value=""></option>
                                                            @foreach ($products as $product)
                                                                <option value={{ $product['categorie']['id'] }}>
                                                                    {{ $product['categorie']['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- NOME / DESCRIÇÃO --}}
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="textfield" class="control-label">
                                                            Nome/Descrição
                                                        </label>
                                                        <select name="suppliers[0][products][0][id]" id="s2"
                                                            class='select2-me' style="width:100%;"
                                                            data-placeholder="Escolha uma produto">
                                                            <option value=""></option>
                                                            @foreach ($products as $product)
                                                                <option value={{ $product['id'] }}>
                                                                    {{ $product['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- VALOR --}}
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="unit_price_percentage" class="control-label">Preço
                                                            Unit.</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">R$</span>
                                                            <input type="number"
                                                                name="suppliers[0][products][0][unit_price]"
                                                                id="unit_price_percentage" placeholder="0.00"
                                                                class="form-control" min="0">
                                                            @error('unit_price')
                                                                <p><strong>{{ $message }}</strong></p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- QUANTIDADE --}}
                                                <div class="col-sm-1">
                                                    <div class="form-group">
                                                        <label for="qtd" class="control-label">Qtd.</label>
                                                        <input name="suppliers[0][products][0][quantity]"
                                                            type="number" placeholder="00" class="form-control">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            {{-- MODELO --}}
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">Modelo</label>
                                                    <input type="text" name="suppliers[0][products][0][model]"
                                                        id="name" placeholder="Ex: Exemplo Modelo"
                                                        class="form-control" data-rule-required="true"
                                                        data-rule-minlength="2">
                                                </div>
                                            </div>

                                            {{-- COR --}}
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">Cor</label>
                                                    <input type="text" name="suppliers[0][products][0][color]"
                                                        id="name" placeholder="Ex: Bege Claro"
                                                        class="form-control" data-rule-required="true"
                                                        data-rule-minlength="2">
                                                </div>
                                            </div>

                                            {{-- TAMANHO --}}
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">Tamanho</label>
                                                    <input type="text" name="suppliers[0][products][0][size]"
                                                        id="name" placeholder="Ex: M" class="form-control"
                                                        data-rule-required="true" data-rule-minlength="2">
                                                </div>
                                            </div>

                                        </div>

                                        <hr style="margin-top: 5px; margin-bottom: 10px;">

                                    </div>

                                    {{-- btn ADICIONAR PRODUTO --}}
                                    <div class="row product-form">
                                        <div class="col-md-6">
                                            <a class="btn btn btn-add pull-left btn-large add-product"
                                                id="add-product">
                                                + Adicionar produto
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- BLOCO DE SERVIÇOS --}}
                        <div class="col-sm-12 service-block" id="servico-container">
                            <div class="box box-color box-bordered colored">
                                <div class="box-title"
                                    style="
                                    background-color:rgba(244, 244, 244, 0.531);
                                    border: 2px solid rgb(158, 158, 158);
                                ">
                                    <h3 id="service-title" style="color:rgb(80, 80, 80)">
                                        <i class="glyphicon glyphicon-wrench"></i>
                                        SERVIÇOS
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

                                <div class="box-content"
                                    style="
                                        background-color:rgba(244, 244, 244, 0.531);
                                        border: 2px solid rgb(158, 158, 158);
                                        border-top: 0px;
                                    ">
                                    <div class="service-form">
                                        <div class="row">

                                            {{-- DESCRICAO SERVICO --}}
                                            <div class="service-row">
                                                {{-- SERVIÇO --}}
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="a" class="control-label">Descrição</label>
                                                        <input type="text" name="" id="a"
                                                            placeholder="Descreva o serviço a ser contratado"
                                                            class="form-control" data-rule-required="true"
                                                            data-rule-minlength="2">
                                                    </div>
                                                </div>
                                                {{-- LOCAL SERVIÇO --}}
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="a" class="control-label">Local</label>
                                                        <input type="text" name="" id="a"
                                                            placeholder="Informe o local onde será prestado o serviço"
                                                            class="form-control" data-rule-required="true"
                                                            data-rule-minlength="2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- VIGÊNCIA DO SERVIÇO --}}
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="start-date" class="control-label">Data início</label>
                                                    <input type="date" name="start_date" id="start-date"
                                                        placeholder="Data de nascimento" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="end-date" class="control-label">Data final</label>
                                                    <input type="date" name="end_date" id="end-date"
                                                        placeholder="Data de nascimento" class="form-control">
                                                </div>
                                            </div>

                                            {{-- RECORRENCIA --}}
                                            <div class="service-row">
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label for="recurrence"
                                                            class="control-label">Recorrência</label>
                                                        <select name="recurrence" id="recurrence" class='select2-me'
                                                            style="width:100%; padding-top:2px;"
                                                            data-placeholder="Pagamento do serviço">
                                                            <option value=""></option>
                                                            <option value="1">ÚNICA</option>
                                                            <option value="3">MENSAL</option>
                                                            <option value="4">ANUAL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- OBS --}}
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"
                                                                name="suppliers[0][products][0][observation]"
                                                                class="checkbox-obs">
                                                            Adicionar observação
                                                        </label>
                                                    </div>
                                                    <div class="text-area" hidden>
                                                        <textarea name="textarea" rows="2" style="resize:none;"
                                                            placeholder="Informações complementares podem ser
                                                                adicionadas a este campo."
                                                            class="form-control text-area">
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <hr class="service-form">

                                    {{-- btn ADICIONAR SERVIÇO --}}
                                    <div class="row service-form">
                                        <div class="col-md-6">
                                            <a class="btn btn btn-add pull-left btn-large add-service"
                                                id="add-service">
                                                + Adicionar serviço
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- btn ADICIONAR FORNECEDOR --}}
            <div class="box-content btn-container">
                <div class="col-md-6" style="margin-top:15px;">
                    <a class="btn btn-primary btn-add pull-left btn-large add-supplier">+ Adicionar fornecedor</a>
                </div>
            </div>

            <div class="form-actions pull-right" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">SALVAR</button>
                <a href="{{ url()->previous() }}" class="btn">CANCELAR</a>
            </div>

        </form>
    </div>

</x-app>

<script>
    $(() => {
        $(document).on('click', '.btn-add', function() {
            // pega a classe correspondente ao click (add-btn)
            const lastOfClassList = Array.from(this.classList).at(-1).match(/add-(\w+)/).at(-1);
            const regex = new RegExp(`(.*\\[?${lastOfClassList}s]?\\[)(\\d+)(].*)`);
            console.log('suppliers[0][products][0][size]'.replace(regex, '$1 \\ 10$2'));
        })
    })
</script>

{{-- ADD/DELETE SUPPLIER --}}
<script>
    $(document).ready(function() {
        let supplierCount = 1;
        $productBlockTemplate = $('.supplier-block').first().find('.product-block');
        $productBlockClone = $productBlockTemplate.clone();
        $('.add-supplier').click(function() {
            const $supplierBlock = $('.suppliers-block').last();
            const $clonedBlock = $supplierBlock.clone();
            $clonedBlock.find("input, select").val("");
            $clonedBlock.find('.select2-container').remove();
            $clonedBlock.find('.select2-me').each(function() {
                $(this).attr({
                    id: Math.random()
                });
            }).select2();

            $supplierBlock.after($clonedBlock);

            supplierCount++;
            updateSupplierTitles();
        });

        $(document).on('click', '.delete-supplier-block', function(event) {
            event.preventDefault();
            const $supplierBlock = $(this).closest('.suppliers-block');
            if (supplierCount !== 1) {
                $supplierBlock.remove();
                supplierCount--;
                updateSupplierTitles();
            }
        });

        function updateSupplierTitles() {
            $('.suppliers-block').each(function(index) {
                const $title = $(this).find('.supplier-title');
                $title.text('FORNECEDOR ' + (index + 1));
            });
        }

        // function changeAllNames() {

        // }
    });
</script>

{{-- Add +1 CENTRO DE CUSTO --}}
<script>
    $(document).ready(function() {
        let cnpjCount = 1;
        $(document).on('click', '.add-costCenter', function() {
            const cnpjRow = $('.cnpj-row').last();
            const clonedRow = cnpjRow.clone();
            clonedRow.find('.add-costCenter').remove();
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

{{-- ADD +1 PROD --}}
<script>
    $(document).ready(function() {
        const $productRowTemplate = $(".full-product-line").last()
        $(document).on('click', '.delete-product', function() {
            $(this).parent().parent().remove();
            $(this).parent().parent().parent().remove();
        });

        $(document).on('click', ".add-product", function() {
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
        });
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

{{-- input service / product --}}
<script>
    $(document).ready(function() {
        $('.radio_request1').change(function() {
            const selectedValue = $(this).val();
            $('#produto-container, #servico-container').hide();
            if (selectedValue === '0') {
                $('#produto-container').show();
            } else if (selectedValue === '1') {
                $('#servico-container').show();
            }
        }).trigger('change');
    });
</script>

{{-- desabilita um dos "rateios" qnd outro estiver preenchido --}}
<script>
    $(document).ready(function() {
        // se percentual preenchido
        $('#unit_price_percentage').on('input', function() {
            if ($(this).val()) {
                $('#unit_price_currency').prop('disabled', true);
            } else {
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
