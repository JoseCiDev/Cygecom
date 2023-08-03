<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputCnpj extends Component
{
    public function __construct(
        private ?string $cnpj = null,
        private ?string $id = null,
        private ?string $name = null,
        private ?string $dataCy = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        $params = [
            'cnpj' => $this->cnpj,
            'id' => $this->id,
            'name' => $this->name,
            'dataCy' => $this->dataCy,
        ];
        return view('components.inputs.input-cnpj', $params);
    }
}
