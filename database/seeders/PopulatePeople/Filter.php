<?php

namespace Database\Seeders\PopulatePeople;

use Exception;

class Filter
{
    public function filter($people)
    {
        $filteredPeople = [];
        $existingCPFs = [];

        if (!is_array($people) || empty($people)) {
            throw new Exception('O array de colaboradores está vazio ou não foi encontrado no arquivo importado.');
        }

        foreach ($people as $person) {
            $cpf = $person['cpf_cnpj'];
            $isDuplicate = in_array($person['cpf_cnpj'], $existingCPFs);
            $isValidCPF = strlen($cpf) === 14;

            if ($isDuplicate || !$isValidCPF) {
                continue;
            }

            $person['cpf_cnpj'] = $cpf;
            $filteredPeople[] = $person;
            $existingCPFs[] = $person['cpf_cnpj'];
        }

        return $filteredPeople;
    }
}
