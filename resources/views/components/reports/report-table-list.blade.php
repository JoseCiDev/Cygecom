@php
    use App\Enums\{PurchaseRequestType, PurchaseRequestStatus, PaymentMethod, PaymentTerm};

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

@endphp

<div class="box-content nopadding regular-text">

    <div class="row">

        <div class="col-sm-4">
            <label for="requisting-users-filter" class="regular-text">Solicitante</label>
            <div class="form-group">
                <select name="requisting-users-filter[]" id="requisting-users-filter" multiple="multiple" class="chosen-select form-control">

                    @foreach ($requestingUsers as $user)
                        <option value="{{$user->id}}">{{$user->person->name}}</option>
                    @endforeach

                </select>
            </div>
        </div>

        <div class="col-sm-5">
            <label for="cost-center-filter" class="regular-text">Centros de custos</label>
            <div class="form-group">
                <select name="cost-center-filter[]" id="cost-center-filter" multiple="multiple" class="chosen-select form-control">
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
        </div>

    </div>

    <div class="row">

        <div class="col-sm-2">
            <div class="form-group">
                <label for="date-since" class="regular-text">A partir de:</label>
                <input type="date" class="form-control" name="date-since" id="date-since" data-cy="date-since" max="{{ now()->formatCustom('Y-m-d') }}">
            </div>
        </div>

        <div class="col-sm-2">
            <div class="form-group">
                <label for="date-until" class="regular-text">Até:</label>
                <input type="date" class="form-control" name="date-until" id="date-until" data-cy="date-until" max="{{ now()->formatCustom('Y-m-d') }}">
            </div>
        </div>

        <div class="col-sm-3">
            <label for="request-type" class="regular-text">Tipo da solicitação:</label>
            <div class="row-filter-reports">
                @foreach (PurchaseRequestType::cases() as $typeCase)
                    <label class="checkbox-label secondary-text">
                        <input type="checkbox" name="request-type[]" class="request-type-checkbox" value="{{ $typeCase->value }}" checked>
                        {{ $typeCase->label() }}
                    </label>
                @endforeach
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-12">
            <label for="status" class="regular-text">Status da solicitação:</label>
            <div class="row-filter-reports">
                @foreach (PurchaseRequestStatus::cases() as $statusCase)
                    @php
                        $statusDefaultFilter = $statusCase !== PurchaseRequestStatus::FINALIZADA && $statusCase !== PurchaseRequestStatus::CANCELADA;
                        $isChecked = $statusDefaultFilter;
                    @endphp

                    @if ($statusCase !== PurchaseRequestStatus::RASCUNHO)
                        <label class="checkbox-label secondary-text">
                            <input type="checkbox" name="status[]" class="status-checkbox" value="{{ $statusCase->value }}" @checked($isChecked)>
                            {{ $statusCase->label() }}
                        </label>
                    @endif

                @endforeach
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary btn-small" id="reports-filter-btn">Filtrar</button>
            <button class="btn btn-primary btn-small" id="generate-csv-button">Baixar relatório</button>
        </div>
    </div>

    <table id="reportsTable" class="table table-hover table-nomargin table-bordered" data-nosort="0" data-checkall="all">
        <thead>
            <tr>
                <th >Nº</th>
                <th >Tipo</th>
                <th >Capturado em</th>
                <th >Solicitante</th>
                <th >Status</th>
                <th >Responsável</th>
                <th >Centro de custo</th>
                <th >Fornecedor</th>
                <th >Forma Pgto.</th>
                <th >Condição Pgto.</th>
                <th >Valor total</th>
            </tr>
        </thead>
        <tbody> {{-- Dinâmico --}} </tbody>
    </table>
</div>

