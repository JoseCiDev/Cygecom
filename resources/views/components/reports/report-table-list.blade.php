@php
    use App\Enums\{PurchaseRequestType, PurchaseRequestStatus, PaymentMethod, PaymentTerm};

    $enumRequests = [
        'type' => collect(PurchaseRequestType::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
        'status' => collect(PurchaseRequestStatus::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
        'paymentMethod' => collect(PaymentMethod::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
        'paymentTerms' => collect(PaymentTerm::cases())->mapWithKeys(fn ($enum) => [$enum->value => $enum->label()]),
    ];

@endphp

<div class="box-content nopadding regular-text">
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

