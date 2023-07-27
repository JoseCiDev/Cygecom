<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateCompanies extends Seeder
{
    public function run(): void
    {
        $companies = [
            //suprimentos_hkm
            ['corporate_name' => 'SMART MATRIZ', 'cnpj' => '11847299000130', 'group' => 'hkm'],
            ['corporate_name' => 'SMART FILIA 1', 'cnpj' => '11847299000211', 'group' => 'hkm'],
            ['corporate_name' => 'SMART FILIA 2', 'cnpj' => '11847299000300', 'group' => 'hkm'],
            ['corporate_name' => 'HKM  FARMÁCIA DE MANIPULAÇÃO', 'cnpj' => '06354562000110', 'group' => 'hkm'],
            ['corporate_name' => 'KLQ SOLUÇÕES TECNOLÓGICAS', 'cnpj' => '134600406000127', 'group' => 'hkm'],
            ['corporate_name' => 'JML ENTERPRISES BRASIL', 'cnpj' => '41869107000158', 'group' => 'hkm'],
            ['corporate_name' => 'RSHD CENTRO DE EVENTOS', 'cnpj' => '49307303000140', 'group' => 'hkm'],
            ['corporate_name' => 'CGE ADMINISTRADORA DE BENS LTDA', 'cnpj' => '49582758000174', 'group' => 'hkm'],
            ['corporate_name' => 'SHF PARTICIPAÇÕES', 'cnpj' => '26616618000162', 'group' => 'hkm'],
            ['corporate_name' => 'INSTITUTO HADI', 'cnpj' => '10242045000126', 'group' => 'hkm'],
            ['corporate_name' => 'MTN EMPREENDIMENTOS LTDA', 'cnpj' => '43659893000194', 'group' => 'hkm'],

            //suprimentos_inp
            ['corporate_name' => 'INP MATRIZ', 'cnpj' => '17979609000157', 'group' => 'inp'],
            ['corporate_name' => 'INP FILIAL PALHOÇA ATRIUM', 'cnpj' => '17979609000238', 'group' => 'inp'],
            ['corporate_name' => 'INP FILIAL SP (QG)', 'cnpj' => '17979609000319', 'group' => 'inp'],
            ['corporate_name' => 'INP FILIAL SÃO JOSÉ - ELAN VITAE', 'cnpj' => '17979609000408', 'group' => 'inp'],
            ['corporate_name' => 'INP FILIAL SP - CLÍNICA', 'cnpj' => '17979609000580', 'group' => 'inp'],
            ['corporate_name' => 'GHN COMÉRCIO VAREJISTA EM E-COMMERCE LTDA', 'cnpj' => '32295954000165', 'group' => 'inp'],
            ['corporate_name' => 'NOORSKIN INDÚSTRIA DE COSMÉTICOS LTDA', 'cnpj' => '49315512000109', 'group' => 'inp'],
            ['corporate_name' => 'OASIS IMPORTAÇÃO E EXPORTAÇÃO DE INSUMOS FARMACEUTICOS', 'cnpj' => '24681127000170', 'group' => 'inp'],
        ];

        DB::table('companies')->insert($companies);
    }
}
