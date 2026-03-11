<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    
    public function index()
    {
        $evaluations = Evaluation::with('classe')->latest()->paginate(10);

        return view('evaluations.index', compact('evaluations'));
    }

    
    public function create()
    {
        $classes = Classe::orderBy('nom')->get();

        return view('evaluations.create', compact('classes'));
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'classe_id' => ['required', 'exists:classes,id'],
        ]);

        Evaluation::create($validated);

        return redirect()->route('evaluations.index')->with('success', 'Évaluation créée avec succès.');


    }

        
    public function edit(Evaluation $evaluation)
    {
        $classes = Classe::orderBy('nom')->get();

        return view('evaluations.edit', compact('evaluation', 'classes'));
    }

    
    public function update(Request $request, Evaluation $evaluation)
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'classe_id' => ['required', 'exists:classes,id'],
        ]);

        $evaluation->update($validated);

        return redirect()->route('evaluations.index')->with('success', 'Évaluation modifiée avec succès.');

    }

    
    public function destroy(Evaluation $evaluation)
    {
        
        $evaluation->delete();

        return redirect()->route('evaluations.index')->with('success', 'Évaluation supprimée.');
    }
}
