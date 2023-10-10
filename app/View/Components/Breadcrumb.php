<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $items;

    private array $itemsMap = [
        'users' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'users', 'label' => 'Usuários'],
        ],
        'user' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'users', 'label' => 'Usuários'],
            ['route' => 'user', 'label' => 'Usuário'],
        ],
        'profile' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'profile', 'label' => 'Perfil'],
        ],
        'register' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'users', 'label' => 'Usuários'],
            ['route' => 'register', 'label' => 'Cadastro de usuário'],
        ],
        'email' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'email', 'label' => 'Envio de e-mail'],
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
            ['route' => 'request.contract.register', 'label' => 'Contrato'],
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
            ['route' => 'supplies.service', 'label' => 'Solicitações de serviços'],
        ],
        'supplies.service.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service', 'label' => 'Solicitações de serviços'],
            ['route' => 'supplies.service.detail', 'label' => 'Serviço solicitado'],
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
            ['route' => 'supplies.contract', 'label' => 'Solicitações de contratos'],
        ],
        'supplies.contract.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract', 'label' => 'Solicitações de contratos'],
            ['route' => 'supplies.contract.detail', 'label' => 'Contrato solicitado'],
        ]
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

        $this->items = $routeName !== 'home' ? $this->itemsMap[$routeName] : [];
    }

    public function render()
    {
        return view('components.navbar.breadcrumb');
    }
}
