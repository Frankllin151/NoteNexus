<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnotarLivros;
class TrechoController extends Controller
{
    //

    public function Trecho(Request $request , $trecho)
 {

  $id = AnotarLivros::where("user_id", auth()->id())->where("capitulo", $trecho)->pluck("id");

      $trechos = AnotarLivros::where("user_id", auth()->id())->where("parent_id", $id[0])->pluck("trecho");
     
  

  return view("trecho" ,["trecho" => $trecho , "trechos" => $trechos]);
    }


    public  function trechoAdd(Request $request)
    {
     
     if(!empty($request->input('trecho'))){
      $Capitulo= AnotarLivros::where('user_id', auth()->id())
      ->where('capitulo', $request->input('capitulo'))
      ->pluck('id');
   
 AnotarLivros::create([
    "user_id" => auth()->id(), 
    "parent_id" => $Capitulo[0],
    "trecho"  => $request->input("trecho")
 ]);

 return redirect()->route('dashboard')->with('success', 'Trecho anotado com sucesso!');
     } else{
      return "vazio";
     }
    


    }

    public function excluirid($id)
    {
     
      $idtrecho= AnotarLivros::where('user_id', auth()->id())
      ->where('trecho', $id)
      ->pluck('id');

      AnotarLivros::whereIn('id', $idtrecho)->delete();

      return redirect()->route('dashboard')->with('success', 'Trecho Deletado');

    }


    public function trechoEditar(Request $request, $editarTrecho)
    {
        $request->validate([
           "trecho" => "required|string|max:255",
        ]);

        $updateTrecho = $request->input('trecho');

        $trecho = AnotarLivros::where("trecho" , $editarTrecho)
        ->where("user_id", auth()->id())->firstOrFail();

      $trecho->trecho = $updateTrecho;
      $trecho->save();

      return redirect()->route('dashboard')->with('success', 'Trecho Atualizado com sucesso!');
    }
}
