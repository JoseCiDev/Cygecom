<?php

namespace Database\Seeders\Inserts\Data;

use Exception;
use App\Contracts\DataToInsertInterface;

class CompaniesToInsert implements DataToInsertInterface
{
    private static function validateCnpj(string $cnpj): string|Exception
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($cnpj) !== 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $sum = 0;
        $weights1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $weights1[$i];
        }

        $digit1 = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);

        $sum = 0;
        $weights2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $weights2[$i];
        }

        $digit2 = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);

        $isValid = $cnpj[12] == $digit1 && $cnpj[13] == $digit2;

        if (!$isValid) {
            $message = "CNPJ inválido! [$cnpj]";
            throw new Exception($message);
        }

        return $cnpj;
    }

    public static function getArray(): array
    {
        return [
            [
                'id' => 19,
                'corporate_name' => 'HUMAM QUEST CLINICS',
                'cnpj' => self::validateCnpj('35071408000139'),
                'group' => 'hkm',
                'name' => 'Humam Quest',
            ],
            [
                'id' => 20,
                'corporate_name' => 'SARACENI SERVIÇOS DE ARQUITETURA',
                'cnpj' => self::validateCnpj('52164768000102'),
                'group' => 'hkm',
                'name' => 'Saraceni Serviços de arquitetura',
            ],
        ];
    }
}
