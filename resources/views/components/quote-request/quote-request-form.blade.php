<div class="box-title">
    <div class="row">
        <div class="col-md-6">
            <h3 style="color: white; margin-top: 5px">
                {{isset($quoteRequest) ? 'Editar solicitação de compra' : 'Criar solicitação de compra' }}
            </h3>
        </div>   
        @if (isset($quoteRequest))
            <div class="col-md-6 pull-right">
                <x-modalDelete/>
                <button  data-route="quoteRequests" data-name="{{'Solicitação de compra - ID ' . $quoteRequest->id}}" data-id="{{$quoteRequest->id}}" data-toggle="modal" data-target="#modal"
                    rel="tooltip" title="Excluir" class="btn btn-danger pull-right" style="margin-right: 15px">
                    Excluir solicitação
                </button>
            </div>
        @endif    
    </div>
</div>

<div class="box-content">
    <form class="form-validate" id="request-form" method="POST" 
            action="@if (isset($quoteRequest) && !$isCopy) {{route( 'request.update', ['id' => $id])}}
                    @else {{route( 'request.register')}} 
                @endif">
        @csrf

        <div class="row center-block" style="padding-bottom: 10px;">
            <h4>CONTRATANTE</h4>
        </div>
        <div class="row cnpj-row" data-cnpj="1">

            <div class="col-sm-6">
                <label for="textfield" class="control-label">Centro de custo da despesa</label>
                <select name="cost_center_apportionments[cost_center_id]" id="cost_center_id" class='chosen-select form-control @error('cost_center_id') is-invalid @enderror' required data-rule-required="true">
                    @foreach($costCenters as $costCenter)
                        <option value="{{ $costCenter->id }}" {{ isset($user->person->costCenter) && $user->person->costCenter->id == $costCenter->id ? 'selected' : '' }}>
                            {{ $costCenter->name  }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="cost_center_apportionments[apportionment_percentage]" class="control-label"><sup style="color:red">*</sup>Rateio</label>
                <div class="input-group">
                    <span class="input-group-addon">%</span>
                    <input type="number" name="cost_center_apportionments[apportionment_percentage]" id="cost_center_apportionments[apportionment_percentage]" placeholder="0.00" class="form-control" min="0">
                    @error('cost_center_apportionments[apportionment_percentage]') <p><strong>{{ $message }}</strong></p> @enderror
                </div>
            </div>

            <div class="col-md-2">
                <label for="cost_center_apportionments[apportionment_value]" class="control-label"><sup style="color:red">*</sup>Rateio</label>
                <div class="input-group">
                    <span class="input-group-addon">R$</span>
                    <input type="number" name="cost_center_apportionments[apportionment_value]" id="cost_center_apportionments[apportionment_value]" placeholder="0.00" class="form-control" min="0">
                    @error('cost_center_apportionments[apportionment_value]') <p><strong>{{ $message }}</strong></p> @enderror
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
                <div class="col-sm-4">
                    <label for="form-check" class="control-label" style="margin-bottom: 12px;">Estou solicitando:</label>
                    <div class="form-check" style="display:inline; margin-left:12px;">
                        <input name="is_service" value="1" checked
                                class="radio_request" id="radio-request" type="radio" servicesdata-skin="minimal">
                        <label class="form-check-label" for="services" style="margin-right:15px;">Serviços</label>
                        <input name="is_service"value="0" @if (isset($quoteRequest) && !$quoteRequest->is_service) checked @endif
                                class="radio_request" id="radio-request" type="radio"  productsdata-skin="minimal">
                        <label class="form-check-label" for="personal">Produtos</label>
                    </div>
                </div>
                <div class="col-sm-8">
                    <label for="form-check" class="control-label" style="margin-bottom: 12px;">Cotação será feita por:</label>
                    <div class="form-check" style="display:inline; margin-left:12px;">
                        <input checked class="radio_request" type="radio" id="supplie_quote" name="is_supplies_quote"value="1" servicesdata-skin="minimal">
                        <label class="form-check-label" for="services" style="margin-right">Suprimentos</label>
                        <input name="is_supplies_quote"value="0" @if (isset($quoteRequest) && !$quoteRequest->is_supplies_quote) checked @endif
                                style="margin-left:12px;" class="radio_request" type="radio" id="user_quote" productsdata-skin="minimal">
                        <label class="form-check-label" for="personal">Eu farei a cotação</label>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-bottom:5px;">
                <div class="product-row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="description" class="control-label">Descrição</label>
                            <textarea name="description" id="description" rows="4" style="resize:none;" placeholder="Ex: Compra de 1 mesa para sala de reunião da HKM."
                                class="form-control text-area">@if (isset($quoteRequest)) {{$quoteRequest->description}} @endif</textarea>
                        </div>
                        <div class="small" style="color:rgb(85, 85, 85); margin-top:-10px; margin-bottom:20px;">
                            <p>* Descreva com detalhes o que deseja solicitar e informações úteis para uma possível cotação. </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6" style="margin-bottom:8px;">
                    <div class="form-group product-input" id="product-input">
                        <label for="local_description" class="control-label">Local de entrega do produto</label>
                        <input name="local_description" value="@if (isset($quoteRequest)) {{$quoteRequest->local_description}} @endif"
                                type="text" id="local_description" placeholder="Local onde será entregue o(s) produto(s) solicitados" class="form-control" data-rule-required="true" data-rule-minlength="2">
                    </div>
                </div>
                <div class="col-sm-6" style="padding-top:30px;">
                    <label for="form-check" class="control-label" style="padding-right:10px;">Produto importado pelo COMEX?</label>
                    <div class="form-check" style="12px; display:inline;">
                        <input name="is_comex" value="1" @if (isset($quoteRequest) && $quoteRequest->is_comex) checked @endif
                                class="radio-comex" type="radio"  data-skin="minimal">
                        <label class="form-check-label" for="services" style="margin-right:15px;">Sim</label>
                        <input name="is_comex"value="0" @if (isset($quoteRequest) && !$quoteRequest->is_comex) checked @endif
                                class="radio-comex" type="radio" data-skin="minimal">
                        <label class="form-check-label" for="">Não</label>
                    </div>
                </div>
            </div>

        <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="desired_date" class="control-label">Data desejada</label>
                        <input type="date" name="desired_date" id="desired_date" value="{{(isset($quoteRequest) && $quoteRequest->desired_date) ? $quoteRequest->desired_date : ""}}">
                    </div>
                </div>
                <div class="col-sm-10">
                    <label for="quote_request_files[path]" class="control-label">Link de exemplo do produto/serviço</label>
                    <input value="{{(isset($quoteRequest->quoteRequestFile[0]) && $quoteRequest->quoteRequestFile[0]->path) ? $quoteRequest->quoteRequestFile[0]->path : ""}}"
                            type="text" placeholder="Adicone um link válido" name="quote_request_files[path]" id="quote_request_files[path]" data-rule-url="true" class="form-control">
                </div>
        </div>

            <div class="form-actions pull-right" style="margin-top:50px;">
                <input type="hidden" name="isSaveAndQuote" value="0">
                <button type="button" class="btn btn-primary" id="isSaveAndQuote">
                    Salvar e cotar
                    <i style="margin-left:5px;" class="glyphicon glyphicon-new-window"></i>
                </button>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
            </div>

        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
      $('#isSaveAndQuote').click(function() {
        $('input[name="isSaveAndQuote"]').val('1');
        $('#request-form').submit();
      });
    });
    </script>

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
