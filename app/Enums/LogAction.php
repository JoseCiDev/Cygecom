<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum LogAction: string implements EnumInterface
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::CREATE => 'Criado',
            self::UPDATE => 'Atualizado',
            self::DELETE => 'Excluído',
            default => '---',
        };
    }
}
