<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateCostCenters extends Seeder
{
    public function run(): void
    {
        $costCenters = [
            ['name' => 'Administrativo (setor terro HKM)', 'companies_id' => 1],
            ['name' => 'Almoxarifado', 'companies_id' => 1],
            ['name' => 'Arquitetura', 'companies_id' => 1],
            ['name' => 'Atendimento E-Commerce e SAC', 'companies_id' => 1],
            ['name' => 'Atendimento Site', 'companies_id' => 1],
            ['name' => 'Be Generous', 'companies_id' => 1],
            ['name' => 'Central de Notas', 'companies_id' => 1],
            ['name' => 'Comercial Injetáveis', 'companies_id' => 1],
            ['name' => 'Comercial Injetáveis // Vendas', 'companies_id' => 1],
            ['name' => 'Congressos e Eventos', 'companies_id' => 1],
            ['name' => 'Conferencia de entrada', 'companies_id' => 1],
            ['name' => 'Conferencia de Saida', 'companies_id' => 1],
            ['name' => 'Controladoria', 'companies_id' => 1],
            ['name' => 'Departamento Pessoal', 'companies_id' => 1],
            ['name' => 'DDH', 'companies_id' => 1],
            ['name' => 'Diretoria', 'companies_id' => 1],
            ['name' => 'Diretoria Administrativo', 'companies_id' => 1],
            ['name' => 'Diretoria Controladoria', 'companies_id' => 1],
            ['name' => 'Diretoria DDH', 'companies_id' => 1],
            ['name' => 'Diretoria de Produção', 'companies_id' => 1],
            ['name' => 'Diretoria de Tecnologia', 'companies_id' => 1],
            ['name' => 'Diretoria financeira', 'companies_id' => 1],
            ['name' => 'Diretoria Tributário/Central de Notas', 'companies_id' => 1],
            ['name' => 'Diretoria Vendas e Marketing', 'companies_id' => 1],
            ['name' => 'EAD', 'companies_id' => 1],
            ['name' => 'Endomarketing', 'companies_id' => 1],
            ['name' => 'ERP', 'companies_id' => 1],
            ['name' => 'Expedição', 'companies_id' => 1],
            ['name' => 'Faturamento', 'companies_id' => 1],
            ['name' => 'Faturamento/Caixa', 'companies_id' => 1],
            ['name' => 'Financeiro', 'companies_id' => 1],
            ['name' => 'Gerência de Produção', 'companies_id' => 1],
            ['name' => 'Infraestrutura e Telecom', 'companies_id' => 1],
            ['name' => 'Inclusão', 'companies_id' => 1],
            ['name' => 'Inteligência de Negócio', 'companies_id' => 1],
            ['name' => 'Internacional', 'companies_id' => 1],
            ['name' => 'Laboratório Hormônios', 'companies_id' => 1],
            ['name' => 'Laboratório Injetáveis', 'companies_id' => 1],
            ['name' => 'Laboratório Líquidos', 'companies_id' => 1],
            ['name' => 'Laboratório Sólidos', 'companies_id' => 1],
            ['name' => 'Limpeza', 'companies_id' => 1],
            ['name' => 'Manutenção', 'companies_id' => 1],
            ['name' => 'Marketing', 'companies_id' => 1],
            ['name' => 'Material Aplicado', 'companies_id' => 1],
            ['name' => 'Noorskin', 'companies_id' => 1],
            ['name' => 'Novos Projetos', 'companies_id' => 1],
            ['name' => 'P&D', 'companies_id' => 1],
            ['name' => 'Pesquisa e Desenvolvidor P&D', 'companies_id' => 1],
            ['name' => 'Planejamento de Produção PCP', 'companies_id' => 1],
            ['name' => 'Produção - Ensacadora', 'companies_id' => 1],
            ['name' => 'Produção Encartuchamento', 'companies_id' => 1],
            ['name' => 'Produção Envase e Rotulagem', 'companies_id' => 1],
            ['name' => 'Produção Moinho', 'companies_id' => 1],
            ['name' => 'Produção Pesagem e Mistura', 'companies_id' => 1],
            ['name' => 'Qualidade', 'companies_id' => 1],
            ['name' => 'Recepção', 'companies_id' => 1],
            ['name' => 'Receitas para Vendas', 'companies_id' => 1],
            ['name' => 'Recursos Humanos', 'companies_id' => 1],
            ['name' => 'Revenda', 'companies_id' => 1],
            ['name' => 'Sac', 'companies_id' => 1],
            ['name' => 'Segurança do Trabalho', 'companies_id' => 1],
            ['name' => 'Software e Sistemas', 'companies_id' => 1],
            ['name' => 'Suprimentos', 'companies_id' => 1],
            ['name' => 'Tele Atendimento', 'companies_id' => 1],
            ['name' => 'Technologies', 'companies_id' => 1],
            ['name' => 'T.I. Technologies', 'companies_id' => 1],
            ['name' => 'Trade Marketing', 'companies_id' => 1],
            ['name' => 'Tributário', 'companies_id' => 1],
            ['name' => 'Tritutário', 'companies_id' => 1],
            ['name' => 'Visitação', 'companies_id' => 1],
        ];

        foreach ($costCenters as $costCenter) {
            DB::table('cost_centers')->insert($costCenter);
        }
    }
}
