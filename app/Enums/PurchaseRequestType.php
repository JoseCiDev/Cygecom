<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum PurchaseRequestType: string implements EnumInterface
{
    case SERVICE      = 'service';
    case PRODUCT     = 'product';
    case CONTRACT = 'contract';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::SERVICE      => 'Serviço',
            self::PRODUCT     => 'Produto',
            self::CONTRACT => 'Contrato',
            default               => '---',
        };
    }
}
