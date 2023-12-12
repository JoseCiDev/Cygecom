const PurchaseRequestStatus = {
    RASCUNHO: 'rascunho',
    PENDENTE: 'pendente',
    EM_TRATATIVA: 'em_tratativa',
    EM_COTACAO: 'em_cotacao',
    AGUARDANDO_APROVACAO_DE_COMPRA: 'aguardando_aprovacao_de_compra',
    COMPRA_EFETUADA: 'compra_efetuada',
    FINALIZADA: 'finalizada',
    CANCELADA: 'cancelada',

    label(value) {
        return this.getLabel(value);
    },

    getLabel(value) {
        switch (value) {
            case this.RASCUNHO:
                return 'Rascunho';
            case this.PENDENTE:
                return 'Pendente';
            case this.EM_TRATATIVA:
                return 'Em tratativa';
            case this.EM_COTACAO:
                return 'Em cotação';
            case this.AGUARDANDO_APROVACAO_DE_COMPRA:
                return 'Aguardando aprovação de compra';
            case this.COMPRA_EFETUADA:
                return 'Compra efetuada';
            case this.FINALIZADA:
                return 'Finalizada';
            case this.CANCELADA:
                return 'Cancelada';
            default:
                return '---';
        }
    },
};

export default PurchaseRequestStatus;
