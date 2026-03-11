@extends('layouts.app')

@section('content')
<h1 class="h4">Composer : {{ $evaluation->titre }}</h1>
<p>{{ $evaluation->description }}</p>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('eleve.composer.store', $evaluation) }}" class="card card-body">
    @csrf

    @foreach($evaluation->questions as $question)
        <div class="border rounded p-3 mb-3">
            <div class="d-flex justify-content-between">
                <h6>Question {{ $loop->iteration }} ({{ rtrim(rtrim(number_format($question->points, 2, '.', ''), '0'), '.') }} pt)</h6>
                <span class="badge text-bg-secondary">{{ $question->type === 'vrai_faux' ? 'Vrai/Faux' : 'QCM' }}</span>
            </div>
            <p class="mb-2">{{ $question->intitule }}</p>

            @foreach(['a' => $question->choix_a, 'b' => $question->choix_b, 'c' => $question->choix_c, 'd' => $question->choix_d] as $key => $label)
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="reponses[{{ $question->id }}]"
                        id="q{{ $question->id }}_{{ $key }}"
                        value="{{ $key }}"
                        @checked(old('reponses.' . $question->id, $note?->reponses[$question->id] ?? null) === $key)
                    >
                    <label class="form-check-label" for="q{{ $question->id }}_{{ $key }}">
                        {{ strtoupper($key) }}. {{ $label }}
                    </label>
                </div>
            @endforeach

            @error('reponses.' . $question->id)
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    @endforeach

    @error('reponses')
        <small class="text-danger">{{ $message }}</small>
    @enderror

    <button class="btn btn-success">Soumettre l'évaluation</button>
</form>

@if($note)
    <div class="card card-body mt-4">
        <h5>Résultat : {{ rtrim(rtrim(number_format($note->valeur ?? 0, 2, '.', ''), '0'), '.') }}/20</h5>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Votre réponse</th>
                    <th>Réponse correcte</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recapitulatif as $ligne)
                    <tr>
                        <td>{{ $ligne['question'] }}</td>
                        <td>{{ strtoupper($ligne['choisie'] ?? '-') }}</td>
                        <td>{{ strtoupper($ligne['correcte']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection