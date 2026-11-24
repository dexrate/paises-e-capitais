<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainLayout extends Component
{
    public string $paginaTitulo;
    /**
     * Create a new component instance.
     */
    public function __construct(string $paginaTitulo)
    {
        $this->paginaTitulo = $paginaTitulo;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.main-layout');
    }
}
