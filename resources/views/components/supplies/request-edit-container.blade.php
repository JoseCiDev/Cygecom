@php
    use App\Enums\PurchaseRequestStatus;

    $currentUser = auth()->user();
@endphp


<h4 style="margin-bottom: 15px"><i class="glyphicon glyphicon-edit"></i> <strong>Editar solicitação</strong></h4>
<form class="form-validate" data-cy="form-request-edit" id="form-request-edit" method="POST"
    action="{{ route($route, ['id' => $requestId]) }}">
    @csrf
    <div class="form-group">
        <div class="row" style="margin-bottom: -15px;">

            <div class="col-sm-3">
                <label class="regular-text" for="amount">Editar valor total desta solicitação</label>
                <input type="text" placeholder="0,00" class="form-control format-amount" id="format-amount"
                    data-cy="format-amount" value="{{ $amount }}">
                <input type="hidden" name="{{ $inputName }}" id="amount" data-cy="amount"
                    class="amount no-validation" value="{{ $amount }}">
            </div>

            <div class="col-sm-3">
                <label for="status" class="regular-text">Status da solicitação</label>
                <select name="status" data-cy="status" id="status" @disabled($requestIsFromLogged)
                    class='chosen-select form-control'>
                    @foreach ($allRequestStatus as $status)
                        @if ($status->value !== PurchaseRequestStatus::RASCUNHO->value)
                            <option @selected($requestStatus === $status) value="{{ $status }}">
                                {{ $status->label() }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-sm-3">
                <label for="supplies_user_id" class="regular-text">Atribuir novo responsável</label>
                <select name="supplies_user_id" data-cy="supplies_user_id" id="supplies_user_id" class='select2-me'
                    style="width: 100%" placeholder="Escolher novo responsável" @disabled($requestIsFromLogged)>
                    <option disabled selected></option>
                    @foreach ($allowedResponsables as $responsableUser)
                        @php
                            $usersToNotShow = [$requestUserId, $currentUser->id];
                            if (in_array($responsableUser['id'], $usersToNotShow)) {
                                continue;
                            }
                        @endphp
                        <option value="{{ $responsableUser['id'] }}">
                            {{ $responsableUser['person']['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row div-reason-update" style="padding-top: 15px;" hidden>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="supplies-update-reason" class="regular-text">
                    Motivo para mudança de status
                </label>
                <textarea name="supplies_update_reason" id="supplies-update-reason"
                    data-cy="supplies-update-reason" rows="3" maxlength="200" minlength="5"
                    class="form-control text-area no-resize"></textarea>
            </div>
            <div class="small" style="margin-top:-10px; margin-bottom:20px;">
                <p class="secondary-text">* Informe o motivo para atualizar o status desta solicitação.</p>
            </div>
        </div>
    </div>

    <div class="row" style="padding-top: 15px">
        <div class="col-sm-3">
            <button data-cy="btn-edit-request" id="btn-edit-request" type="submit" class="btn btn-primary btn-small"
                @disabled($requestIsFromLogged)>
                Atualizar solicitação
            </button>
        </div>
    </div>
</form>

<script>
    $(() => {
        $form = $("#form-request-edit");
        $status = $('#status');
        $reasonUpdateStatus = $('#supplies-update-reason');
        $reasonUpdateStatusDiv = $('.div-reason-update');

        const statusOldValue = $status.val();

        $status.on('change', function() {
            if ($(this).val() === statusOldValue) {
                $reasonUpdateStatusDiv.attr('hidden', true);
                $reasonUpdateStatus.removeRequired();
                $reasonUpdateStatus.val('');
                return;
            }

            const isCancel = $(this).val() === 'cancelada';

            $reasonUpdateStatusDiv.attr('hidden', false);

            if (isCancel) {
                $reasonUpdateStatus.makeRequired();
                $reasonUpdateStatus.rules('add', {
                    required: true,
                    messages: {
                        required: 'Motivo é obrigatório para cancelar uma solicitação.',
                    },
                });
            } else {
                $reasonUpdateStatus.removeRequired();
            }
        });

        $form.on('submit', function(event) {
            event.preventDefault();

            const formIsValid = $form.valid();

            if(!formIsValid) {
                return;
            }

            const statusValue = $('#status').find(':selected').text();
            const reasonUpdateStatus = $reasonUpdateStatus.val() ?? '' ;
            const amountValue = "R$ " + $('#amount').val();
            const responsibleValue = $('#supplies_user_id').find(':selected').text();

            bootbox.confirm({
                title: 'Atenção! Deseja realmente alterar os dados?',
                className: 'regular-text',
                message: "Por favor, confirme os dados que serão enviados: " +
                    "<ul>" +
                    `<li class="regular-text" >Status: ${statusValue}</li>` +
                    (reasonUpdateStatus ? `<li class="regular-text">Motivo mudança de status: ${reasonUpdateStatus}</li>` : '') +
                    `<li class="regular-text">Valor total: ${amountValue}</li>` +
                    (responsibleValue.length ? `<li>Responsável: ${responsibleValue}</li>` :
                        '') +
                    "</ul>",
                buttons: {
                    confirm: {
                        label: 'Sim, atualizar solicitação',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        label: 'Cancelar',
                        className: 'btn btn-small'
                    }
                },
                callback: function(result) {
                    if (result) {
                        $form.off('submit');
                        $form.trigger('submit');
                    }
                }
            });
        });
    });
</script>