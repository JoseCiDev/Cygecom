@php
    use App\Enums\PurchaseRequestStatus;
@endphp

<h4 style="margin-bottom: 15px"><i class="glyphicon glyphicon-edit"></i> <strong>Editar solicitação</strong></h4>
<form class="form-validate" data-cy="form-request-status" method="POST"
    action="{{ route($route, ['id' => $requestId]) }}">
    @csrf
    <div class="form-group">
        <div class="row">

            <div class="col-md-2">
                <label class="control-label" for="amount">Editar valor total desta solicitação</label>
                <input type="text" placeholder="0,00" class="form-control format-amount"
                    id="format-amount" data-cy="format-amount"
                    value="{{ $amount }}">
                <input type="hidden" name="{{$inputName}}" id="amount" data-cy="amount"
                    class="amount no-validation" value="{{ $amount }}">
            </div>

            <div class="col-md-2">
                <label for="status">Status da solicitação</label>
                <select name="status" data-cy="status" @disabled($requestIsFromLogged) class='chosen-select form-control'>
                    @foreach ($allRequestStatus as $status)
                        @if ($status->value !== PurchaseRequestStatus::RASCUNHO->value)
                            ;
                            <option @selected($requestStatus === $status) value="{{ $status }}">
                                {{ $status->label() }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

        </div>
    </div>

    <button ata-cy="btn-apply-new_amount" type="submit" class="btn btn-icon btn-primary"
        @disabled($requestIsFromLogged) >
        Atualizar solicitação
    </button>
</form>
