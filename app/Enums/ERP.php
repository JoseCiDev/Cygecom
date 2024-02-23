<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum ERP: string implements EnumInterface
{
    case CALLISTO = 'callisto';
    case SENIOR = 'senior';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::CALLISTO => 'Callisto',
            self::SENIOR => 'Senior',
            default => '---',
        };
    }
}
