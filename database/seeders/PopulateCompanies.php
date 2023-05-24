<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateCompanies extends Seeder
{
    public function run(): void
    {
        $companies = [
            ['corporate_name' => 'HKM FARMACIA DE MANIPULACAO LTDA'],
            ['corporate_name' => 'INSTITUTO HADI'],
            ['corporate_name' => 'SMART MATRIZ'],
            ['corporate_name' => 'SMART FILIA 1'],
            ['corporate_name' => 'SMART FILIA 2'],
            ['corporate_name' => 'OASIS IMPORTAÇÃO E EXPORTAÇÃO DE INSUMOS FARMACÊUTICOS'],
            ['corporate_name' => 'SHF PARTICIPAÇÕES'],
            ['corporate_name' => 'GHN COMÉRCIO VAREJISTA EM E-COMMERCE LTDA'],
            ['corporate_name' => 'KLQ SOLUÇÕES TECNOLÓGICAS'],
            ['corporate_name' => 'JML ENTERPRISES BRASIL'],
            ['corporate_name' => 'MTN EMPREENDIMENTOS LTDA'],
            ['corporate_name' => 'RSHD CENTRO DE EVENTOS'],
            ['corporate_name' => 'NOORSKIN INDÚSTRIA DE COSMÉTICOS'],
            ['corporate_name' => 'CGE ADMINISTRADORA DE BENS LTDA'],
            ['corporate_name' => 'INP MATRIZ'],
            ['corporate_name' => 'INP FILIAL PALHOÇA ATRIUM'],
            ['corporate_name' => 'INP FILIAL SP (QG)'],
            ['corporate_name' => 'INP FILIAL SÃO JOSÉ - ELAN VITAE'],
            ['corporate_name' => 'INP MATRIZ SP - CLÍNICA'],
        ];

        DB::table('companies')->insert($companies);
    }
}
