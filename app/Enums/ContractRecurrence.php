<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum ContractRecurrence: string implements EnumInterface
{
    case UNIQUE     = 'unique';
    case MONTHLY    = 'monthly';
    case YEARLY = 'yearly';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::UNIQUE     => 'Única',
            self::MONTHLY    => 'Mensal',
            self::YEARLY => 'Anual',
            default           => '---',
        };
    }
}
