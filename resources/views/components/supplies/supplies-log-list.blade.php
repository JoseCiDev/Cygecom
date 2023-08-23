@php
    use App\Enums\{LogAction, PurchaseRequestStatus};
    use App\Models\User;
@endphp

<h5><i class="glyphicon glyphicon-list-alt"></i> <strong> Histórico de alterações:</strong></h5>
@foreach ($logs as $index => $log)
    @if ($log->action->value !== LogAction::CREATE->value)
        <div class="row log-item {{ $index % 2 === 0 ? 'zebra-bg-even' : 'zebra-bg-odd' }}">
            <div class="col-sm-4">
                @if ($log->changes)
                    @php
                        $change = null;
                        if (isset($log->changes['status'])) {
                            $status = PurchaseRequestStatus::from($log->changes['status']);
                            $change = "Status para [" . $status->label() . "]";
                        } else {
                            $supplieUserId = $log->changes['supplies_user_id'];
                            $supplieUser = User::find($supplieUserId)->email;
                            $change = "$supplieUser [suprimentos] atribuído como responsável";
                        }
                    @endphp

                    <span> Descrição: {{$change}} </span>
                @else
                    ---
                @endif
            </div>
            <div class="col-sm-3">
                <span>Data: {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y - H:m:s')}}</span>
            </div>
            <div class="col-sm-5">
                <span>Responsável: {{$log->user->email}}</span>
            </div>
        </div>
    @endif
@endforeach