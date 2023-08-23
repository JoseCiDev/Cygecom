<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputCep extends Component
{
    public function __construct(
        private ?string $value,
        private string $id,
        private string $name,
        private string $dataCy,
    ) {
    }

    public function render(): View|Closure|string
    {
        $params = [
            'value' => $this->value,
            'id' => $this->id,
            'name' => $this->name,
            'dataCy' => $this->dataCy,
        ];
        return view('components.inputs.input-cep', $params);
    }
}
