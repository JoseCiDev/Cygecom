<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum CompanyGroup: string implements EnumInterface
{
    case HKM = 'hkm';
    case INP = 'inp';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::HKM => 'HKM',
            self::INP => 'INP',
            default => '---',
        };
    }
}
