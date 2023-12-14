@push('styles')
    <style>
        #modal-supplies-product-info .modal-body {
            padding-bottom: 50px;
        }

        #dynamic-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        #dynamic-info>.list-group {
            border: 1px solid var(--grey-primary-color);
            padding: 5px;
        }

        .list-group-flush {
            border-radius: 4px;
            border: 1px solid var(--grey-secondary-color);
        }

        @media(min-width: 1280px) {
            #dynamic-info {
                flex-flow: row wrap;
            }

            #dynamic-info>.list-group {
                flex: 1 0 100%;
            }

            #dynamic-info>.list-group.half-width {
                flex: 1 0 calc(50% - 20px);
            }

            #dynamic-info>.list-group.cost-centers,
            #dynamic-info>.list-group.suppliers {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: flex-start;
                position: relative;
                padding-top: 35px;
                gap: 5px;
            }

            #dynamic-info>.list-group.cost-centers>h5,
            #dynamic-info>.list-group.suppliers>h5 {
                position: absolute;
                top: 5px;
                left: 5px;
            }

            #dynamic-info>.list-group.cost-centers>.list-group-item,
            #dynamic-info>.list-group.suppliers>.list-group-item {
                border: none;
                flex-grow: 1;
                max-width: calc(33.33% - 5px);
            }
        }
    </style>
@endpush

