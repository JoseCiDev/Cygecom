<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum PaymentTerm: string implements EnumInterface
{
    case ANTICIPATED  = 'anticipated';
    case IN_CASH  = 'in_cash';
    case INSTALLMENT  = 'installment';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::ANTICIPATED  => 'Antecipado',
            self::IN_CASH  => 'À vista',
            self::INSTALLMENT  => 'Parcelado',
        };
    }
}
