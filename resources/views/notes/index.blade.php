@extends('layouts.app')

@section('content')
<h1 class="h4">Notes - {{ $evaluation->titre }} ({{ $evaluation->classe->nom }})</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Élève</th>
            <th>Soumission</th>
            <th>Note /20</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($evaluation->classe->eleves as $eleve)
            @php($note = $notes[$eleve->id] ?? null)
            <tr>
                <td>{{ $eleve->user->name }}</td>
                <td>{{ $note?->reponses ? 'QCM soumis' : 'Pas encore soumis' }}</td>
                <td>
                    @if($note)
                        <form class="d-flex gap-2" method="POST" action="{{ route('notes.update', $note) }}">
                            @csrf
                            @method('PUT')
                            <input class="form-control" style="max-width:100px" type="number" min="0" max="20" step="0.25" name="valeur" value="{{ $note->valeur }}">
                            <button class="btn btn-sm btn-success">Valider</button>
                        </form>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($note)
                        <form method="POST" action="{{ route('notes.destroy', $note) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection