const CompanyGroup = {
    HKM: 'hkm',
    INP: 'inp',

    label(value) {
        return this.getLabel(value);
    },

    getLabel(value) {
        switch (value) {
            case this.HKM:
                return 'HKM';
            case this.INP:
                return 'INP';
            default:
                return '---';
        }
    },
};

export default CompanyGroup;
