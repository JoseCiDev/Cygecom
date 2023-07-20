<?php

namespace App\View\Components;

use App\Models\Supplier;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SupplierForm extends Component
{
    public int|null $id;

    public Supplier|null $supplier;

    public string|null $isAPI;
    public function __construct(int|null $id = null, $supplier = null, $isAPI = false)
    {
        $this->id       = $id;
        $this->supplier = $supplier;
        $this->isAPI = $isAPI;
    }

    public function render(): View|Closure|string
    {
        if ($this->id && $this->supplier) {
            $params = ['id' => $this->id, "supplier" => $this->supplier, 'isRegister' => false];
        } else {
            $params = ['isRegister' => true, 'isAPI' => $this->isAPI];
        }
        return view('components.supplier.supplier-form', $params);
    }
}
