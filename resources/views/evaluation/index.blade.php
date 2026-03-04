@extends('layouts.app')

@section('content')

<h3>Liste des Evaluations</h3>

<a href="{{ route('evaluations.create') }}" class="btn btn-primary mb-3">Ajouter</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Classe</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($evaluations as $evaluation)
        <tr>
            <td>{{ $evaluation->titre }}</td>
            <td>{{ $evaluation->classe->nom }}</td>
            <td>
                <a href="{{ route('evaluations.edit',$evaluation) }}" class="btn btn-warning btn-sm">Modifier</a>

                <form action="{{ route('evaluations.destroy',$evaluation) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Supprimer</button>
                </form>

                <a href="{{ url('notes/'.$evaluation->id) }}" class="btn btn-info btn-sm">
                    Voir Notes
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection