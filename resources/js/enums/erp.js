const ERP = {
    CALLISTO: 'callisto',
    SENIOR: 'senior',

    label(value) {
        return this.getLabel(value);
    },

    getLabel(value) {
        switch (value) {
            case ERP.CALLISTO:
                return 'Callisto';
            case ERP.SENIOR:
                return 'Senior';
            default:
                return '---';
        }
    },
};

export default ERP;
