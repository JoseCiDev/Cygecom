<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $items;

    private array $itemsMap = [
        'users.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'users.index', 'label' => 'Usuários'],
        ],
        'users.edit' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'users.index', 'label' => 'Usuários'],
            ['route' => 'users.edit', 'label' => 'Usuário'],
        ],
        'users.create' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'users.index', 'label' => 'Usuários'],
            ['route' => 'users.create', 'label' => 'Cadastro de usuário'],
        ],
        'requests.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.index', 'label' => 'Solicitações'],
        ],
        'requests.index.own' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.index.own', 'label' => 'Minhas solicitações'],
        ],
        'requests.dashboard' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.index.own', 'label' => 'Minhas solicitações'],
            ['route' => 'requests.dashboard', 'label' => 'Nova solicitação'],
        ],
        'requests.service.create' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.index.own', 'label' => 'Minhas solicitações'],
            ['route' => 'requests.dashboard', 'label' => 'Nova solicitação'],
            ['route' => 'requests.service.create', 'label' => 'Serviço'],
        ],
        'requests.product.create' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.index.own', 'label' => 'Minhas solicitações'],
            ['route' => 'requests.dashboard', 'label' => 'Nova solicitação'],
            ['route' => 'requests.product.create', 'label' => 'Produto(s)'],
        ],
        'requests.contract.create' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.index.own', 'label' => 'Minhas solicitações'],
            ['route' => 'requests.dashboard', 'label' => 'Nova solicitação'],
            ['route' => 'requests.contract.create', 'label' => 'Serviço recorrente'],
        ],
        'requests.edit' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.index.own', 'label' => 'Minhas solicitações'],
            ['route' => 'requests.edit', 'label' => 'Editar solicitação'],
        ],
        'suppliers.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'suppliers.index', 'label' => 'Fornecedores'],
        ],
        'suppliers.edit' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'suppliers.index', 'label' => 'Fornecedores'],
            ['route' => 'supplier.edit', 'label' => 'Fornecedor'],
        ],
        'suppliers.create' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'suppliers.index', 'label' => 'Fornecedores'],
            ['route' => 'suppliers.create', 'label' => 'Novo fornecedor'],
        ],
        'supplies.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
        ],
        'supplies.service.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service.index', 'label' => 'Solicitações de serviços pontuais'],
        ],
        'supplies.service.filter' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service.filter', 'label' => 'Solicitações de serviços pontuais'],
        ],
        'supplies.service.show' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service.index', 'label' => 'Solicitações de serviços pontuais'],
            ['route' => 'supplies.service.show', 'label' => 'Serviço pontual solicitado'],
        ],
        'supplies.product.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.product.index', 'label' => 'Solicitações de produtos'],
        ],
        'supplies.product.show' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.product.index', 'label' => 'Solicitações de produtos'],
            ['route' => 'supplies.product.show', 'label' => 'Produto(s) solicitado(s)'],
        ],
        'supplies.contract.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract.index', 'label' => 'Solicitações de serviços recorrentes'],
        ],
        'supplies.contract.filter' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract.filter', 'label' => 'Solicitações de serviços recorrentes'],
        ],
        'supplies.contract.show' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract.index', 'label' => 'Solicitações de serviços recorrentes'],
            ['route' => 'supplies.contract.show', 'label' => 'Serviço recorrente solicitado'],
        ],
        'reports.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'reports.index', 'label' => 'Relatórios de solicitações'],
        ],
        'users.show' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'users.index', 'label' => 'Usuários'],
            ['route' => 'users.show', 'label' => 'Usuário'],
        ],
        'profile.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'profile.index', 'label' => 'Lista de perfis'],
        ],
        'profile.create' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'profile.index', 'label' => 'Lista de perfis'],
            ['route' => 'profile.create', 'label' => 'Criação de perfil'],
        ],
        'profile.edit' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'profile.index', 'label' => 'Lista de perfis'],
            ['route' => 'profile.edit', 'label' => 'Edição de perfil'],
        ],
    ];

    public function __construct()
    {
        $this->setItem();
    }

    public function setItem()
    {
        $route       = Route::getCurrentRoute();
        $routeName   = $route->getName();

        $routesSuppliersRequests = ['supplier.contract.detail', 'supplier.product.detail', 'supplier.service.detail'];
        $isSupplierRequestRoute = in_array($routeName, $routesSuppliersRequests);
        if ($isSupplierRequestRoute) {
            return;
        }

        $existBreadCrumb = collect($this->itemsMap)->has($routeName);
        $this->items = $existBreadCrumb ? $this->itemsMap[$routeName] : [];
    }

    public function render()
    {
        return view('components.navbar.breadcrumb');
    }
}
