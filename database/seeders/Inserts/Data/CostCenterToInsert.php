<?php

namespace Database\Seeders\Inserts\Data;

use Exception;
use App\Contracts\DataToInsertInterface;
use App\Models\Company;
use Illuminate\Support\Collection;

class CostCenterToInsert implements DataToInsertInterface
{
    private static function validate(Collection $corporateNames, Collection $ids): bool|Exception
    {
        $isEqualQtd = $corporateNames->count() === $ids->count();
        $isInt = $ids->contains(fn ($id) => is_int($id) && $id > 0);
        $invalidNames = $corporateNames->diff($ids->keys());

        $hasErrorName = !$isEqualQtd  || $ids->isEmpty() || !$isInt || $invalidNames->isNotEmpty();
        if ($hasErrorName) {
            $errorMessage = 'Houve um problema ao identificar os IDs das empresas. Verifique as seguintes razões sociais: ' . $corporateNames->implode(', ');
            throw new \Exception($errorMessage);
        }

        return true;
    }

    private static function getIds()
    {
        $corporateNames = collect(
            [
                'HUMAM QUEST CLINICS',
                'SARACENI SERVIÇOS DE ARQUITETURA',
                'INP INDUSTRIA DE ALIMENTOS LTDA - FILIAL ATRIUM'
            ]
        );

        $ids = Company::whereIn('corporate_name', $corporateNames)->pluck('id', 'corporate_name');

        self::validate($corporateNames, $ids);

        return $ids;
    }

    public static function getArray(): array
    {
        $ids = self::getIds();
        $IdHumanQL = $ids['HUMAM QUEST CLINICS'];
        $IdSaraceni = $ids['SARACENI SERVIÇOS DE ARQUITETURA'];
        $IdInpAtrium = $ids['INP INDUSTRIA DE ALIMENTOS LTDA - FILIAL ATRIUM'];

        return [
            ['id' => 728, 'name' => 'Limpeza', 'company_id' => $IdInpAtrium],

            // 'HUMAM QUEST CLINICS'
            ['id' => 729, 'name' => 'Revenda', 'company_id' => $IdHumanQL],
            ['id' => 730, 'name' => 'Almoxarifado', 'company_id' => $IdHumanQL],
            ['id' => 731, 'name' => 'Limpeza (produção)', 'company_id' => $IdHumanQL],
            ['id' => 732, 'name' => 'Manutenção (produção)', 'company_id' => $IdHumanQL],
            ['id' => 733, 'name' => 'Qualidade/Inativo', 'company_id' => $IdHumanQL],
            ['id' => 734, 'name' => 'Segurança do Trabalho/Inativo', 'company_id' => $IdHumanQL],
            ['id' => 735, 'name' => 'Noorskin', 'company_id' => $IdHumanQL],
            ['id' => 736, 'name' => 'Receitas para Vendas', 'company_id' => $IdHumanQL],
            ['id' => 737, 'name' => 'Atendimento E-Commerce e SAC', 'company_id' => $IdHumanQL],
            ['id' => 738, 'name' => 'Congressos e Eventos', 'company_id' => $IdHumanQL],
            ['id' => 739, 'name' => 'Diretoria Vendas e Marketing', 'company_id' => $IdHumanQL],
            ['id' => 740, 'name' => 'Expedição', 'company_id' => $IdHumanQL],
            ['id' => 741, 'name' => 'Marketing', 'company_id' => $IdHumanQL],
            ['id' => 742, 'name' => 'Recepção/Inativo', 'company_id' => $IdHumanQL],
            ['id' => 743, 'name' => 'Visitação', 'company_id' => $IdHumanQL],
            ['id' => 744, 'name' => 'Diretoria Administrativo', 'company_id' => $IdHumanQL],
            ['id' => 745, 'name' => 'Suprimentos', 'company_id' => $IdHumanQL],
            ['id' => 746, 'name' => 'Novos Projetos', 'company_id' => $IdHumanQL],
            ['id' => 747, 'name' => 'Diretoria', 'company_id' => $IdHumanQL],
            ['id' => 748, 'name' => 'Infraestrutura e Telecom', 'company_id' => $IdHumanQL],
            ['id' => 749, 'name' => 'TI Technologies', 'company_id' => $IdHumanQL],
            ['id' => 750, 'name' => 'DDH', 'company_id' => $IdHumanQL],
            ['id' => 751, 'name' => 'Financeiro', 'company_id' => $IdHumanQL],
            ['id' => 752, 'name' => 'Diretoria financeira', 'company_id' => $IdHumanQL],
            ['id' => 753, 'name' => 'Tributário', 'company_id' => $IdHumanQL],
            ['id' => 754, 'name' => 'Controladoria', 'company_id' => $IdHumanQL],
            ['id' => 755, 'name' => 'Faturamento', 'company_id' => $IdHumanQL],

            // SARACENI SERVIÇOS DE ARQUITETURA
            ['id' => 756, 'name' => 'Revenda', 'company_id' => $IdSaraceni],
            ['id' => 757, 'name' => 'Almoxarifado', 'company_id' => $IdSaraceni],
            ['id' => 758, 'name' => 'Limpeza (produção)', 'company_id' => $IdSaraceni],
            ['id' => 759, 'name' => 'Manutenção (produção)', 'company_id' => $IdSaraceni],
            ['id' => 760, 'name' => 'Qualidade', 'company_id' => $IdSaraceni],
            ['id' => 761, 'name' => 'Segurança do Trabalho', 'company_id' => $IdSaraceni],
            ['id' => 762, 'name' => 'Noorskin', 'company_id' => $IdSaraceni],
            ['id' => 763, 'name' => 'Receitas para Vendas', 'company_id' => $IdSaraceni],
            ['id' => 764, 'name' => 'Atendimento E-Commerce e SAC', 'company_id' => $IdSaraceni],
            ['id' => 765, 'name' => 'Congressos e Eventos', 'company_id' => $IdSaraceni],
            ['id' => 766, 'name' => 'Diretoria Vendas e Marketing', 'company_id' => $IdSaraceni],
            ['id' => 767, 'name' => 'Expedição', 'company_id' => $IdSaraceni],
            ['id' => 768, 'name' => 'Faturamento', 'company_id' => $IdSaraceni],
            ['id' => 769, 'name' => 'Marketing', 'company_id' => $IdSaraceni],
            ['id' => 770, 'name' => 'Recepção', 'company_id' => $IdSaraceni],
            ['id' => 771, 'name' => 'Visitação', 'company_id' => $IdSaraceni],
            ['id' => 772, 'name' => 'Diretoria Administrativo', 'company_id' => $IdSaraceni],
            ['id' => 773, 'name' => 'Suprimentos', 'company_id' => $IdSaraceni],
            ['id' => 774, 'name' => 'Novos Projetos', 'company_id' => $IdSaraceni],
            ['id' => 775, 'name' => 'Diretoria', 'company_id' => $IdSaraceni],
            ['id' => 776, 'name' => 'Infraestrutura e Telecom', 'company_id' => $IdSaraceni],
            ['id' => 777, 'name' => 'TI Technologies', 'company_id' => $IdSaraceni],
            ['id' => 778, 'name' => 'DDH', 'company_id' => $IdSaraceni],
            ['id' => 779, 'name' => 'Financeiro', 'company_id' => $IdSaraceni],
            ['id' => 780, 'name' => 'Diretoria financeira', 'company_id' => $IdSaraceni],
            ['id' => 781, 'name' => 'Tributário', 'company_id' => $IdSaraceni],
            ['id' => 782, 'name' => 'Controladoria', 'company_id' => $IdSaraceni],
        ];
    }
}
