// Habilidades dependentes de outras habilidades
const abilityRelations = {
    1: [34, ],
    10: [7, ],
    11: [8, ],
    12: [9, ],
    19: [18, ],
    22: [18, ],
    25: [18, ],
    28: [17, 16, ],
    31: [34, ],
    35: [34, ],
    37: [36, ],
    38: [36, ],
    41: [58, ],
    44: [51, ],
    57: [58, ],
    60: [61, ],
}

const checkAbilityRelations = (event) => {
    $('.list-group-item').removeClass('ability-relation-alert');

    const $checkBox = $(event.target);
    const abilityId = $checkBox.val();
    const isChecked = $checkBox.is(':checked');
    const relations = abilityRelations[abilityId];

    relations?.forEach(abilityIdTarget => {
        const $input = $(`input[name="abilities[]"][value="${abilityIdTarget}"]`);
        const $groupItem = $input.closest('.list-group-item');

        if (isChecked) {
            $groupItem.addClass('ability-relation-alert');
            const message = ' Recomendado marcar habilidade destacada. Essa habilidade costuma ser usada em conjunto com outra(s). Ignore o aviso caso habilidade destacada já estiver marcada.';
            $.fn.createToast(message, 'Permissões relacionadas', 'bg-warning');
        } else {
            $groupItem.removeClass('ability-relation-alert');
        }
    });
}

export {abilityRelations, checkAbilityRelations};
