<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PopulateProductCategories extends Seeder
{
    public function run(): void
    {
        DB::table('product_categories')->insert([
            [
                'name' => 'Amostra Grátis',
                'description' => 'Solicitada para o fornecedor'
            ],
            [
                'name' => 'Brinde',
                'description' => 'Mercadoria distribuida gratuitamente para nossos clientes e que não podemos vender. Ex. Toalha, Necessaire, etc...'
            ],
            [
                'name' => 'Compra Laboratório Liquido, Sólido e Inj',
                'description' => null
            ],
            [
                'name' => 'Material de Copa e Cozinha',
                'description' => null
            ],
            [
                'name' => 'Material de escritório',
                'description' => null
            ],
            [
                'name' => 'Material de Limpeza',
                'description' => null
            ],
            [
                'name' => 'Material Promocional',
                'description' => 'Material publicitário/gráfico que visa promover a propaganda e melhor visualização dos nossos produtos. Ex: Lâminas, Folders, etc...'
            ],
            [
                'name' => 'Material Utilizado na Produção/Lab',
                'description' => null
            ],
            [
                'name' => 'Revenda / Bonificado',
                'description' => 'Mercadoria que vai ser revendida e também distribuida gratuitamente para os nossos clientes (Bonificados). Ex: Viseira, Garrafa, etc...'
            ],
            [
                'name' => 'Outros Tipos de Produto',
                'description' => null
            ]
        ]);
    }
}
