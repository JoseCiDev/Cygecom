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
            ['id' => 1, 'name' => 'get.users.show', 'description' => 'Acessar cadastro de um usuário.'],
            ['id' => 2, 'name' => 'post.profile.store', 'description' => 'Cadastrar perfil.'],
            ['id' => 45, 'name' => 'post.api.user.abilities.store', 'description' => 'Permite atualizar habilidades dos usuários através da API. Usado em caixas algumas caixas flutuantes.'],
            ['id' => 57, 'name' => 'get.profile.create', 'description' => 'Acessar criação de perfil.'],
            ['id' => 58, 'name' => 'get.profile.index', 'description' => 'Acessar lista de perfis.'],
            ['id' => 59, 'name' => 'delete.api.userProfile.destroy', 'description' => 'Excluir um perfil.'],
            ['id' => 41, 'name' => 'get.profile.edit', 'description' => 'Acessar edição de perfil.'],
            ['id' => 42, 'name' => 'post.profile.update', 'description' => 'Atualizar perfil.'],

            // Web
            ['id' => 3, 'name' => 'get.profile', 'description' => 'Acessar configurações da conta.'],
            ['id' => 4, 'name' => 'post.users.update', 'description' => 'Atualizar usuário.'],
            ['id' => 5, 'name' => 'post.suppliers.store', 'description' => 'Cadastrar fornecedor.'],

            // Supplies
            ['id' => 6, 'name' => 'get.supplies.index', 'description' => 'Acessar dashboard de suprimentos.'],
            ['id' => 7, 'name' => 'get.supplies.service.index', 'description' => 'Acessar lista de solicitações de serviços pontuais.'],
            ['id' => 8, 'name' => 'get.supplies.product.index', 'description' => 'Acessar lista de solicitações de produtos.'],
            ['id' => 9, 'name' => 'get.supplies.contract.index', 'description' => 'Acessar lista de solicitações de serviços recorrentes.'],
            ['id' => 10, 'name' => 'get.supplies.service.show', 'description' => 'Acessar cadastros de solicitações de serviço pontual no módulo de suprimentos.'],
            ['id' => 11, 'name' => 'get.supplies.product.show', 'description' => 'Acessar cadastros de uma solicitações de produto no módulo de suprimentos.'],
            ['id' => 12, 'name' => 'get.supplies.contract.show', 'description' => 'Acessar cadastros de uma solicitações de serviço recorrente no módulo de suprimentos.'],
            ['id' => 13, 'name' => 'post.supplies.service.update', 'description' => 'Atualizar solicitação de serviço pontual no módulo de suprimentos.'],
            ['id' => 14, 'name' => 'post.supplies.product.update', 'description' => 'Atualizar solicitação de produto no módulo de suprimentos.'],
            ['id' => 15, 'name' => 'post.supplies.contract.update', 'description' => 'Atualizar solicitação de serviço recorrente no módulo de suprimentos.'],
            ['id' => 47, 'name' => 'get.api.suppliers.index', 'description' => 'Permite buscar todos fornecedores através da API. É usado na tabela de fornecedores.'],
            ['id' => 48, 'name' => 'post.api.suppliers.register', 'description' => 'Permite cadastrar fornecedor através da API.'],

            // Admin
            ['id' => 16, 'name' => 'get.requests.index', 'description' => 'Acessar lista de solicitações gerais.'],

            // Requests
            ['id' => 17, 'name' => 'get.requests.index.own', 'description' => 'Acessar lista de minhas solicitações.'],
            ['id' => 18, 'name' => 'get.requests.dashboard', 'description' => 'Acessar dashboard nova solicitação.'],
            ['id' => 19, 'name' => 'get.requests.service.create', 'description' => 'Acessar criação de solicitação de serviço pontual.'],
            ['id' => 20, 'name' => 'post.requests.service.store', 'description' => 'Cadastrar solicitação de serviço pontual.'],
            ['id' => 21, 'name' => 'post.requests.service.update', 'description' => 'Atualizar solicitação de serviço pontual.'],
            ['id' => 22, 'name' => 'get.requests.product.create', 'description' => 'Acessar criação de solicitação de produto.'],
            ['id' => 23, 'name' => 'post.requests.product.store', 'description' => 'Cadastrar solicitação de produto.'],
            ['id' => 24, 'name' => 'post.requests.product.update', 'description' => 'Atualizar solicitação de produto.'],
            ['id' => 25, 'name' => 'get.requests.contract.create', 'description' => 'Acessar criação de solicitação de serviço recorrente.'],
            ['id' => 26, 'name' => 'post.requests.contract.store', 'description' => 'Cadastrar solicitação de serviço recorrente.'],
            ['id' => 27, 'name' => 'post.requests.contract.update', 'description' => 'Atualizar solicitação de serviço recorrente.'],
            ['id' => 28, 'name' => 'get.requests.edit', 'description' => 'Acessar edição de solicitação.'],
            ['id' => 29, 'name' => 'delete.requests.file.delete', 'description' => 'Excluir anexos da solicitação.'],
            ['id' => 30, 'name' => 'delete.api.requests.destroy', 'description' => 'Excluir solicitação.'],
            ['id' => 49, 'name' => 'get.api.product.suggestion.index', 'description' => 'Permite buscar sugestões de produtos através da API. É usado em novas solicitações.'],
            ['id' => 50, 'name' => 'post.api.supplies.files.upload', 'description' => 'Permite upload de anexos da solicitação através da API.'],
            ['id' => 62, 'name' => 'get.api.requests.show', 'description' => 'Permite buscar dados de uma solicitação através da API. É usado na caixa flutuante de análise de solicitação..'],

            // Users
            ['id' => 31, 'name' => 'get.users.create', 'description' => 'Acessar criação de usuário.'],
            ['id' => 32, 'name' => 'post.users.store', 'description' => 'Cadastrar usuário.'],
            ['id' => 33, 'name' => 'delete.api.users.destroy', 'description' => 'Excluir usuário.'],
            ['id' => 34, 'name' => 'get.users.index', 'description' => 'Acessar lista de usuários.'],
            ['id' => 35, 'name' => 'get.user.edit', 'description' => 'Acessar edição de usuário.'],
            ['id' => 46, 'name' => 'get.api.users.show', 'description' => 'Permite buscar usuário por id através da API. Usado em caixas flutuantes.'],

            // Suppliers
            ['id' => 36, 'name' => 'get.suppliers.index', 'description' => 'Acessar lista de fornecedores.'],
            ['id' => 37, 'name' => 'get.suppliers.edit', 'description' => 'Acessar edição de fornecedor.'],
            ['id' => 38, 'name' => 'get.suppliers.create', 'description' => 'Acessar criação de fornecedor.'],
            ['id' => 39, 'name' => 'delete.api.suppliers.destroy', 'description' => 'Excluir fornecedor.'],
            ['id' => 40, 'name' => 'post.suppliers.update', 'description' => 'Atualizar fornecedor.'],

            // Reports
            ['id' => 44, 'name' => 'get.reports.requests.index', 'description' => 'Acessar relatório de solicitação. (Página utiliza habilidades API)'],
            ['id' => 51, 'name' => 'post.api.reports.requests.index', 'description' => 'Permite buscar dados de relatório de solicitação para tabela através da API.'],
            ['id' => 60, 'name' => 'get.reports.productivity.index', 'description' => 'Acessar relatório de produtividade. (Página utiliza habilidades API)'],
            ['id' => 61, 'name' => 'post.api.reports.productivity.index', 'description' => 'Permite buscar dados de relatório de produtividade para tabela através da API.'],
        ];

        $authorizesAbilities = [
            ['id' => 52, 'name' => 'admin', 'description' => 'Autorização interna de administrador.'],
            ['id' => 53, 'name' => 'gestor_usuarios', 'description' => 'Autorização interna de gestor de usuários.'],
            ['id' => 43, 'name' => 'gestor_fornecedores', 'description' => 'Autorização interna de gestor de fornecedores.'],
            ['id' => 54, 'name' => 'diretor', 'description' => 'Autorização interna de diretor.'],
            ['id' => 55, 'name' => 'suprimentos_hkm', 'description' => 'Autorização interna de suprimentos HKM.'],
            ['id' => 56, 'name' => 'suprimentos_inp', 'description' => 'Autorização interna de suprimentos INP.'],
        ];

        $abilitiesData = [
            ...$routesAbilities,
            ...$authorizesAbilities,
        ];

        $normalAbilities = [
            3, 4, 5, // Web
            17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 49, 50, 62, // Requests
            44, 51, // Reports
            47, 48 // Supplies
        ];

        $suppliesAbilities = [
            ...$normalAbilities,
            6, 7, 8, 9, 10, 11, 12, 13, 14, 15, // Supplies
        ];

        $userManagerAbilities = [
            ...$normalAbilities,
            1, 31, 32, 33, 34, 35, 46, // Users
            53 // Authorizes
        ];

        $supplierManagerAbilities = [
            ...$normalAbilities,
            36, 37, 38, 39, 40, // Suppliers
            10, 11, 12, // Supplies
            43 // Authorizes
        ];

        $directorAbilities = [
            ...$normalAbilities,
            54, // Authorizes
            60, 61, // Reports
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
