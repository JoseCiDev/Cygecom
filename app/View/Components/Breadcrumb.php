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
        'home' => [
            ['route' => 'home', 'label' => 'Home'],
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
            ['route' => 'requests.own', 'label' => 'Minhas Solicitações'],
        ],
        'request.links' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas Solicitações'],
            ['route' => 'request.links', 'label' => 'Tipos de Solicitações'],
        ],
        'request.service.register' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests', 'label' => 'Solicitações'],
            ['route' => 'request.links', 'label' => 'Tipos de Solicitações'],
            ['route' => 'request.service.register', 'label' => 'Solicitação de Serviço'],
        ],
        'request.product.register' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests', 'label' => 'Solicitações'],
            ['route' => 'request.links', 'label' => 'Tipos de Solicitações'],
            ['route' => 'request.product.register', 'label' => 'Solicitação de Produto(s)'],
        ],
        'request.contract.register' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests', 'label' => 'Solicitações'],
            ['route' => 'request.links', 'label' => 'Tipos de Solicitações'],
            ['route' => 'request.contract.register', 'label' => 'Solicitação de Contrato'],
        ],
        'request.edit' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas Solicitações'],
            ['route' => 'request.edit', 'label' => 'Editar Solicitação'],
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
        'supplierRegister' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'suppliers', 'label' => 'Fornecedores'],
            ['route' => 'supplierRegister', 'label' => 'Novo Fornecedor'],
        ],
        'supplies.index' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
        ],
        'supplies.service' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service', 'label' => 'Solicitações de Serviços'],
        ],
        'supplies.service.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service', 'label' => 'Solicitações de Serviços'],
            ['route' => 'supplies.service.detail', 'label' => 'Serviço Solicitado'],
        ],
        'supplies.product' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.product', 'label' => 'Solicitações de Produtos'],
        ],
        'supplies.product.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.product', 'label' => 'Solicitações de Produtos'],
            ['route' => 'supplies.product.detail', 'label' => 'Produto(s) Solicitado(s)'],
        ],
        'supplies.contract' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract', 'label' => 'Solicitações de Contratos'],
        ],
        'supplies.contract.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract', 'label' => 'Solicitações de Contratos'],
            ['route' => 'supplies.contract.detail', 'label' => 'Contrato Solicitado'],
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
        $this->items = $this->itemsMap[$routeName] ?? $this->itemsMap['home'];
    }

    public function render()
    {
        return view('components.navbar.breadcrumb');
    }
}
