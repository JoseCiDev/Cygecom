const setColvisConfig = () => {
    const saveOnStorage = (itemName, object) => localStorage.setItem(itemName, JSON.stringify(object));
    const getStorageItem = (itemName) => JSON.parse(localStorage.getItem(itemName));
    const getColvisPreferenceKeyName = ($currentElement) => {
        const currentDtId = $currentElement.closest('.dataTables_wrapper').attr('id');
        const currentPathname = window.location.pathname;
        return `${currentPathname}#${currentDtId}`;
    };

    const setBadgeColumnQtd = (qtd) => {
        const $badgeColumns = $('button.dt-button.buttons-collection.buttons-colvis .badge');
        $badgeColumns.text(qtd === 0 ? null : qtd);
    }

    const colvisColumnToggle = (event) => {
        const $currentElement = $(event.target).closest('button.dt-button.buttons-columnVisibility');
        const columnIndex = $currentElement.data('cv-idx');
        const isActive = $currentElement.hasClass('dt-button-active');
        const colvisPreferenceKeyName = getColvisPreferenceKeyName($currentElement);

        const dtUserColumnPreference = getStorageItem(colvisPreferenceKeyName);
        if(!dtUserColumnPreference) {
            const saveFirstPreference = () => {
                $.get('/api/user').done((user) => {
                    const dtUserColumnPreference = {  userId: user.id, columnsIdx: [{ idx: columnIndex, isActive: isActive }] };
                    saveOnStorage(colvisPreferenceKeyName, dtUserColumnPreference);
                    setBadgeColumnQtd(dtUserColumnPreference.columnsIdx.length);
                });
            }
            saveFirstPreference();

            return;
        }

        const columnIdxPreference = dtUserColumnPreference.columnsIdx.find((element) => element.idx === columnIndex);
        if(columnIdxPreference) {
            columnIdxPreference.isActive = isActive;
        } else {
            dtUserColumnPreference.columnsIdx.push({idx: columnIndex, isActive: isActive});
        }

        saveOnStorage(colvisPreferenceKeyName, dtUserColumnPreference);

        const inactiveColumnQtd = dtUserColumnPreference.columnsIdx.filter((element) => !element.isActive).length
        setBadgeColumnQtd(inactiveColumnQtd);
    }

    const onOpenColvis = (event) => {
        const $currentElement = $(event.target)
        const colvisPreferenceKeyName = getColvisPreferenceKeyName($currentElement);
        const dtUserColumnPreference = getStorageItem(colvisPreferenceKeyName);

        if(dtUserColumnPreference) {
            const {userId, columnsIdx} = dtUserColumnPreference;

            $.get('/api/user').done((user) => {
                const isCurrentUser = user.id === userId;
                if(!isCurrentUser) {
                    localStorage.removeItem(colvisPreferenceKeyName);
                    return;
                }

                const hideColumns = (columnsIdx) => {
                    $.each(columnsIdx, (_, element) => {
                        const { idx, isActive } = element;
                        const $btnIdx = $(`button.dt-button.buttons-columnVisibility.dt-button-active[data-cv-idx='${idx}']`);

                        if(!isActive) {
                            $btnIdx.trigger('click');
                        }
                    })
                }

                hideColumns(columnsIdx)
            })
        }
    }

    $(document).on('click', 'button.dt-button.buttons-collection.buttons-colvis', onOpenColvis);
    $(document).on('click', 'button.dt-button.buttons-columnVisibility', colvisColumnToggle);
}

export default setColvisConfig;
