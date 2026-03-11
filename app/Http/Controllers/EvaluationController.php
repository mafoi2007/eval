<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::with(['classe', 'questions'])->latest()->paginate(10);

        return view('evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $classes = Classe::orderBy('nom')->get();

        return view('evaluations.create', compact('classes'));
    }
 
    public function store(Request $request)
    {
        $validated = $this->validateEvaluation($request);

        $evaluation = Evaluation::create([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'classe_id' => $validated['classe_id'],
        ]);

        $this->saveQuestions($evaluation, $validated['questions']);

        return redirect()->route('evaluations.index')->with('success', 'Évaluation créée avec succès.');
    }

    public function edit(Evaluation $evaluation)
    {
        $classes = Classe::orderBy('nom')->get();
        $evaluation->load('questions');

        return view('evaluations.edit', compact('evaluation', 'classes'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $validated = $this->validateEvaluation($request);

        $evaluation->update([
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'classe_id' => $validated['classe_id'],
        ]);

        $this->saveQuestions($evaluation, $validated['questions']);

        return redirect()->route('evaluations.index')->with('success', 'Évaluation modifiée avec succès.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();

        return redirect()->route('evaluations.index')->with('success', 'Évaluation supprimée.');
    }

    private function validateEvaluation(Request $request): array
    {
        $validated = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'classe_id' => ['required', 'exists:classes,id'],
            'questions' => ['required', 'array', 'min:1', 'max:20'],
            'questions.*.type' => ['required', Rule::in(['qcm', 'vrai_faux'])],
            'questions.*.intitule' => ['required', 'string'],
            'questions.*.choix_a' => ['required', 'string', 'max:255'],
            'questions.*.choix_b' => ['required', 'string', 'max:255'],
            'questions.*.choix_c' => ['required', 'string', 'max:255'],
            'questions.*.choix_d' => ['required', 'string', 'max:255'],
            'questions.*.bonne_reponse' => ['required', Rule::in(['a', 'b', 'c', 'd'])],
            'questions.*.points' => ['required', 'numeric', 'min:0.25', 'max:20'],
        ]);

        $totalPoints = collect($validated['questions'])->sum(fn ($q) => (float) $q['points']);
        if (abs($totalPoints - 20) > 0.001) {
            throw ValidationException::withMessages([
                'questions' => 'La somme des pondérations doit être exactement égale à 20.',
            ]);
        }

        return $validated;
    }

    private function saveQuestions(Evaluation $evaluation, array $questions): void
    {
        $evaluation->questions()->delete();

        foreach (array_values($questions) as $index => $question) {
            $evaluation->questions()->create([
                'position' => $index + 1,
                'type' => $question['type'],
                'intitule' => $question['intitule'],
                'choix_a' => $question['choix_a'],
                'choix_b' => $question['choix_b'],
                'choix_c' => $question['choix_c'],
                'choix_d' => $question['choix_d'],
                'bonne_reponse' => $question['bonne_reponse'],
                'points' => $question['points'],
            ]);
        }
    }
}