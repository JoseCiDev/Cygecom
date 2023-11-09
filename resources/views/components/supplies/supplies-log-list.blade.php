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
                data-nosort="0" data-checkall="all" id="#table-striped" style="width:100%">
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
                                $changes .= "Status atualizado para [{$status->label()}]; ";
                                if ($logChanges->has('supplies_update_reason')) {
                                    $reasonForUpdate = $logChanges?->get('supplies_update_reason');
                                }
                            }

                            if ($logChanges->has('supplies_user_id')) {
                                $userId = $logChanges->get('supplies_user_id');
                                $userEmail = User::find($userId)->email;
                                $changes .= "$userEmail [suprimentos] atribuído como responsável; ";
                            }

                            if ($logChanges->has('amount')) {
                                $amount = $logChanges->get('amount');
                                $changes .= "Valor total atualizado para R$ " . number_format($amount, 2, ',', '.') . "; ";
                            }

                            if ($logChanges->has('price')) {
                                $price = $logChanges->get('price');
                                $changes .= "Preço total atualizado para R$ " . number_format($price, 2, ',', '.') . "; ";
                            }

                            if($logChanges->has('purchase_order')) {
                                $changes .= "Ordem de compra atribuida: " . $logChanges->get('purchase_order') . "; ";
                            }

                            $createdAt = $log->created_at->formatCustom('d/m/Y H:i:s');
                            $email = $log->user->email;
                        @endphp
                        <tr>
                            <td>{{ $changes }}</td>
                            <td>{{ $createdAt }}</td>
                            <td>{{ $email }}</td>
                            <td>{{ $reasonForUpdate }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        $(() => {
            $('#table-striped').DataTable({
                searching: false,
                paging: false,
                info: false,
                order: [[1, 'desc']]
            });
        });
    </script>
@endpush
