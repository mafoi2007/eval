@extends('layouts.app')

@section('content')

<h3>Liste des Élèves</h3>

<a href="{{ route('eleves.create') }}" class="btn btn-primary mb-3">Ajouter</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Classe</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($eleves as $eleve)
        <tr>
            <td>{{ $eleve->user->name }}</td>
            <td>{{ $eleve->classe->nom }}</td>
            <td>
                <a href="{{ route('eleves.edit',$eleve) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('eleves.destroy',$eleve) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection