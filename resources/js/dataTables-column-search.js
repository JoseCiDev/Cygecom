const setStorageDtSearchBar = (storageTableName, columnIndex, inputValue) =>{
    const searchBarStorage = JSON.parse(localStorage.getItem(storageTableName)) || [];
    searchBarStorage[columnIndex] = { value: inputValue };
    localStorage.setItem(storageTableName, JSON.stringify(searchBarStorage));
}


const setSearchBarOnDt = (dataTable) =>{
    const storageTableName = 'search-bar-memory-' + $(dataTable).attr('id') + location.pathname;
    const searchBarStorage = JSON.parse(localStorage.getItem(storageTableName)) || [];

    dataTable.api().columns().every(function (columnIndex) {
        const column = this;

        const isIgnoredColumn = column.header().classList.contains('ignore-search');
        if(isIgnoredColumn) {
            return;
        }

        const inputConfig = { width: '100%', placeholder: 'Buscar', }

        const searchBarMemory = searchBarStorage[columnIndex];
        if(searchBarMemory) {
            inputConfig.value = searchBarMemory.value;
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
