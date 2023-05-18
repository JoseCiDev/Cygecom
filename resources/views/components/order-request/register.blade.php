<x-app>

    <x-slot name="title">
        <h1>Nova Solicitação</h1>
    </x-slot>

    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Formulário para preenchimento das informações necessárias para abrir uma requisição de compra. Para cada CNPJ, é possível cadastrar vários produtos de uma mesma categoria. É preciso também informar a quantidade de cada produto. Se preferir, pode ser inserido um link de sugestão de produto.
    </div>

    <div class="col-sm-12">
        {{-- <div class="box box-bordered cnpj-block" data-cnpj="1">
            <div class="box-title">
                <h3 id="cnpj-title">
                    Informe o que deseja solicitar
                </h3>
                <div class="actions">
                    <a href="#" class="btn btn-mini content-remove">
                        <i class="fa fa-times"></i>
                    </a>
                    <a href="#" class="btn btn-mini content-slideUp">
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
            </div> --}}
            <div class="box-content">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h4>CONTRATANTE</h4>
                </div>
                <div class="row">
                    {{-- CNPJ CONTRATANTE --}}
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="textfield" class="control-label">CNPJ (utilizado para despesa)</label>
                            <select name="request[][cnpj]" id="s2" class='select2-me' style="width:100%;" data-placeholder="Escolha uma empresa do grupo">
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
                            <label for="textfield" class="control-label">Centro(s) de custo da despesa</label>
                            <div class="select">
                                <select name="request[][cost_center]" id="s2" multiple="multiple" placeholder="Selecione um ou mais centros de custo" class='select2-me' style="width:100%;">
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

                    {{-- ADICIONAR CNPJ --}}
                    <div class="col-sm-2">
                        <div class="form-actions pull-right" style="margin-top:7px;">
                            <a class="btn btn-primary add-cnpj-btn">+ Adicionar CNPJ</a>
                        </div>
                    </div>

                </div>

                <hr>

                <div class="full-product-line product-form" data-product="1">
                    <div class="row center-block" style="padding-bottom: 10px;">
                        <h4>DADOS DA SOLICITAÇÃO</h4>
                    </div>

                    <div class="row" style="margin-bottom:10px;">
                        {{-- TIPO DE PRODUTO/SERVIÇO --}}
                        <div class="col-sm-4">
                            <label for="form-check" class="control-label" style="margin-bottom: 12px;">Estou solicitando:</label>
                            <div class="form-check" style="display:inline; margin-left:12px;">
                                {{-- SERVICES --}}
                                <input
                                class="radio_request" type="radio" name="request[0][request_type]" value="servicesdata-skin="minimal"
                                style="background-color:black;">
                                <label class="form-check-label" for="services" style="margin-right:15px;">Serviços</label>
                                {{-- PRODUTOS --}}
                                <input checked
                                class="radio_request" type="radio" name="request[0][request_type]"value="productsdata-skin="minimal">
                                <label class="form-check-label" for="personal">Produtos</label>
                            </div>
                        </div>
                        {{-- QUEM IRA COTAR --}}
                        <div class="col-sm-8">
                            <label for="form-check" class="control-label" style="margin-bottom: 12px;">Cotação será feita por:</label>
                            <div class="form-check" style="display:inline; margin-left:12px;">
                                {{-- SUPRIMENTOS --}}
                                <input checked
                                class="radio_request" type="radio" name="request[0][request_tvalue="servicesdata-skin="minimal"
                                style="background-color:black;">
                                <label class="form-check-label" for="services" style="margin-right">Suprimentos</label>
                                {{-- EU FAREI --}}
                                <input style="margin-left:12px;"
                                class="radio_request" type="radio" name="request[0][request"value="productsdata-skin="minimal">
                                <label class="form-check-label" for="personal">Eu farei a cotação</label>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom:10px;">
                        <div class="product-row">
                            {{-- PRODUTO --}}
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="name" class="control-label">Descrição</label>
                                    <textarea name="textarea" rows="4" style="resize:none;" placeholder="Ex: Compra de 1 mesa para sala de reunião da HKM." class="form-control text-area"></textarea>
                                </div>
                                <div class="small"
                                    style="color:rgb(85, 85, 85); margin-top:-10px; margin-bottom:20px;">
                                    <p>
                                        * Descreva com detalhes o que deseja solicitar e informações úteis para uma possível cotação.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BTNs --}}
                    <a href="" class="btn">FAZER COTAÇÃO</a>
                    <div class="form-actions pull-right">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="" class="btn">Cancelar</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app>

