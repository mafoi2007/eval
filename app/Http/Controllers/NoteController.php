<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Evaluation;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->role === 'enseignant') {
            return view('dashboard', [
                'enseignants' => User::where('role', 'enseignant')->count(),
                'eleves' => Eleve::count(),
                'evaluations' => Evaluation::count(),
                'notes' => Note::whereNotNull('valeur')->count(),
            ]);
        }

        return redirect()->route('eleve.evaluations');
    }

    public function index(Evaluation $evaluation)
    {
        $evaluation->load('classe.eleves.user');

        $notes = Note::with('eleve.user')
            ->where('evaluation_id', $evaluation->id)
            ->get()
            ->keyBy('eleve_id');

        return view('notes.index', compact('evaluation', 'notes'));
    }

    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'valeur' => ['nullable', 'numeric', 'min:0', 'max:20'],
        ]);

        $note->update($validated);

        return back()->with('success', 'Note mise à jour.');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return back()->with('success', 'Soumission supprimée.');
    }

    public function mesEvaluations()
    {
        $eleve = auth()->user()->eleve;
        $evaluations = Evaluation::where('classe_id', $eleve->classe_id)->latest()->get();

        return view('eleves.mes-evaluations', compact('evaluations', 'eleve'));
    }

    public function create(Evaluation $evaluation)
    {
        $eleve = auth()->user()->eleve;
        abort_unless($evaluation->classe_id === $eleve->classe_id, 403);

        $note = Note::where('eleve_id', $eleve->id)->where('evaluation_id', $evaluation->id)->first();

        return view('eleves.composer', compact('evaluation', 'note'));
    }

    public function store(Request $request, Evaluation $evaluation)
    {
        $eleve = auth()->user()->eleve;
        abort_unless($evaluation->classe_id === $eleve->classe_id, 403);

        $validated = $request->validate([
            'contenu' => ['required', 'string', 'min:10'],
        ]);

        Note::updateOrCreate(
            ['eleve_id' => $eleve->id, 'evaluation_id' => $evaluation->id],
            ['contenu' => $validated['contenu']]
        );

        return redirect()->route('eleve.evaluations')->with('success', 'Composition enregistrée.');
    }

    public function show()
    {
        $eleve = auth()->user()->eleve;

        $notes = Note::with('evaluation')
            ->where('eleve_id', $eleve->id)
            ->latest()
            ->get();

        return view('eleves.notes', compact('notes'));
    }
}