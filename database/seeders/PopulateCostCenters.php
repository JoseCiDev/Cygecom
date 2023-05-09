<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateCostCenters extends Seeder
{
    public function run(): void
    {
        $costCenters = [
            ['name' => 'Almoxarifado'],
            ['name' => 'Administrativo (setor terro HKM)'],
            ['name' => 'Conferencia de entrada'],
            ['name' => 'Conferencia de Saida'],
            ['name' => 'Congressos e Eventos'],
            ['name' => 'Comercial Injetáveis'],
            ['name' => 'Controladoria'],
            ['name' => 'Diretoria'],
            ['name' => 'Diretoria de Produção'],
            ['name' => 'Diretoria Vendas e Marketing'],
            ['name' => 'Departamento Pessoal'],
            ['name' => 'Diretoria DDH'],
            ['name' => 'Diretoria Administrativo'],
            ['name' => 'Diretoria de Tecnologia'],
            ['name' => 'Diretoria financeira'],
            ['name' => 'DDH'],
            ['name' => 'Expedição'],
            ['name' => 'Endomarketing'],
            ['name' => 'Faturamento/Caixa'],
            ['name' => 'Inclusão'],
            ['name' => 'Infraestrutura e Telecom'],
            ['name' => 'Lab. Injetáveis'],
            ['name' => 'Lab. Hormonios'],
            ['name' => 'Lab. Liquidos'],
            ['name' => 'Lab. Solidos'],
            ['name' => 'Limpeza'],
            ['name' => 'Material Aplicado'],
            ['name' => 'Manutenção'],
            ['name' => 'P&D'],
            ['name' => 'Qualidade'],
            ['name' => 'Revenda'],
            ['name' => 'Recepção'],
            ['name' => 'Receitas para Vendas'],
            ['name' => 'Recursos Humanos'],
            ['name' => 'Segurança do Trabalho'],
            ['name' => 'Suprimentos'],
            ['name' => 'Tele Atendimento'],
            ['name' => 'Technologies'],
            ['name' => 'Tritutário'],
            ['name' => 'Visitação'],
        ];

        foreach ($costCenters as $costCenter) {
            DB::table('cost_centers')->insert($costCenter);
        }
    }
}
