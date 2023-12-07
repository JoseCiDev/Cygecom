<?php

namespace Database\Seeders;

use App\Models\{Ability, UserProfile};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Abilities extends Seeder
{
    public function run(): void
    {
        $routesAbilities = [
            // Abilities
            ['id' => 1, 'name' => 'get.abilities.index', 'description' => 'Acessar tela do painel de gestão de perfis e habilidades'],
            ['id' => 45, 'name' => 'post.abilities.store.json', 'description' => 'API: Atualizar habilidades dos usuários'],
            ['id' => 57, 'name' => 'get.abilities.profile.create', 'description' => 'Acessar tela de criação de perfil'],
            ['id' => 2, 'name' => 'post.abilities.profile.store', 'description' => 'Registrar novo perfil'],
            ['id' => 58, 'name' => 'get.abilities.user', 'description' => 'Acessar tela de todas habilidades de um usuário'],

            // Web
            ['id' => 3, 'name' => 'get.profile', 'description' => 'Acessar tela do seu perfil'],
            ['id' => 4, 'name' => 'post.user.update', 'description' => 'Atualizar usuário'],
            ['id' => 5, 'name' => 'post.supplier.register', 'description' => 'Registrar novo fornecedor'],

            // Supplies
            ['id' => 6, 'name' => 'get.supplies.index', 'description' => 'Acessar tela de dashboard de suprimentos'],
            ['id' => 7, 'name' => 'get.supplies.service', 'description' => 'Acessar tela de solicitações de serviços pontuais'],
            ['id' => 8, 'name' => 'get.supplies.product', 'description' => 'Acessar tela de solicitações de produtos'],
            ['id' => 9, 'name' => 'get.supplies.contract', 'description' => 'Acessar tela de solicitações de serviços recorrentes'],
            ['id' => 10, 'name' => 'get.supplies.service.detail', 'description' => 'Acessar tela de detalhes de uma solicitações de serviço pontual'],
            ['id' => 11, 'name' => 'get.supplies.product.detail', 'description' => 'Acessar tela de detalhes de uma solicitações de produto'],
            ['id' => 12, 'name' => 'get.supplies.contract.detail', 'description' => 'Acessar tela de detalhes de uma solicitações de serviço recorrente'],
            ['id' => 13, 'name' => 'post.supplies.request.service.update', 'description' => 'Atualizar solicitação de serviço pontual na tela de detalhes'],
            ['id' => 14, 'name' => 'post.supplies.request.product.update', 'description' => 'Atualizar solicitação de produto na tela de detalhes'],
            ['id' => 15, 'name' => 'post.supplies.request.conctract.update', 'description' => 'Atualizar solicitação de serviço recorrente na tela de detalhes'],
            ['id' => 47, 'name' => 'get.api.suppliers.index', 'description' => 'API: Busca todos fornecedores. É usado na tabela de fornecedores'],
            ['id' => 48, 'name' => 'post.api.suppliers.register', 'description' => 'API: Registrar novo fornecedor.'],

            // Admin
            ['id' => 16, 'name' => 'get.requests', 'description' => 'Acessar tela de solicitações gerais'],

            // Requests
            ['id' => 17, 'name' => 'get.requests.own', 'description' => 'Acessar tela de minhas solicitações'],
            ['id' => 18, 'name' => 'get.request.links', 'description' => 'Acessar tela de dashboard de nova solicitação'],
            ['id' => 19, 'name' => 'get.request.service.register', 'description' => 'Acessar tela de registrar nova solicitação de serviço pontual'],
            ['id' => 20, 'name' => 'post.request.service.register', 'description' => 'Registrar nova solicitação de serviço pontual'],
            ['id' => 21, 'name' => 'post.request.service.update', 'description' => 'Atualizar nova solicitação de serviço pontual'],
            ['id' => 22, 'name' => 'get.request.product.register', 'description' => 'Acessar tela de registrar nova solicitação de produto'],
            ['id' => 23, 'name' => 'post.request.product.register', 'description' => 'Registrar nova solicitação de produto'],
            ['id' => 24, 'name' => 'post.request.product.update', 'description' => 'Atualizar nova solicitação de produto'],
            ['id' => 25, 'name' => 'get.request.contract.register', 'description' => 'Acessar tela de registrar nova solicitação de serviço recorrente'],
            ['id' => 26, 'name' => 'post.request.contract.register', 'description' => 'Registrar nova solicitação de serviço recorrente'],
            ['id' => 27, 'name' => 'post.request.contract.update', 'description' => 'Atualizar nova solicitação de serviço recorrente'],
            ['id' => 28, 'name' => 'get.request.edit', 'description' => 'Acessar tela de editação de solicitação'],
            ['id' => 29, 'name' => 'delete.request.file.delete', 'description' => 'Excluir anexos da solicitação'],
            ['id' => 30, 'name' => 'post.request.delete', 'description' => 'Excluir solicitação'],
            ['id' => 49, 'name' => 'get.api.product.suggestion.index', 'description' => 'API: Busca sugestões de produtos. É usado em novas solicitações'],
            ['id' => 50, 'name' => 'post.api.supplies.files.upload', 'description' => 'API: Upload de anexos da solicitação'],

            // Users
            ['id' => 31, 'name' => 'get.register', 'description' => 'Acessar tela de registrar novo usuário'],
            ['id' => 32, 'name' => 'post.store', 'description' => 'Registrar novo usuário'],
            ['id' => 33, 'name' => 'post.destroy', 'description' => 'Excluir usuário'],
            ['id' => 34, 'name' => 'get.users', 'description' => 'Acessar tela de lista de usuários'],
            ['id' => 35, 'name' => 'get.user', 'description' => 'Acessar tela de edição do usuário'],
            ['id' => 46, 'name' => 'get.user.show.json', 'description' => 'API: Buscar usuário por id'],

            // Suppliers
            ['id' => 36, 'name' => 'get.suppliers', 'description' => 'Acessar tela de listagem de todos fornecedores'],
            ['id' => 37, 'name' => 'get.supplier', 'description' => 'Acessar tela de edição de fornecedor'],
            ['id' => 38, 'name' => 'get.supplier.form', 'description' => 'Acessar tela de registrar novo fornecedor'],
            ['id' => 39, 'name' => 'post.suppliers.delete', 'description' => 'Excluir fornecedor'],
            ['id' => 40, 'name' => 'post.supplier.update', 'description' => 'Atualizar fornecedor'],
            ['id' => 41, 'name' => 'get.supplier.service.detail', 'description' => 'Acessar tela de edição de detalhes de uma solicitação de serviço pontual a partir de um fornecedor'],
            ['id' => 42, 'name' => 'get.supplier.product.detail', 'description' => 'Acessar tela de edição de detalhes de uma solicitação de produto a partir de um fornecedor'],
            ['id' => 43, 'name' => 'get.supplier.contract.detail', 'description' => 'Acessar tela de edição de detalhes de uma solicitação de serviço recorrente a partir de um fornecedor'],

            // Reports
            ['id' => 44, 'name' => 'get.reports.index.view', 'description' => 'Acessar tela de relatório de solicitação'],
            ['id' => 51, 'name' => 'get.reports.index.json', 'description' => 'API: Buscar dados de relatório de solicitação para tabela'],
        ];

        $authorizesAbilities = [
            ['id' => 52, 'name' => 'admin', 'description' => 'Autorização interna de administrador'],
            ['id' => 53, 'name' => 'gestor_usuarios', 'description' => 'Autorização interna de gestor de usuários'],
            ['id' => 54, 'name' => 'diretor', 'description' => 'Autorização interna de diretor'],
            ['id' => 55, 'name' => 'suprimentos_hkm', 'description' => 'Autorização interna de suprimentos HKM'],
            ['id' => 56, 'name' => 'suprimentos_inp', 'description' => 'Autorização interna de suprimentos INP'],
        ];

        $abilitiesData = [
            ...$routesAbilities,
            ...$authorizesAbilities,
        ];

        $normalAbilities = [
            3, 4, 5, // Web
            17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 49, 50, // Requests
            44, 51, // Reports
            47, 48 // Supplies
        ];

        $suppliesAbilities = [
            ...$normalAbilities,
            6, 7, 8, 9, 10, 11, 12, 13, 14, 15, // Supplies
        ];

        $userManagerAbilities = [
            ...$normalAbilities,
            31, 32, 33, 34, 35, 46, // Users
            53 // Authorizes
        ];

        $supplierManagerAbilities = [
            ...$normalAbilities,
            36, 37, 38, 39, 40, 41, 42, 43, // Suppliers
        ];

        $directorAbilities = [
            ...$normalAbilities,
            54 // Authorizes
        ];

        $profilesAbilities = [
            'admin' => [...array_column($abilitiesData, 'id')],
            'normal' => $normalAbilities,
            'suprimentos_inp' => [
                ...$suppliesAbilities,
                56, // Authorizes
            ],
            'suprimentos_hkm' => [
                ...$suppliesAbilities,
                55, // Authorizes
            ],
            'gestor_usuarios' => $userManagerAbilities,
            'gestor_fornecedores' => $supplierManagerAbilities,
            'diretor' => $directorAbilities,
        ];

        DB::transaction(function () use ($abilitiesData, $profilesAbilities) {
            foreach ($abilitiesData as $abilityData) {
                $abilityId = $abilityData['id'];
                unset($abilityData['id']);

                Ability::updateOrCreate(['id' => $abilityId], $abilityData);
            }

            foreach ($profilesAbilities as $profile => $abilities) {
                $currentProfile = UserProfile::where('name', $profile)->first();
                $currentProfile->abilities()->sync($abilities);
            }
        });
    }
}
