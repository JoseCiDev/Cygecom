const LogAction = {
    CREATE: 'create',
    UPDATE: 'update',
    DELETE: 'delete',

    label(value) {
        return this.getLabel(value);
    },

    getLabel(value) {
        switch (value) {
            case this.CREATE:
                return 'Criado';
            case this.UPDATE:
                return 'Atualizado';
            case this.DELETE:
                return 'Excluído';
            default:
                return '---';
        }
    },
};

export default LogAction;
