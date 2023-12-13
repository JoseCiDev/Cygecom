@php
    use App\Enums\PurchaseRequestStatus;

    $statusCases = collect(PurchaseRequestStatus::cases())->filter(fn($case) => $case !== PurchaseRequestStatus::RASCUNHO);
@endphp

@push('styles')
    <style>
        .request-supplies-filter {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding-bottom: 20px;
        }

        @media(min-width: 1280px) {
            .request-supplies-filter {
                max-width: 1080px;
            }

            .request-supplies-filter {
                flex-direction: row;
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

    <button class="btn btn-primary btn-small" type="submit">Filtrar</button>
</form>
