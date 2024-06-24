<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnotarLivros;
use App\View\Components\AnotarLivro;

class CapituloController extends Controller
{
    //

    public function caPitUlo(Request $request , $capitulo)
    {
    

      return view("capitulo" , ["capitulo" => $capitulo]);
    }


    public function anoTarCApitul(Request $request)
    {
        if(!$request->input('nomelivro')){
            return "Algo deu errado";
        }
        $nomesLivro = AnotarLivros::where('user_id', auth()->id())
            ->where('nomelivro', $request->input('nomelivro'))
            ->pluck('id');

        // Depurar a saída
         AnotarLivros::create([
            "user_id" => auth()->id(), 
            "parent_id" => $nomesLivro[0],
            "capitulo" => $request->input('capitulo')
        ]);
         
        return redirect()->route('dashboard')->with('success', 'Livroanotado com sucesso!');

    }

    public function DeletarCapitulo($capitulo)
    {
        // Encontrar o ID do capítulo
    $idCapitulo = AnotarLivros::where('user_id', auth()->id())
    ->where('capitulo', $capitulo)
    ->pluck('id')
    ->first();

// Garantir que o ID foi encontrado
if (!$idCapitulo) {
return redirect()->back()->with('error', 'Capítulo não encontrado.');
}

// Obter todos os IDs dos trechos
$trechoIds = AnotarLivros::getTrechosIds($idCapitulo);

// Incluir o ID do capítulo na lista de IDs a serem deletados
$allIdsToDelete = array_merge([$idCapitulo], $trechoIds);

// Deletar todos os registros identificados
AnotarLivros::whereIn('id', $allIdsToDelete)->delete();

return redirect()->route('dashboard')->with('success', 'Capítulo e seus trechos deletados com sucesso');
    }





    public function EditarCapitulo(Request $request , $editarCapitulo)
    {

        $request->validate([
            'capituloname' => 'required|string|max:255',
        ]);

      $upadteCapitulo = $request->input("capituloname");
     
      $capitulo = AnotarLivros::where("capitulo" , $editarCapitulo)
      ->where("user_id" , auth()->id())->firstOrFail();

      $capitulo->capitulo = $upadteCapitulo;
      $capitulo->save();

      return redirect()->route('dashboard')->with('success', 'Capitulo atualizado com sucesso!');

    }
}
