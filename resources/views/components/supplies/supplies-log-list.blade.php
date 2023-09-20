<style>
    tr:nth-child(even) {
        background-color: #e3e3e3;
    }
</style>

@php
    use App\Enums\PurchaseRequestStatus;
    use App\Models\User;
    use Carbon\Carbon;
@endphp

<h4><i class="glyphicon glyphicon-list-alt"></i> <strong> Histórico de alterações desta solicitação:</strong></h4>

@if ($logs->isEmpty())
    <div class="row log-item">
        <div class="col-sm-12">
            <span> Ainda não existe histórico de alterações para essa solicitação. </span>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="box-content nopadding regular-text">

            <table class="table table-hover table-nomargin table-striped" data-column_filter_dateformat="dd-mm-yy"
                data-nosort="0" data-checkall="all" id="#table-striped">
                <thead>
                    <tr>
                        <th>Ação realizada</th>
                        <th>Data</th>
                        <th>Responsável</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        @php
                            $logChanges = collect($log->changes);
                            $changes = '';
                            $reasonForUpdate = null;

                            if ($logChanges->has('status')) {
                                $status = PurchaseRequestStatus::from($logChanges->get('status'));
                                $changes = "Status atualizado para [{$status->label()}]";
                                if ($logChanges->has('supplies_update_reason')) {
                                    $reasonForUpdate = $logChanges?->get('supplies_update_reason');
                                }
                            }

                            if ($logChanges->has('supplies_user_id')) {
                                $suppliesUser = User::find($logChanges->get('supplies_user_id'))->email;
                                $changes = "$suppliesUser [suprimentos] atribuído como responsável";
                            }

                            if ($logChanges->has('amount')) {
                                $amount = $logChanges->get('amount');
                                $changes = "Valor total atualizado para R$ " . number_format($amount, 2, ',', '.');
                            }

                            if ($logChanges->has('price')) {
                                $price = $logChanges->get('price');
                                $changes = "Preço total atualizado para R$ " . number_format($price, 2, ',', '.');
                            }

                        @endphp
                        <tr>
                            <td>{{ $changes }}</td>
                            <td>{{ $log->created_at->formatCustom('d/m/Y H:i:s') }}</td>
                            <td>{{ $log->user->email }}</td>
                            <td>{{ $reasonForUpdate }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(() => {
        $('#table-striped').DataTable({
            searching: false,
            paging: false,
            info: false,
            order: [[1, 'desc']]
        });
    });
</script>
