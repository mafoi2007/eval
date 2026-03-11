@extends('layouts.app')

@section('content')
<h1 class="h4">Mes notes</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Évaluation</th>
            <th>Soumission</th>
            <th>Note /20</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notes as $note)
            <tr>
                <td>{{ $note->evaluation->titre }}</td>
                <td>{{ $note->reponses ? 'QCM soumis' : 'Pas encore soumis' }}</td>
                <td>{{ $note->valeur ?? 'En attente' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection