<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnotarLivros;
use App\View\Components\AnotarLivro;

class AnotarLivroController extends Controller
{
    //

    public function AdicionarNomeLivro(Request $request)
    {
 
       $adicionar = [
        'user_id' => auth()->id(),
        "nomelivro" => $request->input("nomelivro")
        
       ];

       AnotarLivros::create($adicionar); 
       return redirect()->route('dashboard')->with('success', 'Livro anotado com sucesso!');

    }


    public function deletarAnotar($nome)
{
    // Encontrar o ID do nomelivro
    $idNomelivro = AnotarLivros::where('user_id', auth()->id())
                                ->where('nomelivro', $nome)
                                ->pluck('id')
                                ->first();

    // Garantir que o ID foi encontrado
    if (!$idNomelivro) {
        return redirect()->back()->with('error', 'Livro não encontrado.');
    }

    // Obter todos os IDs dos descendentes
    $descendantIds = AnotarLivros::getAllDescendantIds($idNomelivro);

    // Incluir o ID original na lista de IDs a serem deletados
    $allIdsToDelete = array_merge([$idNomelivro], $descendantIds);

    // Deletar todos os registros identificados
    AnotarLivros::whereIn('id', $allIdsToDelete)->delete();

    return redirect()->route('dashboard')->with('success', 'Livro e seus descendentes deletados!');
}



public function editarLivro( Request $request ,$nomelivroeditar)
{
 
// Validar a entrada
$request->validate([
    'bookName' => 'required|string|max:255',
]);

$updateNamebook = $request->input('bookName');

$livro = AnotarLivros::where("nomelivro" , $nomelivroeditar)
->where("user_id" , auth()->id())->firstOrFail();


$livro->nomelivro = $updateNamebook;
$livro->save();

return redirect()->route('dashboard')->with('success', 'Livro atualizado com sucesso!');


   
}

}
