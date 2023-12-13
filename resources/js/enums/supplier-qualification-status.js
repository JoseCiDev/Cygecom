const SupplierQualificationStatus = {
    EM_ANALISE: 'em_analise',
    QUALIFICADO: 'qualificado',
    NAO_QUALIFICADO: 'nao_qualificado',

    label(value) {
        return this.getLabel(value);
    },

    getLabel(value) {
        switch (value) {
            case this.EM_ANALISE:
                return 'Em análise';
            case this.QUALIFICADO:
                return 'Qualificado';
            case this.NAO_QUALIFICADO:
                return 'Não qualificado';
            default:
                return '---';
        }
    },
};

export default SupplierQualificationStatus;
