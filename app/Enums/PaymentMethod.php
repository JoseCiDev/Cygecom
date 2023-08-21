<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum PaymentMethod: string implements EnumInterface
{
    case BOLETO = 'boleto';
    case CARTAO_CREDITO = 'cartao_credito';
    case CARTAO_DEBITO = 'cartao_debito';
    case CHEQUE = 'cheque';
    case DEPOSITO_BANCARIO = 'deposito_bancario';
    case DINHEIRO = 'dinheiro';
    case INTERNACIONAL = 'internacional';
    case PIX = 'pix';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::BOLETO => 'Boleto',
            self::CARTAO_CREDITO => 'Cartão de crédito',
            self::CARTAO_DEBITO => 'Cartão de débito',
            self::CHEQUE => 'Cheque',
            self::DEPOSITO_BANCARIO => 'Depósito bancário',
            self::DINHEIRO => 'Dinheiro',
            self::INTERNACIONAL => 'Internacional',
            self::PIX => 'Pix',
        };
    }
}
