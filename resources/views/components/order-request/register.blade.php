<x-app>

    <x-slot name="title">
        <h1>Nova Solicitação</h1>
    </x-slot>

    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Formulário para preenchimento das informações necessárias para abrir uma requisição de compra. Para cada CNPJ, é possível cadastrar vários produtos de uma mesma categoria. É preciso também informar a quantidade de cada produto. Se preferir, pode ser inserido um link de sugestão de produto.
    </div>

    <div class="col-sm-12">
            <div class="box-content">
                <div class="row center-block" style="padding-bottom: 10px;">
                    <h4>CONTRATANTE</h4>
                </div>
                <div class="row cnpj-row" data-cnpj="1">
                    {{-- CNPJ CONTRATANTE --}}
                    {{-- <div class="col-sm-3">
                        <div class="form-group">
                            <label for="textfield" class="control-label">CNPJ (utilizado para despesa)</label>
                            <select name="request[][cnpj]" id="s2" class='select2-me' style="width:100%;" data-placeholder="Escolha uma empresa do grupo">
                                    <option value="" disalbed></option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->corporate_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    {{-- CENTRO DE CUSTO --}}
                    {{-- <div class="col-sm-6">
                        <div class="form-group">
                            <label for="textfield" class="control-label">Centro(s) de custo da despesa</label>
                            <div class="select">
                                <select name="request[][cost_center]" id="batatinhas" multiple="multiple" placeholder="Selecione um ou mais centros de custo" class='select2-me' style="width:100%;">
                                    @foreach($costCenters as $costCenter)
                                    <option value="{{ $costCenter->id }}">{{ $costCenter->name }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div> --}}

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
                                class="radio_request" id="radio-request" type="radio" name="request[0][request_type]" value="services" servicesdata-skin="minimal"
                                style="background-color:black;">
                                <label class="form-check-label" for="services" style="margin-right:15px;">Serviços</label>
                                {{-- PRODUTOS --}}
                                <input checked
                                class="radio_request" id="radio-request" type="radio" name="request[0][request_type]"value="products" productsdata-skin="minimal">
                                <label class="form-check-label" for="personal">Produtos</label>
                            </div>
                        </div>
                        {{-- QUEM IRA COTAR --}}
                        <div class="col-sm-8">
                            <label for="form-check" class="control-label" style="margin-bottom: 12px;">Cotação será feita por:</label>
                            <div class="form-check" style="display:inline; margin-left:12px;">
                                {{-- SUPRIMENTOS --}}
                                <input checked
                                class="radio_request" type="radio" id="quoted_by" name="request[0][request"value="quoted_by_suprimentos" servicesdata-skin="minimal"
                                style="background-color:black;">
                                <label class="form-check-label" for="services" style="margin-right">Suprimentos</label>
                                {{-- EU FAREI --}}
                                <input style="margin-left:12px;"
                                class="radio_request" type="radio" name="request[0][request"value="quoted_by_user" productsdata-skin="minimal">
                                <label class="form-check-label" for="personal">Eu farei a cotação</label>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom:5px;">
                        <div class="product-row">
                            {{-- PRODUTO --}}
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="description" class="control-label">Descrição</label>
                                    <textarea name="description" id="description" rows="4" style="resize:none;" placeholder="Ex: Compra de 1 mesa para sala de reunião da HKM." class="form-control text-area"></textarea>
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

                    <div class="row">
                        {{-- ENDEREÇO PRODUTO/SERVIÇO --}}
                        <div class="col-sm-6" style="margin-bottom:8px;">
                        {{-- PRODUCT-INPUT --}}
                        <div class="form-group product-input" id="product-input">
                            <label for="local" class="control-label">Local de entrega do produto</label>
                            <input
                                type="text"
                                name="local-product"
                                id="local-product"
                                placeholder="Local onde será entregue o(s) produto(s) solicitados"
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2"
                            >
                        </div>
                        {{-- SERVICE-INPUT --}}
                        <div class="form-group product-input" id="service-input" hidden>
                            <label for="local" class="control-label">Local onde será prestado o serviço</label>
                            <input
                                type="text"
                                name="local-service"
                                id="local-service"
                                placeholder="Local para realização do serviço"
                                class="form-control"
                                data-rule-required="true"
                                data-rule-minlength="2"
                            >
                        </div>
                        </div>
                        {{-- COMEX --}}
                        <div class="col-sm-6" style="padding-top:30px;">
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
                    </div>

                    {{-- BTNs --}}

                    <div class="form-actions pull-right" style="margin-top:50px;">
                        <a  href="{{ route('quotationRegister') }}" target="_blank" class="btn btn-primary" style="margin-right:10px;">
                            SALVAR E COTAR
                            <i style="margin-left:5px;" class="glyphicon glyphicon-new-window"></i>
                        </a>
                        <button type="submit" class="btn btn-primary">SALVAR</button>
                        <a href="{{ url()->previous() }}" class="btn">CANCELAR</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app>

{{-- ADD +1 CENTRO DE CUSTO --}}
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
            // clonedRow.find('.select2-me').attr('id', 's2-' + cnpjCount).select2();
            clonedRow.find('.select2-me').each(function() {
                $(this).attr({
                    id: Math.random()
                })
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

{{-- SERVICES / PRODUCTS --}}
<script>
    $(document).ready(function() {
        $('.radio_request').change(function() {
            const selectedValue = $(this).val();

            if (selectedValue === 'services') {
                $('#service-input').show();
                $('#product-input').hide();
            } else if (selectedValue === 'products') {
                $('#service-input').hide();
                $('#product-input').show();
            }
        });
    });
</script>

{{-- QUOTED_BY --}}
<script>
    $(document).ready(function() {
    $('#quoted_by').change(function() {
        const selectedValue = $(this).val();
        const descriptionTextarea = $('#description');

        if (selectedValue === 'quoted_by_suprimentos') {
            descriptionTextarea.prop('required', true);
        } else if (selectedValue === 'quoted_by_user') {
            descriptionTextarea.prop('required', false);
        }
    });
});
</script>

{{-- SE COTADO POR SUPRIMENTOS, DESC REQURIED --}}
<script>
    $(document).ready(function() {
        $('.radio_request').change(function() {
          if ($(this).val() === 'quoted_by_suprimentos') {
            $('#description').addClass('required');
          } else {
            $('#description').removeClass('required');
          }
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
