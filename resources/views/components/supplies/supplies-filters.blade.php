@php
    use App\Enums\{PurchaseRequestStatus, CompanyGroup};

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

        .request-supplies-filter .last-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .request-supplies-filter .last-container .company-filter {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        @media(min-width: 1280px) {
            .request-supplies-filter {
                max-width: 1080px;
            }

            .request-supplies-filter {
                flex-direction: row;
            }
        }

        @media(min-width: 1440px) {
            .request-supplies-filter .last-container {
                flex: 1 0 37%;
                gap: 20px;
            }

            .request-supplies-filter .last-container .company-filter {
                flex-direction: column;
                align-items: flex-start;
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

    <div class="last-container">
        <div class="company-filter">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="companies-group[]" value="{{ CompanyGroup::INP }}" id="companies-group-inp" @checked($companiesGroup->contains(CompanyGroup::INP->value))>
                <label class="form-check-label" for="companies-group-inp">
                    Empresas do grupo INP
                    <i class="fa-solid fa-circle-info" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Será filtrado solicitações que possuem centros de custos vinculados a empresas do tipo INP, Noorskin, Oasis..."></i>
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="companies-group[]" value="{{ CompanyGroup::HKM }}" id="companies-group-hkm" @checked($companiesGroup->contains(CompanyGroup::HKM->value))>
                <label class="form-check-label" for="companies-group-hkm">
                    Empresas do grupo HKM <i class="fa-solid fa-circle-info" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Será filtrado solicitações que possuem centros de custos vinculados a empresas do tipo farmácias e demais empresas..."></i>
                </label>
            </div>
        </div>

        <button class="btn btn-primary btn-small" type="submit">Filtrar</button>
    </div>

</form>

@push('scripts')
    <script type="module">
        $(() => {
            $('[data-bs-toggle="tooltip"]').each((_, tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl))
        });
    </script>
@endpush
