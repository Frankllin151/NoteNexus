<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnotarLivroController;
use App\Http\Controllers\CapituloController;
use App\Http\Controllers\TrechoController;
use App\Http\Controllers\GerapdfController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
   
    Route::post("/dashboard/adicionarlivro" , 
    [AnotarLivroController::class , "AdicionarNomeLivro"])->name("adicionarlivro");
    Route::delete("/dashboard/deletar{id?}" , [AnotarLivroController::class, "DeletarAnotar"])
    ->name("deletar");
    Route::put("/dashboard/editarlivro/{editarlivro?}" , [AnotarLivroController::class, "editarLivro"])
    ->name("eiditarlivro");

    //capitulo
    Route::get('/dashboard/capitulo/{capitulo?}',[CapituloController::class , "caPitUlo"])
    ->name("capitulo");
    Route::post("/dashboard/anotarcapitulo" , [CapituloController::class , "anoTarCApitul"])
    ->name("anotarcapitulo");
    Route::delete("/dashboard/deletarcapitulo/{id?}", [CapituloController::class, "DeletarCapitulo"])
    ->name("deletarCapitulo");
    Route::put("/dashboard/editarcapitulo/{capitulo?}" ,[CapituloController::class , "EditarCapitulo"])
    ->name("editarCapitulo");

    //trecho
    Route::get("/dashboard/trecho/{trecho}" , [TrechoController::class , "Trecho"])
    ->name("trechos");
    Route::post('trechoadd', [TrechoController::class , "trechoAdd"])->name("trechoadd");
   Route::delete("deletartrecho/{id?}", [TrechoController::class, "excluirid"])
   ->name("deletarTrecho");
   Route::put("/dashboard/editartrecho/{trecho?}" , [TrechoController::class, "trechoEditar"])
   ->name("EditarTrecho");

   /// gera pdf 
   Route::get("/dashboard/gerapdf/{nomelivro?}" , [GerapdfController::class , "GeraPdf"])
   ->name("gerapdf");
   


    // configuração 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
