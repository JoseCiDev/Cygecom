const getUserStorageItem = (itemName) => {
    const storageItem = $.fn.getStorageItem(itemName);
    if(!storageItem) {
        return;
    }

    return storageItem[$.fn.getUserIdLogged()];
};
const getStorageKey = (dataTable) => 'search-bar-memory-' + $(dataTable).attr('id') + location.pathname;

const setStorageDtSearchBar = (storageTableName, columnIndex, inputValue) =>{
    const userId = $.fn.getUserIdLogged();
    const storageItem = $.fn.getStorageItem(storageTableName) || {};
    const loggedUserStorage = getUserStorageItem(storageTableName);
    if(!loggedUserStorage) {
        const userSearchPreference = {
            userId: userId,
            columns: [{ idx: columnIndex, inputValue: inputValue }]
        };

        storageItem[userId] = userSearchPreference;
        $.fn.saveOnStorage(storageTableName, storageItem);
        return;
    }

    const columnIdxPreference = loggedUserStorage.columns.find((element) => element.idx === columnIndex);
    if(columnIdxPreference) {
        columnIdxPreference.inputValue = inputValue;
    } else {
        loggedUserStorage.columns.push({idx: columnIndex, inputValue: inputValue});
    }

    storageItem[userId] = loggedUserStorage;

    $.fn.saveOnStorage(storageTableName, storageItem);
}

const setSearchBarOnDt = (dataTable) =>{
    const storageTableName = getStorageKey(dataTable);
    const loggedUserStorage = getUserStorageItem(storageTableName);

    dataTable.api().columns().every(function (columnIndex) {
        const column = this;

        const isIgnoredColumn = column.header().classList.contains('ignore-search');
        if(isIgnoredColumn) {
            return;
        }

        const inputConfig = { width: '100%', placeholder: 'Buscar', }

        const columnIdxPreference = loggedUserStorage?.columns.find((element) => element.idx === columnIndex);
        if(columnIdxPreference) {
            inputConfig.value = columnIdxPreference.inputValue;
        }

        const $input = $('<input>', inputConfig);
        $input.addClass('search-button').addClass('form-control');

        const headerElement = column.header();
        headerElement.appendChild($input[0]);

        $input.on('click', (event) => event.stopPropagation());

        let timeoutId;
        $input.on('keyup', (event) => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                if (column.search() !== $input.val()) {
                    setStorageDtSearchBar(storageTableName, columnIndex, $input.val());
                    column.search($input.val()).draw();
                }
            }, 300);
        });
    });
}

export {setSearchBarOnDt, setStorageDtSearchBar};
