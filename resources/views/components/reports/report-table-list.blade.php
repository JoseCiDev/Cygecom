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

<div class="report-filters">

    <div class="selects">
        <div class="form-group">
            <div class="label-with-clear-btn">
                <label for="requisting-users-filter" class="regular-text" style="margin: 0">Solicitante</label>
                <button class="btn btn-mini btn-secondary" id="filter-clear-users-btn">Limpar</button>
            </div>

            <select id="requisting-users-filter" data-cy="requisting-users-filter" name="requisting-users-filter[]"
                multiple="multiple" class="select2-me" placeholder="Escolha uma ou mais opções" style="width:100%;">
                @foreach ($requestingUsers as $user)
                    <option value="{{$user->id}}">{{$user->person->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <div class="label-with-clear-btn">
                <label for="cost-center-filter" class="regular-text" style="margin: 0">Centros de custos</label>
                <button class="btn btn-mini btn-secondary" id="filter-clear-cost-centers-btn">Limpar</button>
            </div>
            <select id="cost-center-filter" name="cost-center-filter[]" multiple="multiple"  class="select2-me"
                placeholder="Escolha uma ou mais opções" style="width:100%;">
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

    <div class="dates-with-checkboxs">
        <div class="dates">
            <div class="date">
                <label for="date-since" class="regular-text">A partir de:</label>
                <input type="date" class="form-control" name="date-since" id="date-since" data-cy="date-since" max="{{ now()->formatCustom('Y-m-d') }}">
            </div>

            <div class="date">
                <label for="date-until" class="regular-text">Até: </label>
                <input type="date" class="form-control" name="date-until" id="date-until" data-cy="date-until" max="{{ now()->formatCustom('Y-m-d') }}">
            </div>
        </div>

        <div class="checkboxs">
            <div class="form-group">
                <label for="status" class="regular-text">Status da solicitação:</label>
                <div class="status">
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

            <div class="form-group">
                <label for="request-type" class="regular-text">Tipo da solicitação:</label>
                <div class="types">
                    @foreach (PurchaseRequestType::cases() as $typeCase)
                        <label class="checkbox-label secondary-text">
                            <input type="checkbox" name="request-type[]" class="request-type-checkbox" value="{{ $typeCase->value }}" checked>
                            {{ $typeCase->label() }}

                            @if ($typeCase->value === PurchaseRequestType::PRODUCT->value)
                                ( <label class="checkbox-label secondary-text" style="margin: 0">
                                    <input type="checkbox" name="product-detail" class="product-detail" value="true">
                                    Detalhes
                                </label>)
                            @endif

                        </label>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary btn-small" id="reports-filter-btn">Filtrar</button>
        <button class="btn btn-secondary btn-small" id="filter-clear-all-btn">Limpa filtros</button>
        <button class="btn btn-primary btn-small pull-right" id="generate-csv-button"><i class="fa fa-file-excel-o"></i> Baixar</button>
    </div>
</div>

<div class="box-content nopadding regular-text">

    <table id="reportsTable" class="table table-hover table-nomargin table-bordered" data-nosort="0" data-checkall="all">
        <thead>
            <tr>
                <th >Nº</th>
                <th >Tipo</th>
                <th >Solicitado em</th>
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
        const enumProductValue = @json(PurchaseRequestType::PRODUCT->value);
        const enumServiceValue = @json(PurchaseRequestType::SERVICE->value);
        const enumContractValue = @json(PurchaseRequestType::CONTRACT->value);
        const urlAjax = @json(route('reports.index.json'));
        const enumRequests = @json($enumRequests);
        const $generateCSVButton = $('#generate-csv-button');
        const $reportsTable = $('#reportsTable');
        const $checkedStatusInputs = $('.status-checkbox');
        const $checkedRequestTypeInputs = $('.request-type-checkbox');
        const $requistingUsersIdsFilter = $('#requisting-users-filter');
        const $costCenterIdsFilter = $('#cost-center-filter')
        const $dateSince = $('#date-since');
        const $dateUntil = $('#date-until');
        const $filterClearBtn = $('#filter-clear-all-btn');
        const $filterClearUsersBtn = $('#filter-clear-users-btn');
        const $filterClearCostCentersBtn = $('#filter-clear-cost-centers-btn');
        const $productDetail = $('.product-detail');

        const $detailProductBtnTemplate = $('<span class="product-detail-btn" ><i class="glyphicon glyphicon-plus"></i></span>');

        const clearFilters = (_, filter = false) => {
            const clearOptions = {
                requistingUsersIdsFilter: () => $requistingUsersIdsFilter.val(null).trigger('change'),
                costCenterIdsFilter: () => $costCenterIdsFilter.val(null).trigger('change'),
                checkedRequestTypeInputs: () => $checkedRequestTypeInputs.prop('checked', true),
                checkedStatusInputs: () => {
                    $checkedStatusInputs.each((_, element) => {
                        const value = $(element).val();
                        const isChecked = value !== 'finalizada' && value !== 'cancelada';
                        $(element).prop('checked', isChecked);
                    });
                },
                dates: () => $dateSince.add($dateUntil).val(null),
                productDetail: () =>$productDetail.prop('checked', false)
            }

            if(filter) {
                clearOptions[filter]();
                return;
            }

            Object.values(clearOptions).forEach(el => el())
        }

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

            window.URL.revokeObjectURL(link.href);
        }

        const showProductDetail = () => {
            $('.product-detail-container').each((_, element) => {
                const $tr = $(element).closest('tbody tr');
                const $container = $(element).clone();
                $container.show();

                const $newRow = $(`<tr class='product-td' ><td colspan="11">${$container[0].outerHTML}<td></tr>`);
                $newRow.insertAfter($tr)
            })
        }

        $filterClearBtn.on('click', clearFilters);
        $filterClearUsersBtn.on('click', (_) => clearFilters(_, 'requistingUsersIdsFilter'));
        $filterClearCostCentersBtn.on('click', (_) => clearFilters(_, 'costCenterIdsFilter'));

        $reportsTable.on('draw.dt', () => {
            const $productDetail = $('.product-detail:checked').val();
            if($productDetail) {
                showProductDetail()
            }
        });

        $reportsTable.DataTable({
            initComplete: function() {
                $('#reports-filter-btn').on('click', () => {
                    const updatedUrlAjax = getUrlWithParams(urlAjax);
                    $reportsTable.DataTable().ajax.url(updatedUrlAjax).load();
                });

                $generateCSVButton.on('click', () => {
                    const $productDetail = $('.product-detail:checked').val();

                    let updatedUrlAjax = getUrlWithParams(urlAjax);
                    updatedUrlAjax += `&length=-1`;

                    $.ajax({
                        url: updatedUrlAjax,
                        type: 'GET',
                        success: (data) => {
                            const content = data.data;
                            const headers = $('#reportsTable>thead>tr>th').toArray().map(header => header.textContent);
                            const rows = content.map(item => {
                                const id = item.id
                                const type = enumRequests['type'][item.type]

                                const pendingStatus = item.logs
                                    .filter((item) => item.changes?.status === 'pendente')
                                    .find((item) => item.created_at)
                                    .created_at

                                const firstPendingStatus = moment(pendingStatus).format('DD/MM/YYYY HH:mm:ss')

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

                                let rowData = [
                                    [
                                        id,
                                        type,
                                        firstPendingStatus,
                                        requistingUser,
                                        status,
                                        suppliesUserName,
                                        costCenters,
                                        suppliers,
                                        paymentMethodLabel,
                                        paymentTermsLabel,
                                        formattedAmount
                                    ]
                                ]

                                if($productDetail && item.type === enumProductValue) {
                                    rowData.push(['' ,'Nome do produto', 'Categoria', 'Quantidade', 'Cor', 'Model', 'Tamanho']);

                                    item.purchase_request_product.forEach((element) => {
                                        const name = element.name;
                                        const category = element.category.name;
                                        const quantity = element.quantity;
                                        const color = element.color || '---';
                                        const model = element.model || '---';
                                        const size = element.size || '---';

                                        rowData.push([id, name,category, quantity, color, model, size]);
                                    })
                                }

                                return rowData;
                            });

                            const csv = [headers];
                            rows.forEach((row) => {
                                row.forEach((item) => {
                                    const csvRow = item.map((cell) => `"${cell}"`);
                                    csv.push('\n' + csvRow);
                                })
                                csv.push('\n');
                            });

                            downloadCsv(csv);
                        },
                        error: (response, textStatus, errorThrown) => {
                            bootbox.alert({
                                title: "Houve uma falha na busca dos registros!",
                                message: "Desculpe, mas ocorreu algum erro na busca dos registros. Por favor, tente novamente mais tarde. Contate o suporte caso o problema persista.",
                                className: 'bootbox-custom-warning'
                            });
                        },
                    });
                })
            },
            scrollY: '400px',
            scrollX: true,
            paging: true,
            serverSide: true,
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
                dataType: 'json',
                error: (response, textStatus, errorThrown) => {
                    bootbox.alert({
                        title: "Houve uma falha na busca dos registros!",
                        message: "Desculpe, mas ocorreu algum erro na busca dos registros. Por favor, tente novamente mais tarde. Contate o suporte caso o problema persista.",
                        className: 'bootbox-custom-warning'
                    });
                },
            },
            columns: [
                {
                    data: 'id',
                    render: (id, _, row) => {
                        const type = row.type;
                        if(type === enumProductValue) {
                            const productDetailContainer = `
                                <table class="product-detail-container table table-hover table-nomargin table-bordered" style="display: none">
                                    <thead>
                                        <th>Nome do produto</th>
                                        <th>Categoria</th>
                                        <th>Quantidade</th>
                                        <th>Cor</th>
                                        <th>Modelo</th>
                                        <th>Tamanho</th>
                                    </thead>
                                    <tbody>
                                        ${row.purchase_request_product.map((element) => {
                                            const { name, category, quantity, color, model, size } = element;
                                            return `
                                            <tr>
                                                <td>${name}</td>
                                                <td>${category.name}</td>
                                                <td>${quantity}</td>
                                                <td>${color || '---'}</td>
                                                <td>${model || '---'}</td>
                                                <td>${size || '---'}</td>
                                            </tr>
                                            `;
                                        }).join('')}
                                    </tbody>
                                </table>
                            `;

                            return id + ` ${productDetailContainer}`;
                        }

                        return id;
                    }
                },
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
                    data: 'type',
                    orderable: false,
                    render: (type, _, row) => {
                        const $div = $(document.createElement('div')).addClass('tag-category');

                        const supplierColumnMapping = {
                            product: () => row.purchase_request_product?.map((element) => element.supplier?.corporate_name),
                            service: () => [row.service?.supplier?.corporate_name],
                            contract: () => [row.contract?.supplier?.corporate_name],
                        };

                        const suppliers = supplierColumnMapping[type]()?.filter((el) => el);

                        if(!suppliers || suppliers.length === 0) {
                            return '---';
                        }

                        suppliers.forEach((element) => {
                            const $span = $(document.createElement('span')).addClass('tag-category-item');
                            $span.text(element);
                            $div.append($span);
                        });

                        return $div[0].outerHTML;
                    }
                },
                {
                    data: 'type',
                    orderable: false,
                    render: (type, _, row) => {
                        const paymentInfo = row[type]?.payment_info || {};
                        const paymentMethod = paymentInfo.payment_method ;
                        const paymentMethodLabel = enumRequests['paymentMethod'][paymentMethod] ?? '---'

                        return paymentMethodLabel;
                    }
                },
                {
                    data: 'type',
                    orderable: false,
                    render: (type, _, row) => {
                        const paymentInfo = row[type]?.payment_info || {};
                        const paymentTerms = paymentInfo?.payment_terms || '---';
                        const paymentTermsLabel = enumRequests['paymentTerms'][paymentTerms] ?? '---'

                        return paymentTermsLabel;
                    }
                },
                {
                    data: 'type',
                    render: (type, _, row) => {
                        const amount = row[type]?.amount || row[type]?.price;

                        if (!amount || !isFinite(amount)) {
                            return 'R$ ---';
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

