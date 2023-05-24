<x-app>

    <x-slot name="title">
        <h1>Nova Solicitação</h1>
    </x-slot>

    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Formulário para preenchimento das informações necessárias para abrir uma requisição de compra. Para cada CNPJ, é possível cadastrar vários produtos de uma mesma categoria. É preciso também informar a quantidade de cada produto. Se preferir, pode ser inserido um link de sugestão de produto.
    </div>

    <div class="col-sm-12">
        <div class="box box-bordered cnpj-block" data-cnpj="1">
            <div class="box-title">
                <h3 id="cnpj-title">
                    <i class="fa fa-bars"></i>
                    CNPJ 1
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
                <div class="row">
                    {{-- CNPJ CONTRATANTE --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="textfield" class="control-label">CNPJ</label>
                            <select name="request[][cnpj]" id="s2" class='select2-me' style="width:250px;" data-placeholder="Escolha uma empresa do grupo">
                                <option value=""></option>
                                <option value="1">HKM - 06.354.562/0001-10 </option>
                                <option value="3">HKM - 06.354.562/0001-10 </option>
                                <option value="4">HKM - 06.354.562/0001-10 </option>
                                <option value="5">HKM - 06.354.562/0001-10 </option>
                            </select>
                        </div>
                    </div>
                    {{-- CENTRO DE CUSTO --}}
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="textfield" class="control-label">CENTRO DE CUSTO DA DESPESA</label>
                            <div class="select">
                                <select name="request[][cost_center]" id="s2" multiple="multiple" placeholder="Selecione uma ou mais opções" class='select2-me' style="width:100%;">
                                    <option value=""></option>
                                    <option value="1">Lab. Liquidos</option>
                                    <option value="2">Option-02</option>
                                    <option value="3">Option-03</option>
                                    <option value="4">Option-04</option>
                                    <option value="5">Option-05</option>
                                    <option value="6">Option-06</option>
                                    <option value="7">Option-07</option>
                                    <option value="8">Option-08</option>
                                    <option value="9">Option-09</option>
                                    <option value="10">Option-10</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- TIPO DE PRODUTO/SERVIÇO --}}
                    <div class="col-sm-3">
                        <label for="form-check" class="control-label" style="margin-bottom: 12px;">SOLICITAÇÃO DE:</label>
                        <div class="form-check">
                            {{-- SERVICES --}}
                            <input
                            class="radio_request" type="radio" name="request[0][request_type]" value="services" data-skin="minimal"
                            style="background-color:black;">
                            <label class="form-check-label" for="services" style="margin-right:15px;">Serviços</label>
                            {{-- PRODUTOS --}}
                            <input checked
                            class="radio_request" type="radio" name="request[0][request_type]"value="products" data-skin="minimal">
                            <label class="form-check-label" for="personal">Produtos</label>
                        </div>
                    </div>
                </div>
                <div class="row product-form">
                    {{-- CATEGORIA DO PRODUTO --}}
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="textfield" class="control-label">CATEGORIA DO PRODUTO</label>
                            <select name="request[][product_categorie]" id="s2" class='select2-me' style="width:330px;" data-placeholder="Informe a categoria">
                                <option value=""></option>
                                <option value="3">Option-03</option>
                                <option value="4">Option-04</option>
                                <option value="5">Option-05</option>
                                <option value="6">Option-06</option>
                                <option value="7">Option-07</option>
                                <option value="8">Option-08</option>
                                <option value="9">Option-09</option>
                                <option value="10">Option-10</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="full-product-line product-form" data-product="1">
                    <div class="row center-block" style="margin-bottom: 10px;">
                        <button class="btn btn-icon btn-small btn-danger delete-product" style="margin-bottom:5px; display:none;">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        <h4 style="display: inline; margin-left:5px;">Produto 1</h4>
                    </div>
                    <div class="row" style="margin-bottom:10px;">
                        <div class="product-row">
                            {{-- PRODUTO --}}
                            <div class="col-sm-6">
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
                            {{-- QUANTIDADE --}}
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label for="qtd" class="control-label">Qtd.</label>
                                    <input name="request[][products][][qtd]" type="number" placeholder="00" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="textfield" class="control-label">Sugerir fornecedor(es)</label>
                                    <div class="select">
                                        <select name="request[][cost_center]" id="s2" multiple="multiple" placeholder="Selecione uma ou mais opções" class='select2-me' style="width:100%;">
                                            <option value=""></option>
                                            <option value="1">Fornecedor 01</option>
                                            <option value="2">Fornecedor 02</option>
                                            <option value="3">Fornecedor 03</option>
                                            <option value="4">Fornecedor 04</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- SUGESTÃO --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="control-label">Link Sugestão</label>
                                    <input
                                    type="text"
                                    name="request[][products][][suggestion_url]"
                                    id="name"
                                    placeholder="Cole a URL do produto sugerido aqui"
                                    class="form-control"
                                    data-rule-required="true"
                                    data-rule-minlength="2" >
                                </div>
                            </div>
                                {{-- SUGESTÃO --}}
                                <div class="col-sm-6" style="padding-top:27px;">
                                    <label for="form-check" class="control-label" style="padding-right:10px;">Produto importado pelo COMEX?</label>
                                    <div class="form-check" style="12px; display:inline;">
                                        {{-- sim --}}
                                        <input
                                        class="radio-comex" type="radio" name="radio-comex" value="1" data-skin="minimal"
                                        style="background-color:black;">
                                        <label class="form-check-label" for="services" style="margin-right:15px;">SIM</label>
                                        {{-- nao --}}
                                        <input checked
                                        class="radio-comex" type="radio" name="radio-comex"value="2" data-skin="minimal">
                                        <label class="form-check-label" for="">NÃO</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="request[][products][][product_observation]" class="checkbox-obs">
                                                Adicionar observação
                                            </label>
                                        </div>
                                        <div class="text-area" hidden style="margin-bottom:15px;">
                                            <textarea name="textarea" rows="3" style="resize:none;" placeholder="Informações complementares podem ser adicionadas a este campo." class="form-control text-area"></textarea>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <hr class="product-form">

                {{-- btn ADICIONAR PRODUTO --}}
                <div class="row product-form">
                    <div class="col-md-6">
                        <a class="btn btn pull-left btn-large add-product-btn" id="add-product-btn">+ Adicionar produto</a>
                    </div>
                </div>

                {{-- SERVICES --}}
                <div class="service-form">
                    <div class="row center-block" style="margin-bottom: 20px;" data-service="1">
                        <button class="btn btn-icon btn-small btn-danger delete-service" style="margin-bottom:5px">
                            <i class="fa fa-trash-o"></i>
                        </button>
                        <h4 style="display: inline; margin-left:5px;">Serviço 1</h4>
                    </div>
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

    {{-- ADICIONAR CNPJ --}}
    <div class="form-actions pull-left">
        <a class="btn btn-primary add-cnpj-btn">+ Adicionar CNPJ</a>
    </div>

