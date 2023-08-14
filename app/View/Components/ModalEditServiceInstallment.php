<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalEditServiceInstallment extends Component
{
    public function __construct(private $statusValues)
    {
    }
    public function render(): View|Closure|string
    {
        return view('components.modal-edit-service-installment', ['statusValues' => $this->statusValues]);
    }
}
