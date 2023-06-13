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
        'products' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'products', 'label' => 'Produtos'],
        ],
        'productRegister' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'products', 'label' => 'Produtos'],
            ['route' => 'productRegister', 'label' => 'Registrar produto'],
        ],
        'product' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'products', 'label' => 'Produtos'],
            ['route' => 'product', 'label' => 'Produto'],
        ],
        'requests' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests', 'label' => 'Solicitações'],
        ],
        'request.register' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas Solicitações'],
            ['route' => 'request.register', 'label' => 'Nova Solicitação'],
        ],
        'request.edit' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas Solicitações'],
            ['route' => 'request.edit', 'label' => 'Editar Solicitação'],
        ],
        'requests.own' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'requests.own', 'label' => 'Minhas Solicitações'],
        ],
        'quotations' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'quotations', 'label' => 'Cotações'],
        ],
        'quotationRegister' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'quotations', 'label' => 'Cotações'],
            ['route' => 'quotationRegister', 'label' => 'Nova Cotação'],
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
