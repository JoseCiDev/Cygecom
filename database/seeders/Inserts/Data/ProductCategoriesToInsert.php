<?php

namespace Database\Seeders\Inserts\Data;

use App\Contracts\DataToInsertInterface;

class ProductCategoriesToInsert implements DataToInsertInterface
{
    public static function getArray(): array
    {
        return [
            // update da categoria 1 | nome anterior = Material Utilizado na Produção/Lab
            [
                'id' => 1,
                'name' => 'Material de Uso e Consumo Laboratório',
                'description' => null
            ],
            //-----
            [
                'id' => 10,
                'name' => 'Obras Em Andamento',
                'description' => null
            ],
            [
                'id' => 11,
                'name' => 'Benfeitorias Em Imoveis De Terceiros',
                'description' => null
            ],
            [
                'id' => 12,
                'name' => 'Instalacoes',
                'description' => null
            ],
            [
                'id' => 13,
                'name' => 'Maquinas E Equipamentos',
                'description' => null
            ],
            [
                'id' => 14,
                'name' => 'Maquinas E Equipamentos No Laboratorio',
                'description' => null
            ],
            [
                'id' => 15,
                'name' => 'Moveis E Utensilios',
                'description' => null
            ],
            [
                'id' => 16,
                'name' => 'Computadores E Perifericos',
                'description' => null
            ],
            [
                'id' => 17,
                'name' => 'Epi Lab',
                'description' => null
            ],
            [
                'id' => 18,
                'name' => 'Uniformes',
                'description' => null
            ],
            [
                'id' => 19,
                'name' => 'Outros Materiais De Uso E Consumo',
                'description' => null
            ],
            [
                'id' => 20,
                'name' => 'Manutencao Predial',
                'description' => null
            ],
            [
                'id' => 21,
                'name' => 'Epi Manutencao/Limpeza',
                'description' => null
            ],
            [
                'id' => 22,
                'name' => 'Pecas Reposicao Em Geral',
                'description' => null
            ],
            [
                'id' => 23,
                'name' => 'Pecas Reposicao Equipamentos E Maquinas Laboratorio',
                'description' => null
            ],
        ];
    }
}
