@php
    use App\Enums\PurchaseRequestStatus;

    $statusCases = collect(PurchaseRequestStatus::cases())->filter(fn($case) => $case !== PurchaseRequestStatus::RASCUNHO);
@endphp

@push('styles')
    <style>
        .request-supplies-filter {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-bottom: 20px;
        }

        @media(min-width: 768px) {
            .request-supplies-filter #supplies-filter-btn {
                align-self: flex-start;
                width: 180px;
            }
        }

        @media(min-width: 1280px) {
            .request-supplies-filter {
                width: fit-content;
                min-width: 30%;
                flex-direction: row-reverse;
            }
        }
    </style>
@endpush

<form method="GET" class="request-supplies-filter">
    <select id="status-filter" name="status[]" class="select2-me" multiple>
        @foreach ($statusCases as $statusCase)
            @php
                $isChecked = collect($status)->contains($statusCase->value);
            @endphp

            <option value="{{ $statusCase->value }}" @selected($isChecked)>{{ $statusCase->label() }}</option>
        @endforeach
    </select>

    <button id="supplies-filter-btn" class="btn btn-primary btn-small" type="submit">Filtrar por status</button>
</form>
