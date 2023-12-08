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
        'requests' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests', 'label' => 'Solicitações'],
        ],
        'requests.own' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas solicitações'],
        ],
        'request.links' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas solicitações'],
            ['route' => 'request.links', 'label' => 'Nova solicitação'],
        ],
        'request.service.register' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas solicitações'],
            ['route' => 'request.links', 'label' => 'Nova solicitação'],
            ['route' => 'request.service.register', 'label' => 'Serviço'],
        ],
        'request.product.register' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas solicitações'],
            ['route' => 'request.links', 'label' => 'Nova solicitação'],
            ['route' => 'request.product.register', 'label' => 'Produto(s)'],
        ],
        'request.contract.register' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas solicitações'],
            ['route' => 'request.links', 'label' => 'Nova solicitação'],
            ['route' => 'request.contract.register', 'label' => 'Serviço recorrente'],
        ],
        'request.edit' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas solicitações'],
            ['route' => 'request.edit', 'label' => 'Editar solicitação'],
        ],
        'suppliers' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'suppliers', 'label' => 'Fornecedores'],
        ],
        'supplier' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'suppliers', 'label' => 'Fornecedores'],
            ['route' => 'supplier', 'label' => 'Fornecedor'],
        ],
        'supplier.form' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'suppliers', 'label' => 'Fornecedores'],
            ['route' => 'supplier.form', 'label' => 'Novo fornecedor'],
        ],
        'supplies.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
        ],
        'supplies.service' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service', 'label' => 'Solicitações de serviços pontuais'],
        ],
        'supplies.service.filter' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service.filter', 'label' => 'Solicitações de serviços pontuais'],
        ],
        'supplies.service.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service', 'label' => 'Solicitações de serviços pontuais'],
            ['route' => 'supplies.service.detail', 'label' => 'Serviço pontual solicitado'],
        ],
        'supplies.product' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.product', 'label' => 'Solicitações de produtos'],
        ],
        'supplies.product.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.product', 'label' => 'Solicitações de produtos'],
            ['route' => 'supplies.product.detail', 'label' => 'Produto(s) solicitado(s)'],
        ],
        'supplies.contract' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract', 'label' => 'Solicitações de serviços recorrentes'],
        ],
        'supplies.contract.filter' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract.filter', 'label' => 'Solicitações de serviços recorrentes'],
        ],
        'supplies.contract.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract', 'label' => 'Solicitações de serviços recorrentes'],
            ['route' => 'supplies.contract.detail', 'label' => 'Serviço recorrente solicitado'],
        ],
        'reports.index.view' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'reports.index.view', 'label' => 'Relatórios de solicitações'],
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
