const PaymentMethod = {
    BOLETO: 'boleto',
    CARTAO_CREDITO: 'cartao_credito',
    CARTAO_DEBITO: 'cartao_debito',
    CHEQUE: 'cheque',
    DEPOSITO_BANCARIO: 'deposito_bancario',
    DINHEIRO: 'dinheiro',
    INTERNACIONAL: 'internacional',
    PIX: 'pix',

    label(value) {
        return this.getLabel(value);
    },

    getLabel(value) {
        switch (value) {
            case this.BOLETO:
                return 'Boleto';
            case this.CARTAO_CREDITO:
                return 'Cartão de crédito';
            case this.CARTAO_DEBITO:
                return 'Cartão de débito';
            case this.CHEQUE:
                return 'Cheque';
            case this.DEPOSITO_BANCARIO:
                return 'Depósito bancário';
            case this.DINHEIRO:
                return 'Dinheiro';
            case this.INTERNACIONAL:
                return 'Internacional';
            case this.PIX:
                return 'Pix';
            default:
                return '---';
        }
    },
};

export default PaymentMethod;
