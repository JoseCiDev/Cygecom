const PurchaseRequestType = {
    SERVICE: 'service',
    PRODUCT: 'product',
    CONTRACT: 'contract',

    label(value) {
        return this.getLabel(value);
    },

    getLabel(value) {
        switch (value) {
            case this.SERVICE:
                return 'Serviço pontual';
            case this.PRODUCT:
                return 'Produto';
            case this.CONTRACT:
                return 'Serviço recorrente';
            default:
                return '---';
        }
    },
};

export default PurchaseRequestType;
