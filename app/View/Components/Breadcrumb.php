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
        'supplies.service.filter' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service.filter', 'label' => 'Solicitações de serviços'],
        ],
        'supplies.service.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.service.detail', 'label' => 'Serviço solicitado'],
        ],
        'supplies.product' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.product', 'label' => 'Solicitações de produtos'],
        ],
        'supplies.product.filter' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.product.filter', 'label' => 'Solicitações de produtos'],
        ],
        'supplies.product.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.product.detail', 'label' => 'Produto(s) solicitado(s)'],
        ],
        'supplies.contract' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract', 'label' => 'Solicitações de contratos'],
        ],
        'supplies.contract.filter' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract.filter', 'label' => 'Solicitações de contratos'],
        ],
        'supplies.contract.detail' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'supplies.index', 'label' => 'Suprimentos'],
            ['route' => 'supplies.contract.detail', 'label' => 'Contrato solicitado'],
        ],
        'reports.index.view' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'reports.index.view', 'label' => 'Relatórios'],
        ],
    ];

    public function __construct()
    {
        $this->setItem();
    }

    public function setItem()
    {
        $route = Route::getCurrentRoute();
        $routeName = $route->getName();
        $items = collect($this->itemsMap);
        $hasBreadItem = $items->has($routeName);
        $breadCrumb = $hasBreadItem ? $items->get($routeName) : [];
        $this->items = $routeName !== 'home' ? $breadCrumb : [];
    }

    public function render()
    {
        return view('components.navbar.breadcrumb');
    }
}
