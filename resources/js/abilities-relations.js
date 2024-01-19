// Habilidades dependentes de outras habilidades
const abilityRelations = {
    1: {required: true, relations: [34, ],},
    10: {required: true, relations: [7, ],},
    11: {required: true, relations: [8, ],},
    12: {required: true, relations: [9, ],},
    19: {required: true, relations: [18, ],},
    22: {required: true, relations: [18, ],},
    25: {required: true, relations: [18, ],},
    28: {required: true, relations: [17, 16, ],},
    31: {required: true, relations: [34, ],},
    35: {required: true, relations: [34, ],},
    37: {required: true, relations: [36, ],},
    38: {required: true, relations: [36, ],},
    41: {required: true, relations: [58, ],},
    44: { required: true, relations: [51, ],},
    57: {required: true, relations: [58, ],},
    60: {required: true, relations:[61, ],},
}

const checkAbilityRelations = (event) => {
    $('.list-group-item').removeClass('ability-relation-alert');

    const $checkBox = $(event.target);
    const abilityId = $checkBox.val();
    const isChecked = $checkBox.is(':checked');
    const relations = abilityRelations[abilityId].relations;
    const isRequired = abilityRelations[abilityId].required;

    relations?.forEach(abilityIdTarget => {
        const $input = $(`input[name="abilities[]"][value="${abilityIdTarget}"]`);
        const $groupItem = $input.closest('.list-group-item');

        if (isChecked) {
            $groupItem.addClass('ability-relation-alert');

            if(isRequired) {
                const isRequiredMessage ='Atenção! Relações recomendadas foram marcadas automaticamente. Analise as permissões destacadas e desmarque se necessário.';
                $.fn.createToast(isRequiredMessage, 'Permissões relacionadas', 'bg-warning');
                $input.prop('checked', true)
                return;
            };

            const message = 'Recomendado marcar habilidade destacada. Essa habilidade costuma ser usada em conjunto com outra(s). Ignore o aviso caso habilidade destacada já estiver marcada.';
            $.fn.createToast(message, 'Permissões relacionadas', 'bg-warning');
        } else {
            $groupItem.removeClass('ability-relation-alert');
        }
    });
}

export {abilityRelations, checkAbilityRelations};
