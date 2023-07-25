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
        desired_date: (value) => dateFormatter(value),
        created_at: (value) => dateFormatter(value),
        updated_at: (value) => dateFormatter(value),
        responsibility_marked_at: (value) => dateFormatter(value),
        is_comex: (value) => booleanFormatter(value, 'Sim', 'Não'),
        is_supplies_contract: (value) => booleanFormatter(value, 'Suprimentos', 'Solicitante'),
        purchase_request_file: (value) => value[0] ? `<a href="${value[0].path}" target="_blank" rel="noopener noreferrer">Ver link</a> ` : '---' ,
    }

    const mappedUserEntries = {
        approve_limit: (value) => value,
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