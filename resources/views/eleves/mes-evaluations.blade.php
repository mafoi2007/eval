@extends('layouts.app')

@section('content')
<h1 class="h4">Mes évaluations - classe {{ $eleve->classe->nom }}</h1>
<table class="table">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($evaluations as $evaluation)
            <tr>
                <td>{{ $evaluation->titre }}</td>
                <td>{{ $evaluation->description }}</td>
                <td><a href="{{ route('eleve.composer', $evaluation) }}" class="btn btn-sm btn-primary">Commencer</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection