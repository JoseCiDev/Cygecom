<style>
    .cost-center-container {
        margin-bottom: 10px
    }
</style>

<div class="box-title">
    <div class="row">
        <div class="col-md-6">
            <h3 style="color: white; margin-top: 5px">
                {{ isset($purchaseRequest) ? 'Editar solicitação' : 'Criar solicitação' }}
            </h3>
        </div>
        @if (isset($purchaseRequest))
            <div class="col-md-6 pull-right">
                <x-modalDelete />
                <button data-route="purchaseRequests" data-name="{{ 'Solicitação de compra - ID ' . $purchaseRequest->id }}"
                    data-id="{{ $purchaseRequest->id }}" data-toggle="modal" data-target="#modal" rel="tooltip"
                    title="Excluir" class="btn btn-danger pull-right" style="margin-right: 15px">
                    Excluir solicitação
                </button>
            </div>
        @endif
    </div>
</div>

<div class="box-content">
    <form class="form-validate" id="request-form" method="POST"
        action="@if (isset($purchaseRequest) && !$isCopy) {{ route('request.service.update', ['id' => $id]) }}
                    @else {{ route('request.service.register') }} @endif">
        @csrf

        <input type="hidden" name="type" value="service">

        <div class="row center-block" style="padding-bottom: 10px;">
            <h4>CONTRATANTE</h4>
        </div>

        {{-- CENTRO DE CUSTOS --}}
        @if (isset($purchaseRequest))
            @foreach ($purchaseRequest->costCenterApportionment as $index => $apportionment)
                <div class="row cost-center-container">
                    <div class="col-sm-6">
                        <label style="display:block;" for="textfield" class="control-label">Centro de custo da despesa</label>
                        <select
                            name="cost_center_apportionments[{{ $index }}][cost_center_id]"
                            class='select2-me @error('cost_center_id_{{ $index }}') is-invalid @enderror'
                            required
                            data-rule-required="true"
                            style="width:100%;"
                            placeholder="Ex: Almoxarifado"
                        >
                            <option value=""></option>
                            @foreach ($costCenters as $costCenter)
                                @php
                                    $isApportionmentSelect = isset($apportionment) && $apportionment->cost_center_id === $costCenter->id;
                                @endphp
                                <option value="{{ $costCenter->id }}" {{ $isApportionmentSelect ? 'selected' : '' }}>
                                    {{ $costCenter->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
                            class="control-label">
                            <sup style="color:red">*</sup>Rateio (%)
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">%</span>
                            <input type="number" placeholder="0.00" class="form-control" min="0"
                                name="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
                                id="cost_center_apportionments[{{ $index }}][apportionment_percentage]"
                                value="{{ $apportionment->apportionment_percentage }}">
                            @error('cost_center_apportionments[{{ $index }}][apportionment_percentage]')
                                <p><strong>{{ $message }}</strong></p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label for="cost_center_apportionments[{{ $index }}][apportionment_currency]"
                            class="control-label">
                            <sup style="color:red">*</sup>Rateio (R$)
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input type="number" placeholder="0.00" class="form-control" min="0"
                                name="cost_center_apportionments[{{ $index }}][apportionment_currency]"
                                id="cost_center_apportionments[{{ $index }}][apportionment_currency]"
                                value="{{ $apportionment->apportionment_currency }}">
                            @error('cost_center_apportionments[{{ $index }}][apportionment_currency]')
                                <p><strong>{{ $message }}</strong></p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-1" style="margin-top: 28px;">
                        <button class="btn btn-icon btn-small btn-danger delete-cost-center"><i
                                class="fa fa-trash-o"></i></button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row cost-center-container">
                <div class="col-sm-6">
                    <label for="textfield" class="control-label" style="display:block">
                        Centro de custo da despesa
                    </label>
                    <select
                        style="width:100%" name="cost_center_apportionments[0][cost_center_id]"
                        class='select2-me
                        @error('cost_center_id_{{ $index }}') is-invalid @enderror'
                        required data-rule-required="true" placeholder="Ex: Almoxarifado"
                    >
                        <option value="" disalbed></option>
                        @foreach ($costCenters as $costCenter)
                            @php
                                $isUserCostCenter = isset($user->person->costCenter) && $user->person->costCenter->id == $costCenter->id;
                                $costCenterCompanyName = $costCenter->company->corporate_name;
                                $costCenterName = $costCenter->name;
                                $costCenterSeniorCode = $costCenter->senior_code;
                            @endphp
                            <option value="{{ $costCenter->id }}" {{ $isUserCostCenter ? 'selected' : '' }}>
                                {{ $costCenterCompanyName . ' - ' . $costCenterName . ' - ' . $costCenterSeniorCode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="cost_center_apportionments[0][apportionment_percentage]" class="control-label">
                        <sup style="color:red">*</sup>Rateio (%)
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon">%</span>
                        <input type="number" placeholder="0.00" class="form-control" min="0"
                            name="cost_center_apportionments[0][apportionment_percentage]"
                            id="cost_center_apportionments[0][apportionment_percentage]">
                        @error('cost_center_apportionments[0][apportionment_percentage]')
                            <p><strong>{{ $message }}</strong></p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-2">
                    <label for="cost_center_apportionments[0][apportionment_currency]" class="control-label">
                        <sup style="color:red">*</sup>Rateio (R$)
                    </label>
                    <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        <input type="number" name="cost_center_apportionments[0][apportionment_currency]"
                            id="cost_center_apportionments[0][apportionment_currency]" placeholder="0.00"
                            class="form-control" min="0">
                        @error('cost_center_apportionments[0][apportionment_currency]')
                            <p><strong>{{ $message }}</strong></p>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-1" style="margin-top: 28px;">
                    <button class="btn btn-icon btn-small btn-danger delete-cost-center">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        @endif

        {{-- ADICIONAR CENTRO DE CUSTO --}}
        <button type="button" class="btn btn-small btn-primary add-cost-center-btn">
            Adicionar linha
        </button>
        {{-- CENTRO DE CUSTO FIM --}}

        <hr>

        <div class="full-product-line product-form" data-product="1">
            <div class="row center-block" style="padding-bottom: 10px;">
                <h4>DADOS DA SOLICITAÇÃO</h4>
            </div>

            <div class="row" style="margin-bottom:5px;">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="reason" class="control-label"><sup style="color: red;">*</sup>Motivo da
                            solicitação</label>
                        <textarea required name="reason" id="reason" rows="4"
                            placeholder="Fatores de ex.: Necessidade de reposição de estoque, atender a demanda de um projeto específico, cumprir requisitos regulatórios ou normas de qualidade..."
                            class="form-control text-area no-resize">@if (isset($purchaseRequest)){{ $purchaseRequest->reason }}@endif</textarea>
                    </div>
                    <div class="small" style="color:rgb(85, 85, 85); margin-top:-10px; margin-bottom:20px;">
                        <p>Por favor, forneça uma breve descrição do motivo pelo qual você está solicitando essa compra.
                        </p>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="description" class="control-label"><sup class="description-span"
                                style="color: red;">*</sup>Descrição</label>
                        <textarea required name="description" id="description" rows="4" placeholder="Ex.: Compra de 1 mesa para sala de reunião da HKM." class="form-control text-area no-resize"
                        >@if (isset($purchaseRequest)){{ $purchaseRequest->description }}@endif</textarea>
                    </div>
                    <div class="small" style="color:rgb(85, 85, 85); margin-top:-10px; margin-bottom:20px;">
                        <p>* Descreva com detalhes o que deseja solicitar e informações úteis para uma possível cotação.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6" style="margin-bottom:8px;">
                    <div class="form-group product-input" id="product-input">
                        <label for="local_description" class="control-label"><sup style="color: red">*</sup>Local de
                            entrega do produto</label>
                        <input name="local_description"
                            value="@if (isset($purchaseRequest)) {{ $purchaseRequest->local_description }} @endif"
                            type="text" id="local_description"
                            placeholder="Local onde será entregue o(s) produto(s) solicitados" class="form-control"
                            data-rule-required="true" data-rule-minlength="2">
                    </div>
                </div>
                <div class="col-sm-6" style="padding-top:30px;">
                    <label for="form-check" class="control-label" style="padding-right:10px;"><sup
                            style="color: red">*</sup>Produto importado pelo COMEX?</label>
                    <div class="form-check" style="12px; display:inline;">
                        <input name="is_comex" value="1" @if (isset($purchaseRequest) && $purchaseRequest->is_comex) checked @endif
                            class="radio-comex" type="radio" data-skin="minimal">
                        <label class="form-check-label" for="services" style="margin-right:15px;">Sim</label>
                        <input name="is_comex"value="0" @if (isset($purchaseRequest) && !$purchaseRequest->is_comex) checked @endif
                            class="radio-comex" type="radio" data-skin="minimal">
                        <label class="form-check-label" for="">Não</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="desired_date" class="control-label">Data desejada</label>
                        <input type="date" name="desired_date" id="desired_date"
                            value="{{ isset($purchaseRequest) && $purchaseRequest->desired_date ? $purchaseRequest->desired_date : '' }}">
                    </div>
                </div>
                <div class="col-sm-10">
                    <label for="purchase_request_files[path]" class="control-label">Link de exemplo do
                        produto/serviço</label>
                    <input
                        value="{{ isset($purchaseRequest->purchaseRequestFile[0]) && $purchaseRequest->purchaseRequestFile[0]->path ? $purchaseRequest->purchaseRequestFile[0]->path : '' }}"
                        type="text" placeholder="Adicone um link válido" name="purchase_request_files[path]"
                        id="purchase_request_files[path]" data-rule-url="true" class="form-control">
                </div>
            </div>

             {{-- SERVIÇO --}}
             <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="observation" class="control-label"> Observação </label>
                        <textarea name="observation" rows="4" placeholder="Observação" class="form-control text-area no-resize"></textarea>
                    </div>
                </div>
            </div>

             <div class="row">
               
                <div class="col-sm-6 form-group">
                    <label style="display:block;" for="service[supplier_id]" class="control-label"><sup style="color:red">*</sup>Fornecedor (CNPJ - RAZÃO SOCIAL)</label>
                    <select name="service[supplier_id]" class='select2-me' data-rule-required="true" data-placeholder="Escolha uma fornecedor" style="width:100%;" >
                        <option value=""></option>
                        @foreach ($suppliers as $supplier)
                            @php $supplierSelected = isset($purchaseRequest->service[0]) && $purchaseRequest->service[0]->supplier_id === $supplier->id; @endphp
                            <option value="{{ $supplier->id }}" @selected($supplierSelected)>{{ "$supplier->cpf_cnpj - $supplier->corporate_name" }}</option>
                        @endforeach
                    </select>
                </div>
              
            </div>

            <div class="row">
                <div class="col-md-6" style="margin-top: 15px">
                    <label for="service[description]" class="control-label">Descrição do serviço</label>
                    <textarea required name="service[description]" rows="4" placeholder="Serviço" 
                        class="form-control text-area no-resize">@if (isset($purchaseRequest->service[0])){{$purchaseRequest->service[0]->description}}@endif</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" style="margin-top: 15px">
                    <div><label for="service[payday]" class="control-label">Data de pagamento</label></div>
                    <input type="date" name="service[payday]" value="@if(isset($purchaseRequest->service[0])){{$purchaseRequest->service[0]->payday}}@endif">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" style="margin-top: 15px">
                    <input type="checkbox" name="service[is_finished]" value="1" @checked(isset($purchaseRequest->service[0]) && $purchaseRequest->service[0]->is_finished)>
                    <label for="service[is_finished]" class="control-label">Serviço finalizado</label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" style="margin-top: 15px">
                    <label for="service[local_service]" class="control-label">Local do serviço</label>
                    <textarea required name="service[local_service]" rows="4" placeholder="Local do serviço" 
                    class="form-control text-area no-resize">@if (isset($purchaseRequest->service[0])){{$purchaseRequest->service[0]->local_service}} @endif</textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" style="margin-top: 15px">
                    <label for="" class="control-label"> <sup style="color:red">*</sup>Preço (R$) </label>
                    <div class="input-group">
                        <span class="input-group-addon">R$</span>
                        <input name="service[price]" type="number" placeholder="0.00" class="form-control" min="0" 
                            value="@if(isset($purchaseRequest->service[0])){{$purchaseRequest->service[0]->price}}@endif" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" style="margin-top: 15px">
                    <div><label for="service[hours_performed]" class="control-label">Horas executadas</label></div>
                    <input type="text" name="service[hours_performed]" value="@if (isset($purchaseRequest->service[0])){{$purchaseRequest->service[0]->hours_performed}}@endif">
                </div>
            </div>
            <hr>
            <div class="row">
                 <div class="col-md-6" style="margin-top: 15px">
                    <div><label for="service[service_payment_info][payment_type]" class="control-label">Tipo de pagamento</label></div>
                    <input type="text" name="service[service_payment_info][payment_type]" value="@if (isset($purchaseRequest->service[0]->servicePaymentInfo[0])){{$purchaseRequest->service[0]->servicePaymentInfo[0]->payment_type}}@endif">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" style="margin-top: 15px">
                    <div><label for="service[service_payment_info][payment_type]" class="control-label">Informação/Descrição do pagamento</label></div>
                    <input type="text" name="service[service_payment_info][description]" ,
                        value="@if (isset($purchaseRequest->service[0]->servicePaymentInfo[0])){{$purchaseRequest->service[0]->servicePaymentInfo[0]->description}}@endif">
                </div>
            </div>
             {{-- END SERVIÇO --}}

             <div class="form-actions pull-right" style="margin-top:50px;">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ url()->previous() }}" class="btn">Cancelar</a>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        const $costCenterPercentage = $('.cost-center-container input[name$="[apportionment_percentage]"]');
        const $costCenterCurrency = $('.cost-center-container input[name$="[apportionment_currency]"]');

        // Verifica quem vai cotar e aplica regra em campo description
        $('input[name="is_supplies_quote"]').change(function() {
            if ($('#supplie_quote').is(':checked')) {
                $('#description').prop('required', true)
                $('.description-span').show()
            } else {
                $('#description').prop('required', false)
                $('.description-span').hide()
            }
        });

        function disableSelectedOptions() {
            const selectedValues = $.map($('.cost-center-container select'), (self) => {
                return $(self).val();
            });
            $('.cost-center-container option').each((_, option) => {
                const includedValues = selectedValues.includes($(option).prop('value'));
                const isSelectedOption = $(option).is(':selected');
                const disabled = includedValues && !isSelectedOption;
                $(option).prop({disabled});
            })
        }

        function checkCostCenterCount() {
            const costCenterCount = $('.cost-center-container').length;
            costCenterCount > 1 ? $('.delete-cost-center').prop('disabled', false) : $('.delete-cost-center')
                .prop('disabled', true);
        }
        checkCostCenterCount()

        function updateApportionmentFields() {
            const hasPercentageInput = $costCenterPercentage.filter(function() {
                return $(this).val() !== '';
            }).length > 0;

            const hasCurrencyInput = $costCenterCurrency.filter(function() {
                return $(this).val() !== '';
            }).length > 0;

            $costCenterPercentage.not(':disabled').prop('disabled', !hasPercentageInput && hasCurrencyInput);
            $costCenterCurrency.not(':disabled').prop('disabled', !hasCurrencyInput && hasPercentageInput);

            if (!hasPercentageInput && !hasCurrencyInput) {
                $costCenterPercentage.prop('disabled', false);
                $costCenterCurrency.prop('disabled', false);
            }
        }
        updateApportionmentFields();

        // Desabilita os outros campos de "rateio" de outro tipo quando um tipo é selecionado
        $costCenterPercentage.add($costCenterCurrency).on('input', updateApportionmentFields);

        // Add Centro de Custo
        $('.add-cost-center-btn').click(function() {
            updateApportionmentFields();
            const newRow = $('.cost-center-container').last().clone();
            newRow.find(
                'select[name^="cost_center_apportionments"], input[name^="cost_center_apportionments"]'
                ).each(function() {
                const oldName = $(this).attr('name');
                const regexNewName = /\[(\d+)\]/;
                const lastIndex = Number(oldName.match(regexNewName).at(-1));
                const newName = oldName.replace(regexNewName, `[${lastIndex + 1}]`);
                $(this).attr('name', newName);
            });

            newRow.find("input, select").val("");
            newRow.find('.select2-container').remove();
            newRow.find('.select2-me').select2();

            $('.cost-center-container').last().after(newRow);
            newRow.find('.delete-cost-center').removeAttr('hidden');
            checkCostCenterCount();
            disableSelectedOptions();
        });

        $(document).on('click', '.delete-cost-center', function() {
            $(this).closest('.cost-center-container').remove();
            updateApportionmentFields();
            checkCostCenterCount();
            disableSelectedOptions();
        });

        $(document).on('change', '.cost-center-container .select2-me', disableSelectedOptions);
    });
</script>
