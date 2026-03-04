<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    //
    public function generatePdf(Classe $classe)
    {
        $eleves = $classe->eleves()->with('note')->get();

        $pdf = Pdf::loadView('admin.pdf', compact('eleves','classe'));

        return $pdf->download('notes_classe.pdf');
    }
}
