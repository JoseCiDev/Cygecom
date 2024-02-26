const getUserStorageItem = (itemName) => {
    const storageItem = $.fn.getStorageItem(itemName);
    if(!storageItem) {
        return;
    }

    return storageItem[$.fn.getUserIdLogged()];
};
const getStorageKey = ($currentElement) => {
    const currentDtId = $currentElement.closest('.dataTables_wrapper').attr('id');
    const currentPathname = window.location.pathname;
    return `colvis-${currentPathname}#${currentDtId}`;
};
const setBadgeColumnQtd = (qtd) => {
    const $badgeColumns = $('button.dt-button.buttons-collection.buttons-colvis .badge');
    $badgeColumns.text(qtd === 0 ? null : qtd);
}
const onOpenColvis = (event) => {
    const $currentElement = $(event.target)
    const storageKey = getStorageKey($currentElement);
    const dtUserColumnPreference = getUserStorageItem(storageKey);

    if(dtUserColumnPreference) {
        const {columnsIdx} = dtUserColumnPreference;

        $.each(columnsIdx, (_, element) => {
            const { idx, isActive } = element;
            const $btnIdx = $(`button.dt-button.buttons-columnVisibility.dt-button-active[data-cv-idx='${idx}']`);

            if(!isActive) {
                $btnIdx.trigger('click');
            }
        })
    }
}
const colvisColumnToggle = (event) => {
    const userId = $.fn.getUserIdLogged();
    const $currentElement = $(event.target).closest('button.dt-button.buttons-columnVisibility');
    const columnIndex = $currentElement.data('cv-idx');
    const isActive = $currentElement.hasClass('dt-button-active');
    const storageKey = getStorageKey($currentElement);
    const storageItem = $.fn.getStorageItem(storageKey) || {};
    const loggedUserStorage = getUserStorageItem(storageKey);

    if(!loggedUserStorage) {
        const loggedUserStorage = {
            userId: userId,
            columnsIdx: [{ idx: columnIndex, isActive: isActive }]
        };

        storageItem[userId] = loggedUserStorage;
        $.fn.saveOnStorage(storageKey, storageItem);
        setBadgeColumnQtd(loggedUserStorage.columnsIdx.length);
        return;
    }

    const columnIdxPreference = loggedUserStorage.columnsIdx.find((element) => element.idx === columnIndex);
    if(columnIdxPreference) {
        columnIdxPreference.isActive = isActive;
    } else {
        loggedUserStorage.columnsIdx.push({idx: columnIndex, isActive: isActive});
    }

    storageItem[userId] = loggedUserStorage;
    $.fn.saveOnStorage(storageKey, storageItem);

    const inactiveColumnQtd = loggedUserStorage.columnsIdx.filter((element) => !element.isActive).length
    setBadgeColumnQtd(inactiveColumnQtd);
}

const setColvisConfig = () => {
    $(document).on('click', 'button.dt-button.buttons-collection.buttons-colvis', onOpenColvis);
    $(document).on('click', 'button.dt-button.buttons-columnVisibility', colvisColumnToggle);
}

export default setColvisConfig;
