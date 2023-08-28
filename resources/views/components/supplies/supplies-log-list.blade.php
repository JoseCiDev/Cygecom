@php
    use App\Enums\PurchaseRequestStatus;
    use App\Models\User;
    use Carbon\Carbon;
@endphp

<h5><i class="glyphicon glyphicon-list-alt"></i> <strong> Histórico de alterações:</strong></h5>

@if ($logs->isEmpty())
    <div class="row log-item">
        <div class="col-sm-12">
            <span> Ainda não existe histórico de alterações para essa solicitação. </span>
        </div>
    </div>
@endif

@foreach ($logs as $index => $log)
    @php
        $logChanges = collect($log->changes);
        $changes = '';

        if ($logChanges->has('status')) {
            $status = PurchaseRequestStatus::from($logChanges->get('status'));
            $changes .= "<li>Status atualizado para [{$status->label()}];</li>";
        }

        if ($logChanges->has('supplies_user_id')) {
            $suppliesUser = User::find($logChanges->get('supplies_user_id'))->email;
            $changes .= "<li>$suppliesUser [suprimentos] atribuído como responsável;</li>";
        }

        if ($logChanges->has('amount')) {
            $amount = $logChanges->get('amount');
            $changes .= "<li>Valor total atualizado para R$ " . number_format($amount, 2, ',', '.') .";</li>";
        }

        if ($logChanges->has('price')) {
            $price = $logChanges->get('price');
            $changes .= "<li>Preço total atualizado para R$ " . number_format($price, 2, ',', '.') . ";</li>";
        }
    @endphp

    <div class="log-item">
        <ul class="log-item-changes">
            {!! $changes !!}
        </ul>
        <p class="log-item-date">Data: {{ Carbon::parse($log->created_at)->format('d/m/Y - H:i:s') }}</p>
        <p class="log-item-responsable">Responsável: {{ $log->user->email }}</p>
    </div>
@endforeach
