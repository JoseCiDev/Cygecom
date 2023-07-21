$('#modal-supplies').on('show.bs.modal', function(event) {
    const list = $('.modal-body-dynamic-list')
    list.text('')

    const modal = $(this);
    const button = $(event.relatedTarget);
    const name = button.data('modal-name');
    const id = button.data('id');

    modal.find('.modal-name').text(name);

    const dateFormatter = (date, execeptionMessage) => date ? new Date(date).toLocaleDateString('pt-br') : (execeptionMessage || '---');
    const booleanFormatter = (value, truthyMessage, falsyMessage) => value ? (truthyMessage || 'Verdadeiro') : (falsyMessage || 'Falso');

    const mappedBasicInfoEntries = {
        id: (value) => value,
        status: (value) => {
            const status = { 
                pendente: 'Pendente',
                em_tratativa: 'Aprovado',
                em_cotacao: 'Desaprovado',
                aguardando_aprovacao_de_compra: 'Desaprovado',
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
        is_comex: (value) => booleanFormatter(value, 'Sim', 'Não'),
        is_supplies_contract: (value) => booleanFormatter(value, 'Suprimentos', 'Solicitante'),
        purchase_request_file: (value) => value[0] ? `<a href="${value[0].path}" target="_blank" rel="noopener noreferrer">Ver link</a> ` : '---' ,
    }

    const mappedUserEntries = {
        approve_limit: (value) => value,
        email: (value) =>  value,
        is_buyer: (value) => booleanFormatter(value, 'Autorizado', 'Não autorizado'),
    }

    const request = button.data('request');

    const mapObjectAndReturnContent = (object, mappedEntries) => {
        const entries = Object.entries(object)
        entries.forEach(element => {
            const [key, value] = element
            if(key === 'user') {
                mapObjectAndReturnContent(value, mappedUserEntries)
            }
            const getElement = $(`.request-details-content-box .${key}`)
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
});