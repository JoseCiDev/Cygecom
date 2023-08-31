@php
    use App\Enums\PurchaseRequestStatus;
@endphp

<h4 style="margin-bottom: 15px"><i class="glyphicon glyphicon-edit"></i> <strong>Editar solicitação</strong></h4>
<form class="form-validate" data-cy="form-request-edit" id="form-request-edit" method="POST" action="{{ route($route, ['id' => $requestId]) }}">
    @csrf
    <div class="form-group">
        <div class="row">

            <div class="col-md-2">
                <label class="control-label" for="amount">Editar valor total desta solicitação</label>
                <input type="text" placeholder="0,00" class="form-control format-amount"
                    id="format-amount" data-cy="format-amount" value="{{ $amount }}">
                <input type="hidden" name="{{$inputName}}" id="amount" data-cy="amount"
                    class="amount no-validation" value="{{ $amount }}">
            </div>

            <div class="col-md-2">
                <label for="status">Status da solicitação</label>
                <select name="status" data-cy="status" id="status" @disabled($requestIsFromLogged) class='chosen-select form-control'>
                    @foreach ($allRequestStatus as $status)
                        @if ($status->value !== PurchaseRequestStatus::RASCUNHO->value)
                            <option @selected($requestStatus === $status) value="{{ $status }}">
                                {{ $status->label() }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="supplies_user_id">Atribuir responsável pela solicitação</label>
                <select name="supplies_user_id" data-cy="supplies_user_id" id="supplies_user_id" class='select2-me' style="width: 100%"
                    placeholder="Escolher novo responsável" @disabled($requestIsFromLogged)>
                    @foreach ($allowedResponsables as $user)
                        <option disabled selected></option>
                        <option value="{{$user['id']}}">
                            {{ $user['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>

    <button data-cy="btn-edit-request" id="btn-edit-request" type="submit" class="btn btn-icon btn-primary"
        @disabled($requestIsFromLogged) >
        Atualizar solicitação
    </button>
</form>

<script>
    $(() => {
        $form = $("#form-request-edit");

        $form.on('submit', function (event) {
            event.preventDefault()

            const statusValue = $('#status').find(':selected').text();
            const amountValue = "R$ " + $('#amount').val();
            const responsibleValue = $('#supplies_user_id').find(':selected').text();

            bootbox.confirm({
                title: 'Atenção! Deseja realmente alterar os dados?',
                message: "Os valores da solicitação serão: " +
                "<ul>" +
                    `<li>Status: ${statusValue}</li>` +
                    `<li>Valor total: ${amountValue}</li>` +
                    (responsibleValue.length ? `<li>Responsável: ${responsibleValue}</li>` : '') +
                "</ul>",
                buttons: {
                    confirm: {
                        label: 'Sim, atualizar solicitação',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Cancelar',
                    }
                },
                callback: function(result) {
                    if(result) {
                        $form.off('submit');
                        $form.submit();
                    }
                }
            });
        });
    });
</script>
