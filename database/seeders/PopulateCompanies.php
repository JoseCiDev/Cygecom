<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateCompanies extends Seeder
{
    public function run(): void
    {
        $companies = [
            ['corporate_name' => 'HKM FARMACIA DE MANIPULACAO LTDA', 'cnpj' => '12.345.678/0001-00'],
            ['corporate_name' => 'INSTITUTO HADI', 'cnpj' => '12.345.678/0001-01'],
            ['corporate_name' => 'SMART MATRIZ', 'cnpj' => '12.345.678/0001-02'],
            ['corporate_name' => 'SMART FILIA 1', 'cnpj' => '12.345.678/0001-03'],
            ['corporate_name' => 'SMART FILIA 2', 'cnpj' => '12.345.678/0001-04'],
            ['corporate_name' => 'OASIS IMPORTAÇÃO E EXPORTAÇÃO DE INSUMOS FARMACÊUTICOS', 'cnpj' => '12.345.678/0001-05'],
            ['corporate_name' => 'SHF PARTICIPAÇÕES', 'cnpj' => '12.345.678/0001-06'],
            ['corporate_name' => 'GHN COMÉRCIO VAREJISTA EM E-COMMERCE LTDA', 'cnpj' => '12.345.678/0001-07'],
            ['corporate_name' => 'KLQ SOLUÇÕES TECNOLÓGICAS', 'cnpj' => '12.345.678/0001-08'],
            ['corporate_name' => 'JML ENTERPRISES BRASIL', 'cnpj' => '12.345.678/0001-09'],
            ['corporate_name' => 'MTN EMPREENDIMENTOS LTDA', 'cnpj' => '12.345.678/0001-10'],
            ['corporate_name' => 'RSHD CENTRO DE EVENTOS', 'cnpj' => '12.345.678/0001-18'],
            ['corporate_name' => 'NOORSKIN INDÚSTRIA DE COSMÉTICOS', 'cnpj' => '12.345.678/0001-11'],
            ['corporate_name' => 'CGE ADMINISTRADORA DE BENS LTDA', 'cnpj' => '12.345.678/0001-12'],
            ['corporate_name' => 'INP MATRIZ', 'cnpj' => '12.345.678/0001-13'],
            ['corporate_name' => 'INP FILIAL PALHOÇA ATRIUM', 'cnpj' => '12.345.678/0001-14'],
            ['corporate_name' => 'INP FILIAL SP (QG)', 'cnpj' => '12.345.678/0001-15'],
            ['corporate_name' => 'INP FILIAL SÃO JOSÉ - ELAN VITAE', 'cnpj' => '12.345.678/0001-16'],
            ['corporate_name' => 'INP MATRIZ SP - CLÍNICA', 'cnpj' => '12.345.678/0001-17'],
        ];

        DB::table('companies')->insert($companies);
    }
}
