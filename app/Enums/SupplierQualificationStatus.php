<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum SupplierQualificationStatus: string implements EnumInterface
{
    case EM_ANALISE = 'em_analise';
    case QUALIFICADO = 'qualificado';
    case NAO_QUALIFICADO = 'nao_qualificado';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::EM_ANALISE => 'Em análise',
            self::QUALIFICADO => 'Qualificado',
            self::NAO_QUALIFICADO => 'Não qualificado',
            default => '---',
        };
    }
}
