<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum PaymentMethod: string implements EnumInterface
{
    case PIX  = 'pix';
    case BOLETO  = 'boleto';
    case CHEQUE  = 'cheque';
    case DINHEIRO = 'dinheiro';
    case DEPOSITO_BANCARIO = 'deposito_bancario';
    case CARTAO_CREDITO  = 'cartao_credito';
    case CARTAO_DEBITO  = 'cartao_debito';


    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::PIX  => 'Pix',
            self::BOLETO  => 'Boleto',
            self::CHEQUE  => 'Cheque',
            self::DINHEIRO => 'Dinheiro',
            self::DEPOSITO_BANCARIO => 'Depósito bancário',
            self::CARTAO_CREDITO => 'Cartão de crédito',
            self::CARTAO_DEBITO => 'Cartão de débito',
        };
    }
}
