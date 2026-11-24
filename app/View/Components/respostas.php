<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class respostas extends Component
{
    public array $respostas;
    /**
     * Create a new component instance.
     */
    public function __construct($respostas)
    {
        $this->respostas = $respostas;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.respostas');
    }
}