<div class="modal fade" id="modal-supplies-product-info" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-label">
                    <strong>Solicitação de produto - Nº <span class="modal-request-id"></span></strong>
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Dinâmico --}}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        $(() => {
            const baseUrl = @json(route('api.requests.show', ['id' => '__id__']));
            const $suppliesProductInfo = $('#modal-supplies-product-info');
            const $modalRequestId = $('.modal-request-id');
            const $modalBody = $suppliesProductInfo.find('.modal-body');

            const dateFormatter = (date, execeptionMessage) => date ? new Date(date).toLocaleDateString('pt-br') : (execeptionMessage || '---');
            const formatCnpj = (cnpj) => cnpj?.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
            const numberFormat = (amount, decimals = 2, decimalSeparator = ',', thousandsSeparator = '.') => {
                const formattedAmount = Number(amount).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSeparator);
                return formattedAmount.replace('.', decimalSeparator);
            }

            $suppliesProductInfo.on('show.bs.modal', function(event) {
                $modalBody.html('');
                const $button = $(event.relatedTarget);
                const requestId = $button.data('id');
                const url = baseUrl.replace('__id__', requestId);

                $modalRequestId.text(requestId);

                $.get({
                    url,
                    dataType: 'json',
                    success: (data) => {
                        const {
                            status,
                            type,
                            is_supplies_contract,
                            is_comex,
                            created_at,
                            updated_at,
                            desired_date,
                            user,
                            supplies_user,
                            cost_center_apportionment,
                            purchase_request_product,
                            support_links,
                            responsibility_marked_at,
                            product,
                        } = data.request;

                        const basicInfo = {
                            status,
                            type,
                            is_supplies_contract,
                            is_comex,
                            created_at,
                            updated_at,
                            desired_date,
                            amount: product?.amount,
                        };

                        const requesterInfo = {
                            email: user.email,
                            is_buyer: user.is_buyer,
                        };

                        const suppliers = purchase_request_product
                            .filter(product => product?.supplier)
                            .map(({
                                supplier
                            }) => ({
                                corporate_name: supplier.corporate_name,
                                cpf_cnpj: supplier.cpf_cnpj,
                                market_type: supplier.market_type
                            }));

                        const suppliesInfo = {
                            name: supplies_user?.person.name,
                            email: supplies_user?.email,
                            responsibility_marked_at
                        };

                        const costCenters = cost_center_apportionment
                            .map(apportionment => apportionment.cost_center)
                            .map((costCenter) => ({
                                name: costCenter.name,
                                cnpj: costCenter.company?.cnpj,
                                company: costCenter.company?.name
                            }));

                        const products = purchase_request_product.map(({
                            name
                        }) => ({
                            name
                        }));

                        const content = {
                            basicInfo,
                            requesterInfo,
                            suppliesInfo,
                            support_links,
                            costCenters,
                            suppliers,
                            products
                        };

                        const contentKeys = Object.keys(content);

                        const $newDiv = $('<div id="dynamic-info"></div>')
                        Object.values(content).forEach((item, index) => {
                            const options = {
                                basicInfo: () => {
                                    const $newList = $(`
                                        <ul class="list-group">
                                            <h5 class="mb-1"><strong><i class="fa-solid fa-circle-info"></i> Informações básicas</strong></h5>
                                            <li class="list-group-item"><strong>Status de aprovação:</strong> ${Enum.PurchaseRequestStatus.getLabel(item.status)}</li>
                                            <li class="list-group-item"><strong>Tipo de solicitação:</strong> ${Enum.PurchaseRequestType.getLabel(item.type)}</li>
                                            <li class="list-group-item"><strong>Contratação deve ser por:</strong> ${item.is_supplies_contract ? 'Suprimentos' : 'Solicitante'}</li>
                                            <li class="list-group-item"><strong>COMEX:</strong> ${item.is_comex ? 'Sim' : 'Não'}</li>
                                            <li class="list-group-item"><strong>Valor total:</strong> R$ ${numberFormat(item.amount)}</li>
                                            <li class="list-group-item"><strong>Solicitação criada em:</strong> ${dateFormatter(item.created_at)}</li>
                                            <li class="list-group-item"><strong>Solicitação atualizada em:</strong> ${dateFormatter(item.updated_at)}</li>
                                            <li class="list-group-item"><strong>Solicitação desejada para:</strong> ${dateFormatter(item.desired_date)}</li>
                                        </ul>
                                    `);

                                    $newDiv.append($newList);
                                },
                                requesterInfo: () => {
                                    const $newList = $(`
                                        <ul class="list-group half-width">
                                            <h5 class="mb-1"><strong><i class="fa fa-user"></i> Informações do solicitante</strong></h5>
                                            <li class="list-group-item"><strong>E-mail do solicitante:</strong> ${item.email || '---'}</li>
                                            <li class="list-group-item"><strong>É comprador:</strong> ${item.is_buyer ? 'Sim' : 'Não'}</li>
                                        </ul>
                                    `);

                                    $newDiv.append($newList);
                                },
                                suppliesInfo: () => {
                                    const $newList = $(`
                                        <ul class="list-group half-width">
                                            <h5 class="mb-1"><strong><i class="fa fa-user"></i> Informações do suprimentos</strong></h5>
                                            <li class="list-group-item"><strong>Nome:</strong> ${item.name || '---'}</li>
                                            <li class="list-group-item"><strong>Email:</strong> ${item.email || '---'}</li>
                                            <li class="list-group-item"><strong>Data de responsabilidade marcada em:</strong> ${dateFormatter(item.responsibility_marked_at)}</li>
                                        </ul>
                                    `);

                                    $newDiv.append($newList);
                                },
                                support_links: () => {
                                    const $newList = $(
                                        '<ul class="list-group"><h5 class="mb-1"><i class="fa-solid fa-link"></i> <strong>Links de apoio/sugestão</strong></h5></ul>'
                                    );

                                    const support_links = item?.replaceAll('\n', '__break__')
                                        .replaceAll(' ', '__break__')
                                        .split('__break__');

                                    if (!support_links) {
                                        $newList.append('<li class="list-group-item">Nenhum link disponível</li>')
                                        $newDiv.append($newList);
                                        return;
                                    }

                                    const $newLi = $('<li class="list-group-item"></li>')
                                    support_links.forEach((link, linkIndex) => $newList
                                        .append(
                                            `<li class="list-group-item"><a href="${link}" target="_blank">Link ${linkIndex + 1}</a></li>`
                                        )
                                    );

                                    $newDiv.append($newList);
                                },
                                costCenters: () => {
                                    const $costCentersItems = $(
                                        '<ul class="list-group cost-centers"><h5 class="mb-1"><i class="fa-solid fa-money-bill"></i> <strong>Centros de custo</strong></h5></ul>'
                                    );
                                    item.forEach(costCenter => {
                                        const $newList = $(`
                                            <li class="list-group-item">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item"><strong>Nome do centro de custo:</strong> ${costCenter.name || '---'}</li>
                                                    <li class="list-group-item"><strong>CNPJ da empresa:</strong> ${formatCnpj(costCenter.cnpj) || '---'}</li>
                                                    <li class="list-group-item"><strong>Nome da empresa:</strong> ${costCenter.company || '---'}</li>
                                                </ul>
                                            </li>
                                        `);

                                        $costCentersItems.append($newList);
                                    });

                                    $newDiv.append($costCentersItems);
                                },
                                suppliers: () => {
                                    const $suppliersItems = $(
                                        '<ul class="list-group list-group-flush suppliers"><h5 class="mb-1"><i class="fa-solid fa-building"></i> <strong>Fornecedores</strong></h5></ul>'
                                    );

                                    if (!item.length) {
                                        $suppliersItems.append('<li class="list-group-item">Não encontrado fornecedores</li>');
                                        $newDiv.append($suppliersItems);
                                        return;
                                    }

                                    item.forEach(supplier => {
                                        const $newList = $(`
                                            <li class="list-group-item">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item"><strong>Nome:</strong> ${supplier.corporate_name || '---'}</li>
                                                    <li class="list-group-item"><strong>CPF/CNPJ:</strong> ${formatCnpj(supplier.cpf_cnpj) || '---'}</li>
                                                    <li class="list-group-item"><strong>Tipo de mercado:</strong> ${supplier.market_type || '---'}</li>
                                                </ul>
                                            </li>
                                        `);

                                        $suppliersItems.append($newList);
                                    });

                                    $newDiv.append($suppliersItems);
                                },
                                products: () => {
                                    const $newList = $(
                                        '<ul class="list-group list-group-flush"><h5 class="mb-1"><i class="fa-solid fa-tags"></i> <strong>Produtos</strong></h5></ul>'
                                    );

                                    item.forEach(product => {
                                        $newList.append(
                                            `<li class="list-group-item"><strong>Nome/Descrição:</strong> ${product.name}</li>`
                                        );
                                    });

                                    $newDiv.append($newList);
                                },
                            }

                            options[contentKeys[index]]();
                        });

                        $modalBody.append($newDiv);
                    },
                    error: (error) => {
                        alert('Ops! Acontece algum erro ao carregar as informações.');
                        bootstrap.getOrCreateInstance($suppliesProductInfo).hide();
                    }
                });
            });
        });
    </script>
@endpush
