@php
    use App\Enums\PurchaseRequestStatus;
@endphp

<h4 style="margin-bottom: 15px"><i class="glyphicon glyphicon-edit"></i> <strong>Editar solicitação</strong></h4>
<form class="form-validate" data-cy="form-request-edit" id="form-request-edit" method="POST"
    action="{{ route($route, ['id' => $requestId]) }}">
    @csrf
    <div class="form-group">
        <div class="row" style="margin-bottom: -15px;">

            <div class="col-md-2">
                <label class="regular-text" for="amount">Editar valor total desta solicitação</label>
                <input type="text" placeholder="0,00" class="form-control format-amount" id="format-amount"
                    data-cy="format-amount" value="{{ $amount }}">
                <input type="hidden" name="{{ $inputName }}" id="amount" data-cy="amount"
                    class="amount no-validation" value="{{ $amount }}">
            </div>

            <div class="col-md-2">
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

            <div class="col-md-2">
                <label for="supplies_user_id" class="regular-text">Atribuir novo responsável</label>
                <select name="supplies_user_id" data-cy="supplies_user_id" id="supplies_user_id" class='select2-me'
                    style="width: 100%" placeholder="Escolher novo responsável" @disabled($requestIsFromLogged)>
                    @foreach ($allowedResponsables as $user)
                        <option disabled selected></option>
                        <option value="{{ $user['id'] }}">
                            {{ $user['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="col-sm-4">
                <div class="form-group">
                    <label for="observation" class="regular-text">
                        Motivo da atualização
                    </label>
                    <textarea name="supplies_update_reason" id="observation" data-cy="observation" rows="3"
                        class="form-control text-area no-resize"></textarea>
                </div>
                <div class="small" style="margin-top:-10px; margin-bottom:20px;">
                    <p class="secondary-text">* Informe o motivo para atualizar os dados desta solicitação.</p>
                </div>
            </div> --}}

        </div>
    </div>

    <button data-cy="btn-edit-request" id="btn-edit-request" type="submit" class="btn btn-primary btn-small"
        @disabled($requestIsFromLogged)>
        Atualizar solicitação
    </button>
</form>

<script>
    $(() => {
        $form = $("#form-request-edit");
        $status = $('#status');

        let textareaConfirmStatus = '';

        $status.on('change', function() {
            const isCancel = $(this).val() === 'cancelada';

            textareaConfirmStatus = `
                <div class="form-group">
                    <label for="supplies-update-reason" class="regular-text">
                        Motivo da atualização
                    </label>
                    <textarea name="supplies_update_reason" id="supplies-update-reason"
                        data-cy="supplies-update-reason" rows="3"
                        class="form-control text-area no-resize"></textarea>
                </div>
                <div class="small" style="margin-top:-10px; margin-bottom:20px;">
                    <p class="secondary-text">* Informe o motivo para atualizar os dados desta solicitação.</p>
                </div>
            `;
        });

        $form.on('submit', function(event) {
            event.preventDefault();

            const statusValue = $('#status').find(':selected').text();
            const amountValue = "R$ " + $('#amount').val();
            const responsibleValue = $('#supplies_user_id').find(':selected').text();

            bootbox.confirm({
                title: 'Atenção! Deseja realmente alterar os dados?',
                className: 'regular-text',
                message: "Por favor, confirme os dados que serão enviados: " +
                    "<ul>" +
                    `<li class="regular-text" >Status: ${statusValue}</li>` +
                    `<li class="regular-text">Valor total: ${amountValue}</li>` +
                    (responsibleValue.length ? `<li>Responsável: ${responsibleValue}</li>` :
                        '') +
                    "</ul>" +
                    textareaConfirmStatus,
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
                        const suppliesUpdateReason = $('#supplies-update-reason').val();

                        const textarea = $('<textarea>')
                            .attr('name', 'supplies_update_reason')
                            .css('display', 'none')
                            .val(suppliesUpdateReason);

                        $form.append(textarea);

                        $form.off('submit');
                        $form.trigger('submit');
                    }
                }
            });
        });
    });
</script>
