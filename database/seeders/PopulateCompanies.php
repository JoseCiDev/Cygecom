<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateCompanies extends Seeder
{
    public function run(): void
    {
        $companies = [
            // suprimentos_hkm
            ['corporate_name' => 'HKM FARMACIA DE MANIPULACAO LTDA', 'name' => 'HKM', 'cnpj' => '06354562000110', 'group' => 'hkm'],
            ['corporate_name' => 'SMART SOLUCOES FARMACEUTICAS LTDA', 'name' => 'SMART MATRIZ', 'cnpj' => '11847299000130', 'group' => 'hkm'],
            ['corporate_name' => 'SMART SOLUCOES FARMACEUTICAS LTDA FILIAL', 'name' => 'SMART FILIAL 1', 'cnpj' => '11847299000211', 'group' => 'hkm'],
            ['corporate_name' => 'SMART SOLUCOES FARMACEUTICAS LTDA FILIAL 2', 'name' => 'SMART FILIAL 2', 'cnpj' => '11847299000300', 'group' => 'hkm'],
            ['corporate_name' => 'KLQ SOLUCOES TECNOLOGICAS LTDA', 'name' => 'KLQ TECHNOLOGIES', 'cnpj' => '34600406000127', 'group' => 'hkm'],
            ['corporate_name' => 'JML ENTERPRISES BRASIL LTDA', 'name' => 'JML', 'cnpj' => '41869107000158', 'group' => 'hkm'],
            ['corporate_name' => 'RSHD CENTRO DE EVENTOS LTDA', 'name' => 'RSHD', 'cnpj' => '49307303000140', 'group' => 'hkm'],
            ['corporate_name' => 'CGE ADMINISTRADORA DE BENS LTDA', 'name' => 'CGE', 'cnpj' => '49582758000174', 'group' => 'hkm'],
            ['corporate_name' => 'SHF PARTICIPACOES LTDA', 'name' => 'SHF', 'cnpj' => '29616618000162', 'group' => 'hkm'],
            ['corporate_name' => 'MTN EMPREENDIMENTOS LTDA', 'name' => 'MTN', 'cnpj' => '43659893000194', 'group' => 'hkm'],

            //suprimentos_inp
            ['corporate_name' => 'INP INDUSTRIA DE ALIMENTOS LTDA', 'name' => 'INP MATRIZ', 'cnpj' => '17979609000157', 'group' => 'inp'],
            ['corporate_name' => 'INP INDUSTRIA DE ALIMENTOS LTDA - FILIAL ATRIUM', 'name' => 'INP FILIAL - ATRIUM', 'cnpj' => '17979609000238', 'group' => 'inp'],
            ['corporate_name' => 'INP INDUSTRIA DE ALIMENTOS LTDA - FILIAL QG', 'name' => 'INP FILIAL - QG SP', 'cnpj' => '17979609000319', 'group' => 'inp'],
            ['corporate_name' => 'INP INDUSTRIA DE ALIMENTOS LTDA - FILIAL ELAN VITAE', 'name' => 'INP FILIAL - ELAN VITAE', 'cnpj' => '17979609000408', 'group' => 'inp'],
            ['corporate_name' => 'INP INDUSTRIA DE ALIMENTOS LTDA - FILIAL CLÍNICA SP', 'name' => 'INP FILIAL - CLÍNICA SP', 'cnpj' => '17979609000580', 'group' => 'inp'],
            ['corporate_name' => 'NOORSKIN INDUSTRIA DE COSMETICOS LTDA', 'name' => 'NOORSKIN', 'cnpj' => '49315502000109', 'group' => 'inp'],
            ['corporate_name' => 'GHN COMERCIO VAREJISTA EM E-COMMERCE LTDA', 'name' => 'SITE NOORSKIN', 'cnpj' => '32295954000165', 'group' => 'inp'],
            ['corporate_name' => 'OASIS IMPORTACAO E EXPORTACAO DE INSUMOS FARMACEUTICOS', 'name' => 'OASIS', 'cnpj' => '24681129000170', 'group' => 'inp'],
        ];

        DB::table('companies')->insert($companies);
    }
}
