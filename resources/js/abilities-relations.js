// Habilidades dependentes de outras habilidades
const abilityRelations = {
    1: {autoCheck: true, relations: [34, ],},
    10: {autoCheck: true, relations: [7, 93,],},
    11: {autoCheck: true, relations: [8, 63,],},
    12: {autoCheck: true, relations: [9, 63,],},
    19: {autoCheck: true, relations: [18, ],},
    22: {autoCheck: true, relations: [18, ],},
    25: {autoCheck: true, relations: [18, ],},
    28: {autoCheck: true, relations: [17, 16, 63,],},
    31: {autoCheck: true, relations: [34, ],},
    35: {autoCheck: true, relations: [34, ],},
    37: {autoCheck: true, relations: [36, ],},
    38: {autoCheck: true, relations: [36, ],},
    41: {autoCheck: true, relations: [58, ],},
    44: {autoCheck: true, relations: [51, ],},
    57: {autoCheck: true, relations: [58, ],},
    60: {autoCheck: true, relations:[61, ],},
}

const checkAbilityRelations = (event) => {
    $('.list-group-item').removeClass('ability-relation-alert');

    const $checkBox = $(event.target);
    const abilityId = $checkBox.val();
    const isChecked = $checkBox.is(':checked');
    const relations = abilityRelations[abilityId]?.relations;
    const isAutoCheck = abilityRelations[abilityId]?.autoCheck;

    relations?.forEach(abilityIdTarget => {
        const $input = $(`input[name="abilities[]"][value="${abilityIdTarget}"]`);
        const $groupItem = $input.closest('.list-group-item');

        if (isChecked) {
            $groupItem.addClass('ability-relation-alert');

            const positionTarget = $input.offset().top - $(window).height() / 2;
            $('html, body').animate({ scrollTop: positionTarget}, 'slow');

            if(isAutoCheck) {
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
