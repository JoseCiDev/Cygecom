<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum ContractRecurrence: string implements EnumInterface
{
    case ANUAL = 'yearly';
    case MENSAL = 'monthly';
    case ÚNICA = 'unique';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::ANUAL => 'Anual',
            self::MENSAL => 'Mensal',
            self::ÚNICA => 'Única',
            default => '---',
        };
    }
}
