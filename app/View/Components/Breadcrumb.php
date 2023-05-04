<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $items;
    private $itemsMap = [
        'users' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'users', 'label' => 'Usuários']
        ],
        'user' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'users', 'label' => 'Usuários'],
            ['route' => 'user', 'label' => 'Usuário']
        ],
        'profile' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'profile', 'label' => 'Perfil']
        ],
        'register' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'users', 'label' => 'Usuários'],
            ['route' => 'register', 'label' => 'Cadastro de usuário']
        ],
        'home' => [
            ['route' => 'home', 'label' => 'Home']
        ],
        'email' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'email', 'label' => 'Envio de e-mail']
        ],
        'products' => [
            ['route' => 'home', 'label' => 'Home'],
            ['route' => 'products', 'label' => 'Produtos']
        ]
    ];

    public function __construct()
    {
        $this->setItem();
    }

    public function setItem()
    {
        $route = Route::getCurrentRoute();
        $routeName = $route->getName();
        $this->items = $this->itemsMap[$routeName] ?? $this->itemsMap['home'];
    }


    public function render()
    {
        return view('components.navbar.breadcrumb');
    }
}
