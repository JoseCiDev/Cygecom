@php
    use App\Enums\{PurchaseRequestStatus, ERP};

    $currentUser = auth()->user();
    $statusFinish = PurchaseRequestStatus::FINALIZADA->value;
    $requestStatusIsFinish = $requestStatus === PurchaseRequestStatus::FINALIZADA;
@endphp

@push('styles')
    <style>
        .confirm-update-list {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        #amount-update-info {
            right: 25px;
            top: 34px;
            font-size: 14px;
            color: var(--gold-primary-color);
            display: block;
            font-weight: bold;
        }
    </style>
@endpush

<h4 style="margin-bottom: 15px"><i class="glyphicon glyphicon-edit"></i> <strong>Editar solicitação</strong></h4>
<form class="form-validate" data-cy="form-request-edit" id="form-request-edit" method="POST" action="{{ route($route, ['purchaseRequest' => $requestId]) }}">
    @csrf
    <div class="form-group">
        <div class="row" style="margin-bottom: -15px;">

            <div class="col-sm-3 mb-3 form-group">
                <label class="regular-text" for="amount" id="amount-label">Editar valor total desta solicitação
                </label>
                <input type="text" placeholder="0,00" class="form-control format-amount" id="format-amount" data-cy="format-amount" value="{{ $amount }}"
                    @disabled($requestIsFromLogged)>
                <input type="hidden" name="{{ $inputName }}" id="amount" data-cy="amount" class="amount no-validation" value="{{ $amount }}">
                <span id="amount-update-info">
                    <span data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Valor original é fornecido pelo solicitante ao criar solicitação.<br> Valor final é o valor acordado com fornecedor em cotação.">
                        <i class="fa-solid fa-circle-info"></i>
                    </span>

                    {{ $hasUpdateOnAmount ? 'Valor final alterado por suprimentos' : 'Valor original' }}
                </span>
            </div>

            <div class="col-sm-3 mb-3 form-group">
                <label for="status" class="regular-text">Status da solicitação</label>
                <select name="status" data-cy="status" id="status" @disabled($requestIsFromLogged) class='select2-me' style="width:100%;">
                    @foreach ($allRequestStatus as $status)
                        @php
                            $isSelected = $requestStatus === $status;
                            $isPending = $requestStatus->value === PurchaseRequestStatus::PENDENTE->value && $status->value === PurchaseRequestStatus::PENDENTE->value;
                            $canRender = $isPending || ($status->value !== PurchaseRequestStatus::RASCUNHO->value && $status->value !== PurchaseRequestStatus::PENDENTE->value);
                        @endphp

                        @if ($canRender)
                            <option @selected($isSelected) value="{{ $status }}">
                                {{ $status->label() }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-sm-3 mb-3 form-group">
                <label for="supplies_user_id" class="regular-text">Atribuir novo responsável</label>
                <select name="supplies_user_id" data-cy="supplies_user_id" id="supplies_user_id" class='select2-me' style="width: 100%" placeholder="Escolher novo responsável"
                    @disabled($requestIsFromLogged)>
                    <option disabled selected></option>
                    @foreach ($allowedResponsables as $responsableUser)
                        @php
                            if ($responsableUser['id'] === $requestUserId) {
                                continue;
                            }
                        @endphp
                        <option value="{{ $responsableUser['id'] }}">
                            {{ $responsableUser['person']['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-3 mb-3" style="min-width: 360px">
                <div class="d-flex gap-3">
                    <label for="purchase_order" class="regular-text">Ordem de compra</label>
                    <div class="d-flex gap-2">
                        <div class="form-check form-group">
                            <input class="form-check-input" type="radio" value="callisto" id="erp_callisto" name="erp" @disabled(!$purchaseOrder || ($purchaseOrder && !$requestStatusIsFinish))
                                @checked(ERP::CALLISTO->value === $erp?->value)>
                            <label class="form-check-label" for="erp_callisto"> Callisto </label>
                        </div>
                        <div class="form-check form-group">
                            <input class="form-check-input" type="radio" value="senior" id="erp_senior" name="erp" @disabled(!$purchaseOrder || ($purchaseOrder && !$requestStatusIsFinish)) @checked(ERP::SENIOR->value === $erp?->value)>
                            <label class="form-check-label" for="erp_senior"> Senior </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" name="purchase_order" id="purchase_order" data-cy="purchase_order" class="form-control" maxlength="20"
                        placeholder="Disponível ao finalizar solicitação" value="{{ $purchaseOrder }}" @disabled(!$purchaseOrder || ($purchaseOrder && !$requestStatusIsFinish))>
                </div>
            </div>

            <div class="col-sm-3 div-reason-update" style="display: none">
                <div class="form-group">
                    <label for="supplies-update-reason" class="regular-text">
                        Motivo para mudança de status
                    </label>
                    <textarea name="supplies_update_reason" id="supplies-update-reason" data-cy="supplies-update-reason" rows="3" maxlength="200" minlength="5"
                        class="form-control text-area no-resize"></textarea>
                </div>
                <div class="small" style="margin-top: 10px;">
                    <p class="secondary-text">Informe o motivo para atualizar o status desta solicitação.</p>
                </div>
            </div>

        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-3">
            @if (Gate::any(['post.supplies.service.update', 'post.supplies.contract.update', 'post.supplies.product.update']))
                <button data-cy="btn-edit-request" id="btn-edit-request" type="submit" class="btn btn-primary btn-small" @disabled($requestIsFromLogged)>
                    Atualizar solicitação
                </button>
            @endif
        </div>
    </div>
</form>

@push('scripts')
    <script type="module">
        $(() => {
            const statusFinish = @json($statusFinish);
            const $purchaseOrder = $("#purchase_order");
            const $erp = $('input[name="erp"]');
            const $form = $("#form-request-edit");
            const $status = $('#status');
            const $reasonUpdateStatus = $('#supplies-update-reason');
            const $reasonUpdateStatusDiv = $('.div-reason-update');
            const oldStatusValue = $status.val();
            const requestStatusCancel = @json(PurchaseRequestStatus::CANCELADA);
            const $formatAmount = $('#format-amount');

            let maskInstances = [];

            const handleChangeStatus = (event) => {
                const currentValue = $(event.target).val();

                if (currentValue === oldStatusValue) {
                    const isFinished = currentValue === statusFinish;
                    const hasTotalAmount = $formatAmount.val();

                    $reasonUpdateStatusDiv.hide();
                    $reasonUpdateStatus.removeRequired();
                    $reasonUpdateStatus.val('');

                    if (isFinished && !hasTotalAmount) {
                        $formatAmount.makeRequired();
                    } else {
                        $formatAmount.removeRequired();
                    }

                    return;
                }

                if (currentValue === statusFinish) {
                    $purchaseOrder.add($erp).makeRequired();
                    $erp.prop('disabled', false);
                    $purchaseOrder.attr('placeholder', 'Escolha o ERP');
                    $formatAmount.makeRequired();
                } else {
                    $erp.prop('checked', false);
                    $purchaseOrder.add($erp).removeRequired();
                    $purchaseOrder.attr('placeholder', 'Disponível ao finalizar solicitação')
                    $purchaseOrder.add($erp).prop('disabled', true);
                    $purchaseOrder.val(null);

                    $formatAmount.removeRequired().valid();
                }

                $reasonUpdateStatusDiv.show();

                const isCancel = currentValue === requestStatusCancel;

                if (isCancel) {
                    $reasonUpdateStatus.makeRequired();
                    $reasonUpdateStatus.rules('add', {
                        required: true,
                        messages: {
                            required: 'Motivo é obrigatório para cancelar uma solicitação.'
                        },
                    });
                } else {
                    $reasonUpdateStatus.removeRequired();
                    $reasonUpdateStatus.rules('remove', 'required');
                }
            }

            const submit = (event) => {
                event.preventDefault();

                const formIsValid = $form.valid();

                if (!formIsValid) {
                    return;
                }

                const statusValue = $('#status').find(':selected').text();
                const reasonUpdateStatus = $reasonUpdateStatus.val() ?? '';
                const amountValue = "R$ " + $('#amount').val();
                const responsibleValue = $('#supplies_user_id').find(':selected').text();

                const title = 'Atenção! Deseja realmente alterar os dados?';
                const message = "Por favor, confirme os dados que serão enviados: " +
                    "<ul class='confirm-update-list'>" +
                    `<li class="regular-text" >Status: ${statusValue}</li>` +
                    (reasonUpdateStatus ? `<li class="regular-text">Motivo mudança de status: ${reasonUpdateStatus}</li>` : '') +
                    `<li class="regular-text">Valor total: ${amountValue}</li>` +
                    (responsibleValue.length ? `<li>Responsável: ${responsibleValue}</li>` :
                        '') +
                    "</ul>";

                $.fn.showModalAlert(title, message, () => {
                    $form.off('submit');
                    $form.trigger('submit');
                })
            }

            const checkErp = () => {
                const placeholderCallisto = 'Ex.: 08454/14';
                const placeholderSenior = 'Ex.: 9929';
                const erpChecked = $erp.filter(':checked').val();

                if (!erpChecked) {
                    return;
                }

                $purchaseOrder.attr('placeholder', erpChecked === 'callisto' ? placeholderCallisto : placeholderSenior);
                $purchaseOrder.attr('disabled', false);
                $purchaseOrder.trigger('input').focus();
            }

            const applyMask = (input) => {
                const currentTarget = $(input.target);
                const value = currentTarget.val().replace(/\D/g, '');
                if (!value) {
                    currentTarget.val('');
                    return;
                }

                if ($erp.filter(':checked').val() === Enum.ERP.SENIOR) {
                    currentTarget.val(value);
                    return;
                }

                if (value.length < 3) {
                    return;
                }

                const prefixe = value.slice(0, -2);
                const sufixe = value.slice(-2);

                currentTarget.val(`${prefixe}/${sufixe}`);
            }

            $purchaseOrder.on('input', applyMask).trigger('input');
            $erp.on('change', checkErp);
            $status.on('change', handleChangeStatus).trigger('change');
            $form.on('submit', submit);
        });
    </script>
@endpush