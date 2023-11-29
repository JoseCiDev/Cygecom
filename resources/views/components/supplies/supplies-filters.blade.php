@php
    use App\Enums\PurchaseRequestStatus;
@endphp

<div class="row">
    <div class="col-md-12">
        <form action="{{ $route }}" method="GET" class="form-status-filter">
            <button class="btn btn-primary btn-small" id="status-filter-btn" type="submit">Filtrar status</button>

            @foreach (PurchaseRequestStatus::cases() as $statusCase)
                @php
                    $statusDefaultFilter = $statusCase !== PurchaseRequestStatus::FINALIZADA && $statusCase !== PurchaseRequestStatus::CANCELADA;
                    $isChecked = count($status) ? collect($status)->contains($statusCase) : $statusDefaultFilter;
                @endphp

                @if ($statusCase !== PurchaseRequestStatus::RASCUNHO)
                    <label class="checkbox-label secondary-text">
                        <input type="checkbox" name="status[]" class="status-checkbox" value="{{ $statusCase->value }}" @checked($isChecked)>
                        {{ $statusCase->label() }}
                    </label>
                @endif
            @endforeach
        </form>
    </div>
</div>
