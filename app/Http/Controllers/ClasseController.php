<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::withCount(['eleves', 'evaluations'])->latest()->paginate(10);

        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:classes,nom'],
            ]);
        
        Classe::create($validated);

        return redirect()->route('classes.index')->with('success', 'Classe créée avec succès.');
    }
        
    public function edit(Classe $class)
    {
        return view('classes.edit', ['classe' => $class]);
    }

    public function update(Request $request, Classe $class)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:classes,nom,' . $class->id],
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')->with('success', 'Classe modifiée avec succès.');
    }

    public function destroy(Classe $class)
    {
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Classe supprimée.');
    }
}