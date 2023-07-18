<div class="modal fade" id="modal-supplies" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-label"><strong class="name"></strong></h4>
            </div>
            <div class="modal-body">
                <h3>Aqui consta informações detalhadas da solicitação:</h3>
                <div class="modal-body-dynamic">
                    <div class="modal-body-dynamic-list"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#modal-supplies').on('show.bs.modal', function (event) {
        const list = $('.modal-body-dynamic-list')
        list.text('')

        const modal = $(this);
        const button = $(event.relatedTarget);
        const name = button.data('name');
        const id = button.data('id');

        modal.find('.name').text(name);

        const liElementInterface = entry => {
            const dateFormatter = (date, execeptionMessage) => date ? new Date(date).toLocaleDateString('pt-br') : (execeptionMessage || '---');
            const booleanFormatter = (value, truthyMessage, falsyMessage) => value ? (truthyMessage || 'Verdadeiro' ) : (falsyMessage || 'Falso');

            const mappedEntries = {
                id: {label: 'Solicitação nº'},
                status: {label: 'Status'},
                type: {label: 'Tipo de solicitação' },
                description: {label: 'Descrição' },
                local_description: {label: 'Local' },
                reason: {label: 'Motivo' },
                observation: {label: 'Observação' },

                desired_date: {
                    label: 'Data desejada',
                    content: dateFormatter(entry[1]) 
                },
                created_at: {
                    label: 'Criado em',
                    content: dateFormatter(entry[1]) 
                },
                updated_at: {
                    label: 'Atualizado em',
                    content: dateFormatter(entry[1]) 
                },
                is_comex: {
                    label: 'É comex', 
                    content: booleanFormatter(entry[1], 'Sim', 'Não') 
                },
                is_supplies_contract: {
                    label: 'É contratação por suprimentos', 
                    content: booleanFormatter(entry[1], 'Sim', 'Não')
                },
                user: {
                    label: 'Usuário criador',
                    content: `<ul>
                                <li>Nome: ${entry[1]?.person?.name}</li>
                                <li>E-mail: ${entry[1]?.email}</li>
                            </ul>`
                 },
                updated_by_user: {
                    label: 'Usuário atualizador',
                    content: entry[1]?.email
                },
                purchase_request_file: {
                    label: 'Link',
                    content: `<a href="${entry[1] ? entry[1][0]?.path : '#'}" target="_blank">Ir para o link</a>`
                },
            }

            const result = mappedEntries[entry[0]]
            if(result) {
                result.content ??= entry[1]
                return result
            }
        }

        const request = button.data('request');
        const response = Object.entries(request)
        response.forEach((element) => {
            const formattedElement = liElementInterface(element)
            if(formattedElement) {
                list.append(`<div class="modal-body-dynamic-list-item">${formattedElement.label}: ${formattedElement.content ??= '---'}</div>`)
            }
        })
    });
</script>
