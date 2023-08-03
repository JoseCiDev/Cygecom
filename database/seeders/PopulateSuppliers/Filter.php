<?php

namespace Database\Seeders\PopulateSuppliers;

use App\Providers\ValidatorService;
use Exception;

class Filter
{
    public function __construct(private ValidatorService $validatorService)
    {
    }

    public function filter($suppliers)
    {
        $filteredSuppliers = [];
        $existingCorporateNames = [];

        if (!is_array($suppliers) || empty($suppliers)) {
            throw new Exception('O array de fornecedores está vazio ou não foi encontrado no arquivo importado.');
        }

        foreach ($suppliers as $supplier) {
            $cnpj = str_pad($supplier['cpf_cnpj'], 14, '0', STR_PAD_LEFT);
            $isValidCnpj = $this->validateCnpj($cnpj);
            $isDuplicate = in_array($supplier['corporate_name'], $existingCorporateNames);
            $validator = $this->validatorService->supplier($supplier);
            $isValidPhoneNumber = strlen($supplier['number']) <= 15;
            if (!$isValidCnpj || $isDuplicate || !$isValidPhoneNumber || $validator->fails()) {
                continue;
            }

            $supplier['cpf_cnpj'] = $cnpj;
            $supplier['qualification'] = 'qualificado';
            $filteredSuppliers[] = $supplier;

            $existingCorporateNames[] = $supplier['corporate_name'];
        }

        return $filteredSuppliers;
    }

    private function validateCnpj(string $cnpj): bool
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

        return $cnpj[12] == $digit1 && $cnpj[13] == $digit2;
    }
}