<script>
    $(() => {
        const urlAjax = @json(route('reports.index.json'));
        const enumRequests = @json($enumRequests);
        const $generateCSVButton = $('#generate-csv-button');
        const $reportsTable = $('#reportsTable');

        const getUrlWithParams = (urlAjax) => {
            const $checkedStatusInputs = $('.status-checkbox:checked');
            const $checkedRequestTypeInputs = $('.request-type-checkbox:checked');
            const $requistingUsersIdsFilter = $('#requisting-users-filter').val() || "";
            const $costCenterIdsFilter = $('#cost-center-filter').val() || "";
            const $dateSince = $('#date-since').val();
            const $dateUntil = $('#date-until').val();

            const statusValues = $checkedStatusInputs.map((index, element) => element.value).toArray();
            const requestTypeValues = $checkedRequestTypeInputs.map((index, element) => element.value).toArray();

            let updatedUrlAjax = `${urlAjax}?status=${statusValues.join(',')}`;
            updatedUrlAjax += `&request-type=${requestTypeValues.join(',')}`;
            updatedUrlAjax += `&requesting-users-ids=${$requistingUsersIdsFilter}`;
            updatedUrlAjax += `&cost-center-ids=${$costCenterIdsFilter}`;
            updatedUrlAjax += `&date-since=${$dateSince}`;
            updatedUrlAjax += `&date-until=${$dateUntil}`;

            return updatedUrlAjax;
        }

        const downloadCsv = (csv) => {
            const now = moment(new Date()).format('YYYY-MM-DD-HH-mm-ss-SSS');
            const fileName = `relatorio-gecom-${now}.csv`;
            const blob = new Blob([csv], { type: "text/csv" });
            const link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = fileName;
            link.click();
        }

        $reportsTable.DataTable({
            initComplete: function() {
                $('#reports-filter-btn').click(() => {
                    const updatedUrlAjax = getUrlWithParams(urlAjax);
                    $reportsTable.DataTable().ajax.url(updatedUrlAjax).load();
                });

                $generateCSVButton.on('click', () => {
                    let updatedUrlAjax = getUrlWithParams(urlAjax);
                    updatedUrlAjax += `&length=-1`;

                    $.ajax({
                        url: updatedUrlAjax,
                        type: 'GET',
                        success: (data) => {
                            const content = data.data;
                            const headers = $('#reportsTable thead tr th').toArray().map(header => header.textContent);
                            const rows = content.map(item => {
                                const id = item.id
                                const type = enumRequests['type'][item.type]
                                const responsibilityMarkedAt = item.responsibility_marked_at ? moment(item.responsibility_marked_at).format('DD/MM/YYYY HH:mm:ss') : '---'
                                const requistingUser = item.user.person.name
                                const status = enumRequests['status'][item.status]
                                const suppliesUserName = item.supplies_user.person.name
                                const costCenters = item.cost_center_apportionment.map((element) => element.cost_center.name).join(', ');

                                const supplierColumnMapping = {
                                    'product': () => item.purchase_request_product?.map((element) => element.supplier?.corporate_name),
                                    'service': () => [item.service?.supplier?.corporate_name],
                                    'contract': () => [item.contract?.supplier?.corporate_name],
                                };
                                const suppliers = supplierColumnMapping[item.type]().filter((el) => el).join(', ') || '---';

                                const paymentInfo = item[item.type]?.payment_info || {};

                                const paymentMethod = paymentInfo.payment_method ;
                                const paymentMethodLabel = enumRequests['paymentMethod'][paymentMethod] || '---'

                                const paymentTerms = paymentInfo?.payment_terms || '---';
                                const paymentTermsLabel = enumRequests['paymentTerms'][paymentTerms] || '---'

                                const amount = item[item.type]?.amount || item[item.type]?.price;
                                const formatter = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL'});
                                const formattedAmount = amount ? formatter.format(amount) : '---';

                                return [
                                    id,
                                    type,
                                    responsibilityMarkedAt,
                                    requistingUser,
                                    status,
                                    suppliesUserName,
                                    costCenters,
                                    suppliers,
                                    paymentMethodLabel,
                                    paymentTermsLabel,
                                    formattedAmount
                                ]
                            });

                            const csv = [headers];
                            rows.forEach((row) => {
                                const csvRow = row.map((cell) => `"${cell}"`);
                                csv.push('\n' + csvRow);
                            });

                            downloadCsv(csv);
                        },
                        error: (response, textStatus, errorThrown) => {
                            // Manipular erros aqui
                            const errorBox = `<div style="height: 300px; overflow: scroll">${response.responseJSON.error}</div>`;
                            bootbox.alert({
                                title: "Houve uma falha na busca dos registros!",
                                message: "Desculpe, mas ocorreu algum erro na busca dos registros. Por favor, tente novamente mais tarde. Contate o suporte caso o problema persista."
                                + "<br><br>"
                                + errorBox,
                                className: 'bootbox-custom-warning'
                            });
                        },
                    });
                })
            },
            scrollY: '400px',
            scrollX: true,
            serverSide: true,
            paging: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
            searching: true,
            searchDelay: 1000,
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "Nenhum registro encontrado",
                info: "Mostrando página _PAGE_ de _PAGES_",
                infoEmpty: "Nenhum registro disponível",
                infoFiltered: "(filtrado de _MAX_ registros no total)",
                search: "Buscar:",
                paginate: { first: "Primeiro", last: "Último", next: "Próximo", previous: "Anterior" }
            },
            ajax: {
                url: urlAjax,
                type: 'GET',
                error: (response, textStatus, errorThrown) => {
                    const errorBox = `<div style="height: 300px; overflow: scroll">${response.responseJSON.error}</div>`
                    bootbox.alert({
                        title: "Houve uma falha na busca dos registros!",
                        message: "Desculpe, mas ocorreu algum erro na busca dos registros. Por favor, tente novamente mais tarde. Contate o suporte caso o problema persista."
                        + "<br><br>"
                        + errorBox,
                        className: 'bootbox-custom-warning'
                    });
                },
            },
            columns: [
                { data: 'id'},
                { data: 'type', render: (type) => enumRequests['type'][type] },
                {
                    data: 'responsibility_marked_at',
                    render: (responsibility_marked_at) => responsibility_marked_at ? moment(responsibility_marked_at).format('DD/MM/YYYY HH:mm:ss') : '---'
                },
                { data: 'user.person.name' },
                { data: 'status', render: (status) => enumRequests['status'][status] },
                { data: 'supplies_user.person.name', render: (suppliesUserName) => (suppliesUserName ?? '---') },
                {
                    data: 'cost_center_apportionment',
                    orderable: false,
                    render: (costCenter) => {
                        const costCenters = costCenter.map((element) => element.cost_center.name);

                        const $td = $(document.createElement('td'));
                        const $div = $(document.createElement('div')).addClass('tag-category');

                        if(costCenter.length <= 0) {
                            const $span = $(document.createElement('span')).addClass('tag-category-item');
                            $span.text('---');
                            $div.append($span);
                            $td.append($div);
                            return $td.html();
                        }

                        costCenter.forEach((element) => {
                            const $span = $(document.createElement('span')).addClass('tag-category-item');
                            $span.text(element.cost_center.name);
                            $div.append($span);
                        });


                        $td.append($div);
                        return $td.html();
                    }
                },
                {
                    data: 'type',
                    orderable: false,
                    render: (type, _, row) => {
                        const $td = $(document.createElement('td'));
                        const $div = $(document.createElement('div')).addClass('tag-category');
                        const supplierColumnMapping = {
                            'product': () => row.purchase_request_product?.map((element) => element.supplier?.corporate_name),
                            'service': () => [row.service?.supplier?.corporate_name],
                            'contract': () => [row.contract?.supplier?.corporate_name],
                        };

                        const suppliers = supplierColumnMapping[type]().filter((el) => el);

                        if(!suppliers || !suppliers[0] || suppliers.length <= 0) {
                            return '---';
                        }

                        suppliers.forEach((element) => {
                            const $span = $(document.createElement('span')).addClass('tag-category-item');
                            $span.text(element);
                            $div.append($span);
                        });

                        $td.append($div);
                        return $td.html();
                    }
                },
                {
                    data: 'type',
                    orderable: false,
                    render: (type, _, row) => {
                        const paymentInfo = row[type]?.payment_info || {};
                        const paymentMethod = paymentInfo.payment_method ;
                        const paymentMethodLabel = enumRequests['paymentMethod'][paymentMethod] || '---'
                        return paymentMethodLabel;
                    }
                },
                {
                    data: 'type',
                    orderable: false,
                    render: (type, _, row) => {
                        const paymentInfo = row[type]?.payment_info || {};
                        const paymentTerms = paymentInfo?.payment_terms || '---';
                        const paymentTermsLabel = enumRequests['paymentTerms'][paymentTerms] || '---'
                        return paymentTermsLabel;
                    }
                },
                {
                    data: 'type',
                    render: (type, _, row) => {
                        const amount = row[type]?.amount || row[type]?.price;

                        if(!amount && !Number(amount)) {
                            return "R$ ---"
                        }

                        const formatter = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL'});
                        const formattedAmount = formatter.format(amount);
                        return formattedAmount;
                    }
                },
            ],
        })
    });
</script>

