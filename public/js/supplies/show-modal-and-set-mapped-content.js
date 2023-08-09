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
                    contract: 'Contrato',
                    product: 'Produto',
                    service: 'Serviço'
                }
                return requestType[value] ?? '---'
            },
            description: (value) => value,
            local_description: (value) => value,
            reason: (value) => value,
            observation: (value) => value,
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
    
        const request = button.data('request');
        const requestUser = request.user
        const requestSuppliesUser = request.supplies_user
    
        const costCenterApportionment = request.cost_center_apportionment
        
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
    
        mapObjectAndReturnContent(request, mappedBasicInfoEntries)
        mapObjectAndReturnContent(requestUser, mappedUserEntries, 'user-')
        if(requestSuppliesUser) {
            mapObjectAndReturnContent(requestSuppliesUser, mappedSuppliesUserEntries, 'supplies-user-')
        }
    });
});
