@php
    use App\Enums\{PurchaseRequestType, PurchaseRequestStatus, PaymentMethod, PaymentTerm};

    $enumRequests = [
        'type' => collect(PurchaseRequestType::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
        'status' => collect(PurchaseRequestStatus::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
        'paymentMethod' => collect(PaymentMethod::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
        'paymentTerms' => collect(PaymentTerm::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
    ];

@endphp

<style>
.row-filter-reports {
    display: flex;
    gap: 20px;
    padding: 15px 0;
    align-items: center;
    flex-wrap: wrap
}

.row-filter-reports .checkbox-label {
    cursor: pointer;
}

</style>

<div class="box-content nopadding regular-text">

    <div class="row">
        <div class="col-sm-3">
            <label for="requisting-users-filter" class="regular-text">Solicitante</label>
            <div class="form-group">
                <select name="requisting-users-filter[]" id="requisting-users-filter" multiple="multiple" class="chosen-select form-control">

                    @foreach ($requestingUsers as $user)
                        <option value="{{$user->id}}">{{$user->person->name}}</option>
                    @endforeach

                </select>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-2">
            <span class="regular-text">Tipo da solicitação:</span>
            <div class="row-filter-reports">

                @foreach (PurchaseRequestType::cases() as $typeCase)
                    <label class="checkbox-label secondary-text">
                        <input type="checkbox" name="request-type[]" class="request-type-checkbox" value="{{ $typeCase->value }}" checked>
                        {{ $typeCase->label() }}
                    </label>
                @endforeach

            </div>
        </div>

        <div class="col-sm-7">
            <span class="regular-text">Status da solicitação:</span>
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

        $('#reportsTable').DataTable({
            initComplete: function() {
                $('#reports-filter-btn').click(() => {
                    const $checkedStatusInputs = $('.status-checkbox:checked');
                    const $checkedRequestTypeInputs = $('.request-type-checkbox:checked');
                    const $requistingUsersIdsFilter = $('#requisting-users-filter').val() || "";

                    const statusValues = $checkedStatusInputs.map((index, element) => element.value).toArray();
                    const requestTypeValues = $checkedRequestTypeInputs.map((index, element) => element.value).toArray();

                    const updatedUrlAjax = `${urlAjax}?status=${statusValues.join(',')}&request-type=${requestTypeValues.join(',')}&requesting-users-ids=${$requistingUsersIdsFilter}`;

                    $('#reportsTable').DataTable().ajax.url(updatedUrlAjax).load();
                });
            },
            scrollY: '400px',
            scrollX: true,
            serverSide: true,
            paging: true,
            lengthMenu: [10, 25, 50, 100],
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

