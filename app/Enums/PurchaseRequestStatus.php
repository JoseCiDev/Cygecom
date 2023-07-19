<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum PurchaseRequestStatus: string implements EnumInterface
{
    case PENDING     = 'pending';
    case APPROVED    = 'approved';
    case DISAPPROVED = 'disapproved';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::PENDING     => 'Pendente',
            self::APPROVED    => 'Aprovado',
            self::DISAPPROVED => 'Desaprovado',
            default           => '---',
        };
    }
}
