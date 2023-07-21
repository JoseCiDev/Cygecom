<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum PurchaseRequestStatus: string implements EnumInterface
{
    case PENDENTE = 'pendente';
    case EM_TRATATIVA = 'em_tratativa';
    case EM_COTACAO = 'em_cotacao';
    case AGUARDANDO_APROVACAO_DE_COMPRA = 'aguardando_aprovacao_de_compra';
    case COMPRA_EFETUADA = 'compra_efetuada';
    case FINALIZADA = 'finalizada';
    case CANCELADA = 'cancelada';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::PENDENTE => 'Pendente',
            self::EM_TRATATIVA => 'Aprovado',
            self::EM_COTACAO => 'Desaprovado',
            self::AGUARDANDO_APROVACAO_DE_COMPRA => 'Aguardando aprovação de compra',
            self::COMPRA_EFETUADA => 'Compra efetuada',
            self::FINALIZADA => 'Finalizada',
            self::CANCELADA => 'Cancelada',
            default => '---',
        };
    }
}
