<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\AnotarLivros;

class CapituloAnotar extends Component
{

    public $capitulo;
    /**
     * Create a new component instance.
     */
    public function __construct($capitulo)
    {
        //
        $this->capitulo = $capitulo;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $user_id = auth()->id();

        // Obter o ID do livro (parent_id) com base no nomelivro para o usuário autenticado
        $nomelivro = AnotarLivros::where('user_id', $user_id)->where("nomelivro" , $this->capitulo )->pluck('id')->first();
        $capitulos = AnotarLivros::where('user_id', $user_id)->where("parent_id" , $nomelivro)->pluck("capitulo");
       
        return view('components.capitulo-anotar' ,compact("capitulos") );
    }
}
