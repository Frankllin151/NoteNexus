<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\AnotarLivros;

class AnotarLivro extends Component
{

  
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
      

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $nomesLivros = AnotarLivros::where('user_id', auth()->id())->pluck('nomelivro');
        return view('components.anotar-livro'  , compact("nomesLivros"));
    }
}
