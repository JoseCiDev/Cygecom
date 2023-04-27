<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $path;

    public function __construct($currentRouteName)
    {
        $this->path = $currentRouteName;
    }

    public function render()
    {
        return view('components.navbar.breadcrumb');
    }
}
