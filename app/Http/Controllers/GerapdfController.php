<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnotarLivros;
use Barryvdh\DomPDF\Facade\Pdf;

class GerapdfController extends Controller
{
    //

    public function GeraPdf($nomepdf)
    {
        $user_id = auth()->id();
        $nomepdfSemEspaco = str_replace(' ', '_', $nomepdf);
        // Buscar todas as anotações do usuário para o livro específico
        $anotacoes = AnotarLivros::where('user_id', $user_id)
            ->where('nomelivro', $nomepdf)
            ->get();

        // Incluir os filhos (capítulos e trechos) das anotações
        foreach ($anotacoes as $anotacao) {
            $anotacao->children = $anotacao->children()->with('children')->get();
        }

        // Gerar o HTML para o PDF
        $html = view('pdf_template', compact('anotacoes'))->render();

        // Gerar o PDF
        $pdf = PDF::loadHTML($html);

        // Salvar o PDF temporariamente no servidor
        $pdfPath = storage_path('app/public/' . $nomepdfSemEspaco . '.pdf');
        $pdf->save($pdfPath);

        // Baixar o PDF
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}
