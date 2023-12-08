<?php

namespace App\Enums;

use App\Contracts\EnumInterface;

enum MainProfile: string implements EnumInterface
{
    case ADMIN = 'admin';
    case NORMAL = 'normal';
    case SUPRIMENTOS_INP = 'suprimentos_inp';
    case SUPRIMENTOS_HKM = 'suprimentos_hkm';
    case GESTOR_USUARIOS = 'gestor_usuarios';
    case GESTOR_FORNECEDORES = 'gestor_fornecedores';
    case DIRETOR = 'diretor';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel($value): string
    {
        return match ($value) {
            self::ADMIN => 'Administrador',
            self::NORMAL => 'Normal',
            self::SUPRIMENTOS_INP => 'Suprimentos INP',
            self::SUPRIMENTOS_HKM => 'Suprimentos HKM',
            self::GESTOR_USUARIOS => 'Gestor de usuários',
            self::GESTOR_FORNECEDORES => 'Gestor de fornecedores',
            self::DIRETOR => 'Diretor',
            default => '---',
        };
    }
}
