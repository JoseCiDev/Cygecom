$(() =>{
    const formatCnpj = (cnpj) => cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');

    $('#modal-supplies').on('show.bs.modal', function(event) {
        const list = $('.modal-body-dynamic-list')
        list.text('')

        const modal = $(this);
        const button = $(event.relatedTarget);
        const name = button.data('modal-name');

        modal.find('.modal-name').text(name);

        const dateFormatter = (date, execeptionMessage) => date ? new Date(date).toLocaleDateString('pt-br') : (execeptionMessage || '---');
        const booleanFormatter = (value, truthyMessage, falsyMessage) => value ? (truthyMessage || 'Verdadeiro') : (falsyMessage || 'Falso');

        const mappedBasicInfoEntries = {
            id: (value) => value,
            status: (value) => {
                const status = {
                    pendente: 'Pendente',
                    em_tratativa: 'Em tratativa',
                    em_cotacao: 'Em cotação',
                    aguardando_aprovacao_de_compra: 'Aguardando aprovação de compra',
                    compra_efetuada: 'Compra efetuada',
                    finalizada: 'Finalizada',
                    cancelada: 'Cancelada',
                }
                return status[value] ?? '---'
            },
            type: (value) => {
                const requestType = {
                    contract: 'Serviço recorrente',
                    product: 'Produto',
                    service: 'Serviço pontual'
                }
                return requestType[value] ?? '---'
            },
            description: (value) => value,
            local_description: (value) => value,
            observation: (value) => value ?? '---',
            support_links: (value) => value?.replaceAll('\n', '<br>').replaceAll(' ', '<br><br>') ?? 'Sem links de apoio/sugestão',
            desired_date: (value) => dateFormatter(value),
            created_at: (value) => dateFormatter(value),
            updated_at: (value) => dateFormatter(value),
            responsibility_marked_at: (value) => dateFormatter(value),
            is_comex: (value) => booleanFormatter(value, 'Sim', 'Não'),
            is_supplies_contract: (value) => booleanFormatter(value, 'Suprimentos', 'Solicitante'),
        }

        const mappedUserEntries = {
            email: (value) =>  value,
            is_buyer: (value) => booleanFormatter(value, 'Autorizado', 'Não autorizado'),
        }

        const mappedSuppliesUserEntries = {
            email: (value) =>  value,
            person: (value) => value?.name
        }

        const suppliers = button.data('request').suppliers;
        const purchaseRequest = button.data('request').request;
        const requestUser = purchaseRequest.user
        const requestSuppliesUser = purchaseRequest.supplies_user
        const costCenterApportionment = purchaseRequest.cost_center_apportionment
        const products = purchaseRequest.purchase_request_product;
        const $modalListContainer = $(".modal-list-container");
        const $modalProductList = $("#modal-product-list");

        const hasProducts = products.length > 0;

        const elementCostCenterApportionment = $('.costCenterApportionment');
        elementCostCenterApportionment.empty();
        costCenterApportionment.forEach(element => {
            const liElement = `<li style="margin-bottom: 10px;">
                <strong>Centro de custo:</strong> ${element.cost_center.name}<br>
                <strong>CNPJ:</strong> ${formatCnpj(element.cost_center.company.cnpj)}<br>
                <strong>Empresa:</strong> ${element.cost_center.company.name}
            </li>`;
            elementCostCenterApportionment.append(liElement);
        });


        const elementSuppliersInformation = $('.supplier-information');
        elementSuppliersInformation.empty();
        let htmlElement;

        if (Array.isArray(suppliers)) {
            suppliers.forEach(element => {
                htmlElement = `
                    <strong>Razão Social:</strong> ${element?.corporate_name || '---'}<br>
                    <strong>CNPJ:</strong> ${element?.cpf_cnpj || '---'}<br>
                    <strong>Tipo de mercado:</strong> ${element?.market_type || '---'}
                <hr>`;
                elementSuppliersInformation.append(htmlElement);
            });

        } else {
            htmlElement = `
                <strong>Razão Social:</strong> ${suppliers?.corporate_name || '---'}<br>
                <strong>CNPJ:</strong> ${suppliers?.cpf_cnpj || '---'}<br>
                <strong>Tipo de mercado:</strong> ${suppliers?.market_type || '---'}
            <hr>`;
            elementSuppliersInformation.append(htmlElement);
        }


        const mapObjectAndReturnContent = (object, mappedEntries, selector = '') => {
            const entries = Object.entries(object)
            entries.forEach(element => {
                const [key, value] = element
                const getElement = $(`.${selector + key}`)

                if (!getElement.length) {
                    return
                }

                if(mappedEntries[key]) {
                    const content = mappedEntries[key](value)
                    getElement.html(content)
                }
            });
        }

        mapObjectAndReturnContent(purchaseRequest, mappedBasicInfoEntries)
        mapObjectAndReturnContent(requestUser, mappedUserEntries, 'user-')

        if(requestSuppliesUser) {
            mapObjectAndReturnContent(requestSuppliesUser, mappedSuppliesUserEntries, 'supplies-user-')
        }

        hasProducts ? $modalListContainer.show() : $modalListContainer.hide();
        if(hasProducts) {
            $modalProductList.html("");
            products.forEach(({name}) => {
                const $li = $('<li>').html(`<strong>Nome:</strong> ${name}`);
                $modalProductList.append($li);
            });
        }
    });
});
