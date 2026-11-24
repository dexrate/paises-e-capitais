<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class questao extends Component
{
    public string $pais;

    public string $perguntaAtual;

    public string $totalQuestoes;

    /**
     * Create a new component instance.
     */
    public function __construct($pais, $perguntaAtual, $totalQuestoes)
    {
        $this->pais = $pais ;
        $this->perguntaAtual = $perguntaAtual ;
        $this->totalQuestoes = $totalQuestoes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.questao');
    }
}