</x-app>

{{-- DISPLAY CORRECT FORM --}}
<script>
    $(document).ready(function() {
      $(document).on('change', ".radio_request", function() {
        const $cnpjContainer = $(this)
            .parentsUntil("[data-cnpj]")
            .last();

        const $productForm = $cnpjContainer.find(".product-form");
        const $serviceForm = $cnpjContainer.find(".service-form");
        const selectedOption = $(this).val();

        $productForm.add($serviceForm).hide();

        if (selectedOption === "products") {
          $productForm.show(); $serviceForm.hide();
        }
        else if (selectedOption === "services") {
            $serviceForm.show(); $productForm.hide();
        }
      })

      $(".radio_request").last().trigger('change')
    });
</script>

{{-- ADD +1 PROD--}}
<script>
    $(document).ready(function() {
        const $productRowTemplate = $(".full-product-line").last()
        // definindo um evento que remove o produto do qual o btn faz parte
        $(document).on('click', '.delete-product', function() {
            $(this).parent().parent().remove();
            updateProductNumbers();
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

        // atualiza o numero do produto quando remover
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
          $isChecked = $(this).is(":checked")
          $(this)
            .parentsUntil("[data-product]")
            .last()
            .find(".text-area")
            .toggle($isChecked);
      });
    });
</script>

{{-- ADD +1 CNPJ --}}
<script>
    $(document).ready(function() {
        const $templateCnpjBlock = $(".cnpj-block").last().clone();
        $(document).on('click', ".add-cnpj-btn", function() {
            const $lastCnpjBlock = $(".cnpj-block").last();
            const cnpjCount = $templateCnpjBlock.data("cnpj") + 1;
            const $newCnpjBlock = $templateCnpjBlock.clone();
            console.log($lastCnpjBlock);
            console.log($newCnpjBlock);
            console.log($templateCnpjBlock);
            $newCnpjBlock.data('cnpj', cnpjCount);

            $newCnpjBlock.find("input[type='text'], input[type='number']").val("");
            $newCnpjBlock.find('.select2-container').remove();
            $newCnpjBlock.find('.select2-me').attr('id', 's2-' + cnpjCount).select2();
            $newCnpjBlock.find('#cnpj-title').text('CNPJ ' + (cnpjCount));
            $newCnpjBlock.find(".radio_request").attr("name", "request[" + cnpjCount + "][request_type_")
            $lastCnpjBlock.after($newCnpjBlock);

            // Adiciona o evento de exclusão de linha para a nova linha de produto
            $newCnpjBlock.find('.content-remove ').click(function() {
                $(this).closest('.cnpj-block').remove();
            });
        });
    });
</script>
