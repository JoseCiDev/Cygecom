<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class SuppliesFilters extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Collection $companiesGroup,
        public Collection $status
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.supplies.supplies-filters');
    }
}
