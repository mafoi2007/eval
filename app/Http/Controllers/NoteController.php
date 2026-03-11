<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Evaluation;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $evaluation->load(['classe.eleves.user', 'questions']);

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

        $evaluation->load('questions');

        $note = Note::where('eleve_id', $eleve->id)->where('evaluation_id', $evaluation->id)->first();

        $recapitulatif = $this->buildRecap($evaluation, $note);

        return view('eleves.composer', compact('evaluation', 'note', 'recapitulatif'));
    }

    public function store(Request $request, Evaluation $evaluation)
    {
        $eleve = auth()->user()->eleve;
        abort_unless($evaluation->classe_id === $eleve->classe_id, 403);

        $evaluation->load('questions');

        $request->validate([
            'reponses' => ['required', 'array', 'size:' . $evaluation->questions->count()],
            'reponses.*' => ['required', Rule::in(['a', 'b', 'c', 'd'])],
        ]);

        $score = 0.0;
        $reponsesEnregistrees = [];

        foreach ($evaluation->questions as $question) {
            $reponseChoisie = $request->input('reponses.' . $question->id);
            if ($reponseChoisie === $question->bonne_reponse) {
                $score += (float) $question->points;
            }

            $reponsesEnregistrees[$question->id] = $reponseChoisie;
        }

        Note::updateOrCreate(
            ['eleve_id' => $eleve->id, 'evaluation_id' => $evaluation->id],
            [
                'contenu' => 'QCM soumis',
                'reponses' => $reponsesEnregistrees,
                'valeur' => $score,
            ]
        );

        return redirect()->route('eleve.composer', $evaluation)->with('success', 'Évaluation soumise.');
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

    private function buildRecap(Evaluation $evaluation, ?Note $note): array
    {
        if (! $note || ! is_array($note->reponses)) {
            return [];
        }

        return $evaluation->questions->map(function ($question) use ($note) {
            return [
                'question' => $question->intitule,
                'choisie' => $note->reponses[$question->id] ?? null,
                'correcte' => $question->bonne_reponse,
            ];
        })->toArray();
    }
}