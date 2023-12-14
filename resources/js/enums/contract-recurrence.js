const ContractRecurrence = {
    ANUAL: 'yearly',
    MENSAL: 'monthly',
    ÚNICA: 'unique',

    label(value) {
        return this.getLabel(value);
    },

    getLabel(value) {
        switch (value) {
            case this.ANUAL:
                return 'Anual';
            case this.MENSAL:
                return 'Mensal';
            case this.ÚNICA:
                return 'Única';
            default:
                return '---';
        }
    },
};

export default ContractRecurrence;
