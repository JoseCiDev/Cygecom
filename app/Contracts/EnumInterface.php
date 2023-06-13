<?php

namespace App\Contracts;

interface EnumInterface
{
    public function label(): string;

    public static function getLabel($value): string;
}
