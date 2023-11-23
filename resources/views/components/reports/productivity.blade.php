@php
use App\Enums\{PurchaseRequestType, PurchaseRequestStatus, PaymentMethod, PaymentTerm};

$currentProfile = auth()->user()->profile->name;
$isAdmin = $currentProfile === 'admin';
$isDirector = $currentProfile === 'diretor';

$enumRequests = [
    'type' => collect(PurchaseRequestType::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
    'status' => collect(PurchaseRequestStatus::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
    'paymentMethod' => collect(PaymentMethod::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
    'paymentTerms' => collect(PaymentTerm::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
];

$costCenters = $requestingUsers
    ->pluck('purchaseRequest')
    ->collapse()
    ->filter(fn($item) => $item->status->value !== PurchaseRequestStatus::RASCUNHO->value)
    ->pluck('costCenterApportionment')
    ->collapse()
    ->pluck('costCenter')
    ->unique();

$buyingStatus = [
    PurchaseRequestStatus::PENDENTE->label(),
    PurchaseRequestStatus::EM_TRATATIVA->label(),
    PurchaseRequestStatus::EM_COTACAO->label(),
    PurchaseRequestStatus::AGUARDANDO_APROVACAO_DE_COMPRA->label(),
];
@endphp

@push('styles')
    <style>
        .fa-circle-info{
            cursor: help;
        }

        /* Gráficos */
        .charts-container{
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            width: 100%;
        }

        .charts-requests-finished{
            cursor: pointer;
        }

        .charts-requests-sent{
            width: 325px;
            cursor: pointer;
        }

        .border-productivity-report {
            border: 2px solid var(--grey-primary-color);
        }

        .bg-productivity-report {
            background-color: var(--grey-primary-color);
        }

        .text-productivity-report{
            color: var(--grey-primary-color);
        }

        .productivity-report{
            margin-top: 120px;
            display: flex;
            flex-direction: column;
            align-content: center;
            justify-content: center;
            gap: 20px;
            width: 100%;
        }

        .productivity-report-item {
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 100%;
            gap: 15px;
        }

        .productivity-report-title {
            font-size: 16px;
            line-height: 20px;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            margin: 0;
            padding: 10px 0;
            width: 100%;
        }

        .productivity-report-item-info {
            padding: 25px;
            width: 100%;
        }

        .productivity-report-item-info-top {
            display: flex;
            justify-content: space-between;
        }

        .productivity-report-item-info-top-requests {
            display: flex;
            flex-direction: column;
            font-size: 16px;
            line-height: 20px;
            color: var(--grey-primary-color);
            margin: 0;
            max-width: 100px;
            gap: 12px;
        }

        .productivity-report-item-info-requests-qtd {
            font-size: 38px;
            line-height: 46px;
            margin: 0;
        }

        .productivity-report-item-info-top-btns {
            align-self: center;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .productivity-report-item-info-top-btns-btn {
            display: block;
            border-radius: 4px;
            border: 1px solid var(--grey-primary-color);
            font-size: 16px;
            line-height: 24px;
            padding: 10px;
            min-width: 160px;
            text-align: center;
        }

        .productivity-report-item-info-top-btns-btn:visited {
            text-decoration: none;
            color: var(--grey-primary-color);
        }

        .productivity-report-item-info-top-btns-btn:hover {
            text-decoration: none;
            color: var(--black-color);
            border: 1px solid var(--black-color);
            box-shadow: 0 0 5px 0 var(--black-color);
        }

        .productivity-report-item-info-bottom {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 10px;
            margin: 35px 0 0 0;
        }

        .productivity-report-item-info-bottom-row {
            display: flex;
            gap: 12px;
        }

        .productivity-report-item-info-bottom-row-text {
            margin: 0;
            font-size: 16px;
            line-height: 20px;
            color: var(--grey-primary-color);
            display: flex;
            align-items: center;
        }

        .productivity-report-item-info-bottom-row-text-qtd {
            font-size: 22px;
            line-height: 27px;
            color: var(--black-color);
            font-weight: bold;
        }

        /* Chart bar */
        .productivity-report .chart-bar-finished {
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            flex-direction: column;
            width: 100%;
            gap: 15px;
            max-height: 650px;
            overflow: auto;
        }

        .productivity-report-title.bar-title {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .productivity-report .chart-bar-finished .charts-requests-finished{
            position: relative;
            width: 100%;
            height: 100vh;
        }

        /* Filtros */
        .productivity-report-filters{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .productivity-report-filters .selects{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .productivity-report-filters .selects .form-group{
            width: 100%;
            margin: 10px 0;
        }

        .productivity-report-filters .selects .select-filter-container{
            margin-bottom: 10px;
            width: 100%;
        }

        .productivity-report-filters .dates-container{
            width: 100%;
        }

        .productivity-report-filters .dates-container .dates{
            width: 100%;
            display: flex;
            justify-content: space-between;
            gap: 10px;
            position: relative;
            margin: 10px 0 30px;
        }

        .productivity-report-filters .dates-container .dates .date{
            width: 100%;
        }

        .productivity-report-filters .dates-container .dates .date input[type='date']{
            text-align: center;
        }

        .productivity-report-filters .dates-container .dates .span-info{
            position: absolute;
            top: 62px;
            left: 0;
            right: 0;
            text-align: center;
            background-image: linear-gradient(to top, var(--grey-secondary-color), var(--grey-tertiary-color));
            color: var(--black-color);
            border-radius: 0 0 4px 4px;
            cursor: help;
        }

        .productivity-report-filters .checkboxs-container {
            width: 100%;
        }

        .productivity-report-filters .checkboxs-container .checkboxs{
            width: 100%;
            margin: 10px 0;
        }

        .productivity-report-filters .checkboxs-container .checkboxs .inputs-container{
            display: flex;
            justify-content: left;
            gap: 15px;
            padding: 5px 0;
        }

        .productivity-report-filters .checkboxs-container .checkboxs .inputs-container .checkbox-label{
           cursor: pointer;
        }

        .productivity-report-filters .request-status-filter{
            margin: 10px 0;
        }

        .productivity-report-filters .request-status-filter .status{
            display: flex;
            flex-wrap: wrap;
            row-gap: 10px;
            column-gap: 15px;
            align-items: center;
        }

        .productivity-report-filters .request-status-filter .status .checkbox-label{
            cursor: pointer;
        }

        .productivity-report-btns{
            margin: 10px 0;
            display: flex;
            justify-content: left;
            gap: 10px
        }

        @media(min-width: 768px) {
            .productivity-report-filters .selects .form-group{
                display: flex;
                align-items: center;
                gap: 5px;
                justify-content: space-between;
            }

            .productivity-report-filters .selects .form-group .select-filter-btns{
                display: flex;
                gap: 5px;
                padding-top: 10px;
            }

            .productivity-report-filters .checkboxs-container {
                display: flex;
                align-items: center;
                justify-content: left;
                gap: 15px;
            }

            .productivity-report-filters .checkboxs-container .checkboxs{
                max-width: 375px;
            }

            .productivity-report-filters .request-status-filter{
                width: 100%;
            }
        }

        @media(min-width: 1024px) {
            .charts-requests-sent{
                width: 375px;
            }

            .productivity-report-item {
                flex-direction: row;
                position: relative;
                padding-top: 60px;
                padding-bottom: 30px;
            }

            .productivity-report-title.doughnut-title{
                position: absolute;
                top: 0;
            }

            .productivity-report-filters .dates-container{
                display: flex;
                gap: 10px;
            }
        }

        @media(min-width: 1280px) {
            .productivity-report{
                flex-direction: row;
            }

            .productivity-report-filters .dates-container .dates .span-info{
                text-align: left;
                padding: 0 20px;
            }
        }
    </style>
@endpush

<x-app>

    <div class="box box-color box-bordered">
        <div class="row" style="margin: 0 0 30px">
            <div class="col-md-6" style="padding: 0"> <h1 class="page-title">Relatório de produtividade</h1> </div>
        </div>

        <div class="productivity-report-filters">

            <div class="selects">

                <div class="form-group">
                    <div class="select-filter-container" >
                        <label for="requisting-users-filter" class="regular-text cost-center-filter-label">Solicitante</label>
                        <select id="requisting-users-filter" data-cy="requisting-users-filter" name="requisting-users-filter[]"
                            multiple="multiple" class="select2-me" placeholder="Escolha uma ou mais opções">
                            @foreach ($requestingUsers as $user)
                                <option value="{{$user->id}}">{{$user->person->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="select-filter-btns">
                        <button class="btn btn-mini btn-secondary" id="filter-clear-users-btn" data-cy="filter-clear-users-btn">Limpar</button>
                        <button class="btn btn-mini btn-secondary" id="all-requisting-users-btn" data-cy="all-requisting-users-btn">Todos</button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="select-filter-container">
                        <label for="cost-center-filter" class="regular-text cost-center-filter-label">Centros de custos</label>
                        <select id="cost-center-filter" data-cy="cost-center-filter" name="cost-center-filter[]" multiple="multiple"  class="select2-me"
                            placeholder="Escolha uma ou mais opções">
                            @foreach ($costCenters as $costCenter)
                                @php
                                    $companyName = $costCenter->company->name;
                                    $costCenterName = $costCenter->name;
                                    $formattedCnpj = preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $costCenter->company->cnpj);
                                @endphp

                                <option value="{{ $costCenter->id }}">
                                    {{ $formattedCnpj . ' - ' . $companyName . ' - ' . $costCenterName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="select-filter-btns">
                        <button class="btn btn-mini btn-secondary" id="filter-clear-cost-centers-btn" data-cy="filter-clear-cost-centers-btn">Limpar</button>
                        <button class="btn btn-mini btn-secondary" id="all-cost-center-btn" data-cy="all-cost-center-btn">Todos</button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="select-filter-container" >
                        <label for="supplies-users" class="regular-text cost-center-filter-label">Responsável</label>
                        <select id="supplies-users" data-cy="supplies-users" name="supplies-users[]"
                            multiple="multiple" class="select2-me" placeholder="Escolha uma ou mais opções">
                            @foreach ($suppliesUsers as $user)
                                <option value="{{$user->id}}">{{$user->person->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="select-filter-btns">
                        <button class="btn btn-mini btn-secondary" id="filter-clear-supplies-users-btn" data-cy="filter-clear-supplies-users-btn">Limpar</button>
                        <button class="btn btn-mini btn-secondary" id="all-suppliers-users-btn" data-cy="all-suppliers-users-btn">Todos</button>
                    </div>
                </div>

            </div>

            <div class="dates-container">
                <div class="dates">
                    <div class="date">
                        <label for="date-since" class="regular-text">Data início:</label>
                        <input type="date" class="form-control" name="date-since" id="date-since" data-cy="date-since" max="{{ now()->formatCustom('Y-m-d') }}">
                    </div>

                    <div class="date">
                        <label for="date-until" class="regular-text">Data fim: </label>
                        <input type="date" class="form-control" name="date-until" id="date-until" data-cy="date-until" max="{{ now()->formatCustom('Y-m-d') }}">
                    </div>

                    <small class="span-info">
                        <i class="fa-solid fa-circle-info"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-title="Tabela e gráfico circular: solicitações pendentes no período. Gráfico de barras: solicitações finalizadas no período."></i>
                            Período para filtragem das solicitações.
                    </small>
                </div>

                <div class="dates">
                    <div class="date">
                        <label for="desired-date" class="regular-text">Data desejada:</label>
                        <input type="date" class="form-control" name="desired-date" id="desired-date" data-cy="desired-date">
                    </div>
                    <small class="span-info">
                        <i class="fa-solid fa-circle-info"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        data-bs-title="Filtros data início e data fim são ignorados ao filtrar por data desejada."></i>
                        Filtrar por data desejada sobrescreve período.
                    </small>
                </div>
            </div>

            <div class="checkboxs-container">
                <div class="checkboxs form-group">
                    <label for="request-type" class="regular-text">Tipo da solicitação:</label>
                    <div class="inputs-container">
                        @foreach (PurchaseRequestType::cases() as $typeCase)
                            <label class="checkbox-label secondary-text">
                                <input type="checkbox" name="request-type[]" class="request-type-checkbox" data-cy="request-type-{{ $typeCase->value }}"
                                    value="{{ $typeCase->value }}" checked>
                                {{ $typeCase->label() }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="checkboxs form-group">
                    <label for="request-type" class="regular-text">Contratação por:</label>
                    <div class="inputs-container">
                        <label class="checkbox-label secondary-text">
                            <input id="is-supplies-contract-none" type="radio" name="is-supplies-contract" class="is-supplies-contract form-check-input" data-cy="is-supplies-contract-none" checked value="">
                            Ambos
                        </label>
                        <label class="checkbox-label secondary-text">
                            <input type="radio" name="is-supplies-contract" class="is-supplies-contract form-check-input" data-cy="is-supplies-contract-true" value="1">
                            Suprimentos
                        </label>
                        <label class="checkbox-label secondary-text">
                            <input type="radio" name="is-supplies-contract" class="is-supplies-contract form-check-input" data-cy="is-supplies-contract-false" value="0">
                            Área solicitante
                        </label>
                    </div>
                </div>
            </div>

            <div class="request-status-filter form-group">
                <label for="status" class="regular-text">Status da solicitação:</label>
                <div class="status">
                    @foreach (PurchaseRequestStatus::cases() as $statusCase)
                        @php
                            $statusDefaultFilter = $statusCase === PurchaseRequestStatus::PENDENTE;
                        @endphp

                        @if ($statusCase !== PurchaseRequestStatus::RASCUNHO)
                            <label class="checkbox-label secondary-text">
                                <input type="checkbox" name="status[]" data-cy="status-{{ $statusCase->value }}" class="status-checkbox" value="{{ $statusCase->value }}" @checked($statusDefaultFilter)>
                                {{ $statusCase->label() }}
                            </label>
                        @endif

                    @endforeach

                    <button id="all-status-checkbox" type="button" class="btn btn-mini btn-secondary">Marcar todos status</button>
                </div>
            </div>

        </div>

        <div class="productivity-report-btns">
            <button class="btn btn-primary btn-small" id="reports-filter-btn" data-cy="reports-filter-btn">Filtrar</button>
            <button class="btn btn-secondary btn-small" id="filter-clear-all-btn" data-cy="filter-clear-all-btn">Limpar filtros</button>
            <button class="btn btn-primary btn-small" id="generate-csv-button" data-cy="generate-csv-button"><i class="fa-regular fa-file-excel"></i> Baixar</button>
        </div>

        <div class="box-content nopadding regular-text">
            <span class="loader-box"></span>

            <table id="productivityTable" data-cy="productivityTable" class="table table-hover table-nomargin table-bordered" data-nosort="0" data-checkall="all"
                style="margin-bottom: 0; width: 100%">
                <thead>
                    <tr>
                        <th class="noColvis">Nº</th>
                        <th >Tipo</th>
                        <th >Solicitado em</th>
                        <th >Solicitante</th>
                        <th >Solicitante sistema</th>
                        <th >Status</th>
                        <th >Responsável</th>
                        <th >Centro de custo</th>
                        <th >Contratação por</th>
                        <th >Data desejada</th>
                        <th >Categorias</th>
                    </tr>
                </thead>
                <tbody> {{-- Dinâmico --}} </tbody>
            </table>
        </div>

        <div class="productivity-report">
            <div class="productivity-report-item border-productivity-report">
                <h2 class="productivity-report-title doughnut-title bg-productivity-report">
                    <i class="fa-solid fa-circle-info"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    data-bs-title="Representação gráfica dos status a partir da filtragem inserida.
                        *Em processo de compra são status: pendente, em trativa, em cotação e aguardando aprov."></i>
                    Status das solicitações enviadas
                </h2>

                <div class="charts-container">
                    <div class="charts-requests-sent"><canvas id="charts-requests-sent"></canvas></div>
                </div>

                <div class="productivity-report-item-info">
                    <div class="productivity-report-item-info-top">
                        <p class="productivity-report-item-info-top-requests">
                            <span id="chart-status-qtd-total" class="productivity-report-item-info-requests-qtd text-productivity-report">---</span>
                            solicitações no total
                        </p>
                    </div>
                    <div class="productivity-report-item-info-bottom">
                        <div class="productivity-report-item-info-bottom-row">
                            <span id="buying-status-qtd" class="productivity-report-item-info-bottom-row-text-qtd">
                                ---
                            </span>
                            <p class="productivity-report-item-info-bottom-row-text">
                                em processo de compra
                            </p>
                        </div>
                        <div class="productivity-report-item-info-bottom-row">
                            <span id="requests-by-users-qtd" class="productivity-report-item-info-bottom-row-text-qtd">
                                ---
                            </span>
                            <p class="productivity-report-item-info-bottom-row-text">
                                contratações pelo solicitante
                            </p>
                        </div>
                        <div class="productivity-report-item-info-bottom-row">
                            <span id="finished-requests-qtd" class="productivity-report-item-info-bottom-row-text-qtd">
                                ---
                            </span>
                            <p class="productivity-report-item-info-bottom-row-text">
                               finalizadas que foram pendentes no mesmo período
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chart-bar-finished border-productivity-report">
                <h2 class="productivity-report-title bar-title bg-productivity-report">
                    <i class="fa-solid fa-circle-info"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    data-bs-title="Representação quantitativa de finalizações por cada responsável.
                        O período dos dados é o escolhido na filtragem.
                        Caso não for escolhido período será representado os dados de todas solicitações finalizadas.
                        Atenção: O responsável é o último atribuído."></i>
                    Solicitações finalizadas
                </h2>

                <div class="charts-container chart-requests-finished-container" >
                    <div class="charts-requests-finished"><canvas id="charts-requests-finished"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(() => {
                const enumProductValue = @json(PurchaseRequestType::PRODUCT->value);
                const enumServiceValue = @json(PurchaseRequestType::SERVICE->value);
                const enumContractValue = @json(PurchaseRequestType::CONTRACT->value);
                const urlAjax = @json(route('reports.productivity.json'));
                const enumRequests = @json($enumRequests);
                const requestsStatusCounter = @json($requestsStatusCounter);
                const buyingStatus = @json($buyingStatus);
                const $productivityTable = $('#productivityTable');
                const $dateSince = $('#date-since');
                const $dateUntil = $('#date-until');
                const $desiredDate = $('#desired-date');
                const $requistingUsersIdsFilter = $('#requisting-users-filter');
                const $costCenterIdsFilter = $('#cost-center-filter');
                const $checkedRequestTypeInputs = $('.request-type-checkbox:checked');
                const $checkedStatusInputs = $('.status-checkbox');
                const $isSuppliesContractNone = $('#is-supplies-contract-none');
                const $suppliesUsers = $('#supplies-users');

                const $filterClearBtn = $('#filter-clear-all-btn');
                const $filterClearUsersBtn = $('#filter-clear-users-btn');
                const $filterClearCostCentersBtn = $('#filter-clear-cost-centers-btn');
                const $filterClearSuppliesUsersBtn = $('#filter-clear-supplies-users-btn');

                const $allRequistingUsersBtn = $('#all-requisting-users-btn');
                const $allCostCenterBtn = $('#all-cost-center-btn');
                const $allSuppliersUsersBtn = $('#all-suppliers-users-btn');

                const $allStatusCheckbox = $('#all-status-checkbox');

                const $tooltipTriggerList = $('[data-bs-toggle="tooltip"]');
                const tooltipList = $tooltipTriggerList.map((_, tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));

                const handleDateChange = (event, isDesiredDate) => {
                    const currentElementVal = $(event.target).val();
                    if(!currentElementVal) {
                        return;
                    }

                    if(isDesiredDate) {
                        $dateSince.add($dateUntil).val(null);
                        return;
                    }

                    $desiredDate.val(null);
                }

                const getUrlWithParams = (urlAjax) => {
                    const $checkedStatusInputs = $('.status-checkbox:checked');
                    const $checkedRequestTypeInputs = $('.request-type-checkbox:checked');
                    const $requistingUsersIdsFilter = $('#requisting-users-filter').val() || "";
                    const $costCenterIdsFilter = $('#cost-center-filter').val() || "";
                    const $suppliesUsers = $('#supplies-users').val() || "";
                    const $dateSince = $('#date-since').val();
                    const $dateUntil = $('#date-until').val();
                    const $isSuppliesContract = $('.is-supplies-contract:checked').val();
                    const $desiredDate = $('#desired-date').val();

                    const statusValues = $checkedStatusInputs.map((index, element) => element.value).toArray();
                    const requestTypeValues = $checkedRequestTypeInputs.map((index, element) => element.value).toArray();

                    let updatedUrlAjax = `${urlAjax}?status=${statusValues.join(',')}`;
                    updatedUrlAjax += `&request-type=${requestTypeValues.join(',')}`;
                    updatedUrlAjax += `&requesting-users-ids=${$requistingUsersIdsFilter}`;
                    updatedUrlAjax += `&cost-center-ids=${$costCenterIdsFilter}`;
                    updatedUrlAjax += `&date-since=${$dateSince}`;
                    updatedUrlAjax += `&date-until=${$dateUntil}`;
                    updatedUrlAjax += `&desired-date=${$desiredDate}`;
                    updatedUrlAjax += `&supplies-users=${$suppliesUsers}`;

                    if($isSuppliesContract !== undefined && $isSuppliesContract !== "") {
                        updatedUrlAjax += `&is-supplies-contract=${$isSuppliesContract}`;
                    }

                    return updatedUrlAjax;
                }

                const filterDataTable = () => {
                    const updatedUrlAjax = getUrlWithParams(urlAjax);
                    $productivityTable.DataTable().ajax.url(updatedUrlAjax).load();
                }

                const clearFilters = (filter = false) => {
                    const clearOptions = {
                        requistingUsersIdsFilter: () => $requistingUsersIdsFilter.val(null).trigger('change'),
                        costCenterIdsFilter: () => $costCenterIdsFilter.val(null).trigger('change'),
                        suppliesUsersFilter: () => $suppliesUsers.val(null).trigger('change'),
                        checkedRequestTypeInputs: () => $checkedRequestTypeInputs.prop('checked', true),
                        checkedStatusInputs: () => {
                            $checkedStatusInputs.each((_, element) => {
                                const value = $(element).val();
                                const isChecked = value === 'pendente';
                                $(element).prop('checked', isChecked);
                            });
                        },
                        dates: () => $dateSince.add($dateUntil).add($desiredDate).val(null),
                        contractingBy: () => $isSuppliesContractNone.trigger('click')
                    }

                    if(filter) {
                        clearOptions[filter]();
                        return;
                    }

                    Object.values(clearOptions).forEach(el => el())
                }

                const createOrUpdateChartDoughnut = (chartDataResponse) => {
                    const chartStatusQtdTotal = Object.values(chartDataResponse.status).reduce((sum, status) => sum + status.count, 0);
                    const requestsBuyingStatusQtd = Object.values(chartDataResponse.status).reduce((sum, status) => {
                        const isBuyingStatus = buyingStatus.find(el => el === status.label)
                        return sum + (isBuyingStatus ? status.count : 0)
                    }, 0);

                    $("#chart-status-qtd-total").text(chartStatusQtdTotal)
                    $("#buying-status-qtd").text(requestsBuyingStatusQtd)
                    $("#finished-requests-qtd").text(chartDataResponse.status?.finalizada?.count)

                    const chartStatusResponse = Object.values(chartDataResponse.status)
                    const chartStatusTitle = `Status das solicitações enviadas`;
                    const chartStatusSubtitle = 'Clique nos status que deseja ver/esconder.';
                    const chartLabels = [];
                    const chartData = [];

                    $.each(chartStatusResponse, ((_, element) => {
                        chartLabels.push(element.label)
                        chartData.push(element.count)
                    }))
                    createChartDoughnut("charts-requests-sent", chartLabels, chartData, false, 'Clique no status para mostrar/ocultar')
                }

                const createOrUpdateChartBar = (chartDataResponse) => {
                    const users = Object.values(chartDataResponse.suppliesUserRequests);
                    const chartStatusTitle = 'Solicitações finalizadas por responsável';
                    const chartLabels = [];
                    const chartData = [];

                    users.forEach((user) => {
                        const splitedName = user.name.split(' ');
                        const firstName = splitedName[0].charAt(0).toUpperCase() + splitedName[0].slice(1).toLowerCase();

                        const lastName = splitedName.length > 1 ? splitedName.slice(-1)[0] : null;
                        const lastNameLetter = lastName?.slice(0, 1).toUpperCase();

                        const formattedName = `${firstName} ${lastNameLetter ? lastNameLetter + '.': ''}`;

                        chartLabels.push(formattedName)
                        chartData.push(user.requestsQtdFinish)
                    })

                    createChartBar('charts-requests-finished', chartLabels, chartData, chartStatusTitle);
                }

                const $badgeColumnsQtd = $(`<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"></span>`);
                $productivityTable.DataTable({
                    dom: 'Blfrtip',
                    initComplete: function() {
                        $.fn.setStorageDtColumnConfig();
                        $('#reports-filter-btn').on('click', filterDataTable);
                    },
                    scrollY: '400px',
                    scrollX: true,
                    paging: true,
                    processing: true,
                    serverSide: true,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
                    searching: false,
                    searchDelay: 1000,
                    language: {
                        lengthMenu: "Mostrar _MENU_ registros por página",
                        zeroRecords: "Nenhum registro encontrado",
                        info: "Mostrando página _PAGE_ de _PAGES_",
                        infoEmpty: "Nenhum registro disponível",
                        infoFiltered: "(filtrado de _MAX_ registros no total)",
                        search: "Buscar:",
                        paginate: { first: "Primeiro", last: "Último", next: "Próximo", previous: "Anterior" },
                        processing:  $('.loader-box').show(),
                    },
                    ajax: {
                        url: urlAjax,
                        type: 'GET',
                        dataType: 'json',
                        error: (response, textStatus, errorThrown) => {
                            const title = "Houve uma falha na busca dos registros!";
                            const message = "Desculpe, mas ocorreu algum erro na busca dos registros. Por favor, tente novamente mais tarde. Contate o suporte caso o problema persista.";
                            $.fn.showModalAlert(title, message);
                        },
                        beforeSend: () => $('#productivityTable tbody').css('opacity', '0.2'),
                        complete: (data) => {
                            const response = data.responseJSON;
                            const chartDataResponse = response.chartData;

                            createOrUpdateChartDoughnut(chartDataResponse);
                            createOrUpdateChartBar(chartDataResponse);

                            $('#requests-by-users-qtd').text(response.requestsByUsersQtd);

                            $('#productivityTable tbody').css('opacity', '1')
                        }
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'type', render: (type) => enumRequests['type'][type] },
                        {
                            data: 'logs',
                            render: (logs, _, row) => {
                                const firstPendingStatus = logs
                                    .filter((item) => item.changes?.status === 'pendente')
                                    .find((item) => item.created_at)
                                    ?.created_at
                                return firstPendingStatus ? moment(firstPendingStatus).format('DD/MM/YYYY HH:mm:ss') : '---';
                            }
                        },
                        { data: 'user.person.name' },
                        {
                            data: 'requester',
                            render: (requester, _, row) => requester ? requester.name : '---'
                        },
                        { data: 'status', render: (status) => enumRequests['status'][status] },
                        { data: 'supplies_user.person.name', render: (suppliesUserName) => (suppliesUserName ?? '---') },
                        {
                            data: 'cost_center_apportionment',
                            orderable: false,
                            render: (costCenter) => {
                                const $div = $(document.createElement('div')).addClass('tag-category');

                                const costCenters = costCenter.map((element) => element.cost_center.name);
                                if(costCenter.length <= 0) {
                                    return $div.append(`<span class="tag-category-item">---</span>`)[0].outerHTML;
                                }

                                $div.append(costCenters.map((costCenter) => `<span class="tag-category-item">${costCenter}</span>`).join(''));
                                return $div[0].outerHTML;
                            }
                        },
                        {
                            data: 'is_supplies_contract',
                            render: (is_supplies_contract, _, row) => is_supplies_contract ? "Suprimentos" : "Área solicitante"
                        },
                        {
                            data: 'desired_date',
                            render: (desired_date, _, row) => desired_date ? moment(desired_date).format('DD/MM/YYYY') : "---"
                        },
                        {
                            data: 'purchase_request_product',
                            orderable: false,
                            render: (purchase_request_product, _, row) => {
                                if(!purchase_request_product.length) {
                                    return "---";
                                }

                                const $categoryDiv = $(`<div class="tag-list"></div`)
                                const $tagListItem = $(`<span class="tag-list-item"></span>`)
                                const categories = $(purchase_request_product)?.each((_, element) => {
                                    const $newCategoryItem = $tagListItem.clone().text(element.category.name)
                                    $categoryDiv.append($newCategoryItem)
                                })

                                return $categoryDiv[0].outerHTML;
                            }
                        },
                    ],
                    buttons: [
                        {
                            extend: 'colvis',
                            columns: ':not(.noColvis)',
                            text: `Mostrar / Ocultar colunas ${$badgeColumnsQtd[0].outerHTML}`,
                            columnText: (dt, idx, title ) => title,
                        }
                    ],
                })

                $filterClearBtn.on('click', () => clearFilters());
                $filterClearUsersBtn.on('click', () => clearFilters('requistingUsersIdsFilter'));
                $filterClearCostCentersBtn.on('click', () => clearFilters('costCenterIdsFilter'));
                $filterClearSuppliesUsersBtn.on('click', () => clearFilters('suppliesUsersFilter'));

                $allRequistingUsersBtn.on('click', () => {
                    const allValues = $requistingUsersIdsFilter.find('option').map((_, option) => $(option).val())
                    $requistingUsersIdsFilter.val(allValues).trigger('change');
                });

                $allCostCenterBtn.on('click', () => {
                    const allValues = $costCenterIdsFilter.find('option').map((_, option) => $(option).val())
                    $costCenterIdsFilter.val(allValues).trigger('change');
                })

                $allSuppliersUsersBtn.on('click', () => {
                    const allValues = $suppliesUsers.find('option').map((_, option) => $(option).val())
                    $suppliesUsers.val(allValues).trigger('change');
                })

                $allStatusCheckbox.on('click', (event) => $checkedStatusInputs.each((_, el) =>  $(el).prop('checked', true)))

                $desiredDate.on('change', (event) => handleDateChange(event, true));
                $dateSince.add($dateUntil).on('change', (event) => handleDateChange(event, false));
            });
        </script>
    @endpush

</x-app>
