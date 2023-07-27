<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateCostCenters extends Seeder
{
    public function run(): void
    {
        $costCenters = [
            ['name' => 'Administrativo (setor terro HKM)', 'company_id' => 1, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Almoxarifado', 'company_id' => 1, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Arquitetura', 'company_id' => 2, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Atendimento E-Commerce e SAC', 'company_id' => 2, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Atendimento Site', 'company_id' => 3, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Be Generous', 'company_id' => 3, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Central de Notas', 'company_id' => 4, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Comercial Injetáveis', 'company_id' => 4, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Comercial Injetáveis // Vendas', 'company_id' => 5, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Congressos e Eventos', 'company_id' => 5, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Conferencia de entrada', 'company_id' => 6, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Conferencia de Saida', 'company_id' => 6, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Controladoria', 'company_id' => 7, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Departamento Pessoal', 'company_id' => 7, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'DDH', 'company_id' => 8, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Diretoria', 'company_id' => 8, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Diretoria Administrativo', 'company_id' => 9, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Diretoria Controladoria', 'company_id' => 9, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Diretoria DDH', 'company_id' => 10, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Diretoria de Produção', 'company_id' => 10, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Diretoria de Tecnologia', 'company_id' => 11, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Diretoria financeira', 'company_id' => 11, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Diretoria Tributário/Central de Notas', 'company_id' => 12, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Diretoria Vendas e Marketing', 'company_id' => 12, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'EAD', 'company_id' => 13, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Endomarketing', 'company_id' => 13, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'ERP', 'company_id' => 14, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Expedição', 'company_id' => 14, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Faturamento', 'company_id' => 15, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Faturamento/Caixa', 'company_id' => 15, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Financeiro', 'company_id' => 16, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Gerência de Produção', 'company_id' => 16, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Infraestrutura e Telecom', 'company_id' => 17, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Inclusão', 'company_id' => 17, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Inteligência de Negócio', 'company_id' => 18, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Internacional', 'company_id' => 18, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Laboratório Hormônios', 'company_id' => 19, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Laboratório Injetáveis', 'company_id' => 19, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Laboratório Líquidos', 'company_id' => 1, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Laboratório Sólidos', 'company_id' => 1, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Limpeza', 'company_id' => 2, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Manutenção', 'company_id' => 2, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Marketing', 'company_id' => 3, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Material Aplicado', 'company_id' => 3, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Noorskin', 'company_id' => 4, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Novos Projetos', 'company_id' => 4, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'P&D', 'company_id' => 5, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Pesquisa e Desenvolvidor P&D', 'company_id' => 5, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Planejamento de Produção PCP', 'company_id' => 6, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Produção - Ensacadora', 'company_id' => 6, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Produção Encartuchamento', 'company_id' => 7, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Produção Envase e Rotulagem', 'company_id' => 7, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Produção Moinho', 'company_id' => 8, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Produção Pesagem e Mistura', 'company_id' => 8, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Qualidade', 'company_id' => 9, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Recepção', 'company_id' => 9, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Receitas para Vendas', 'company_id' => 10, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Recursos Humanos', 'company_id' => 10, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Revenda', 'company_id' => 11, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Sac', 'company_id' => 11, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Segurança do Trabalho', 'company_id' => 12, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Software e Sistemas', 'company_id' => 12, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Suprimentos', 'company_id' => 13, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Tele Atendimento', 'company_id' => 13, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Technologies', 'company_id' => 14, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'T.I. Technologies', 'company_id' => 14, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Trade Marketing', 'company_id' => 15, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Tributário', 'company_id' => 15, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Tritutário', 'company_id' => 16, 'address_id' => 1, 'phone_id' => 1],
            ['name' => 'Visitação', 'company_id' => 16, 'address_id' => 1, 'phone_id' => 1],
        ];

        DB::table('cost_centers')->insert($costCenters);
    }
}
