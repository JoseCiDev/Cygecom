const PaymentTerm = {
    ANTICIPATED: 'anticipated',
    IN_CASH: 'in_cash',
    INSTALLMENT: 'installment',

    label(value) {
        return this.getLabel(value);
    },

    getLabel(value) {
        switch (value) {
            case this.ANTICIPATED:
                return 'Antecipado';
            case this.IN_CASH:
                return 'À vista';
            case this.INSTALLMENT:
                return 'Parcelado';
            default:
                return '---';
        }
    },
};

export default PaymentTerm;
