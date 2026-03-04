@extends('layouts.app')

@section('content')

<h3>Liste des Classes</h3>

<a href="{{ route('classes.create') }}" class="btn btn-primary mb-3">Ajouter</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($classes as $classe)
        <tr>
            <td>{{ $classe->nom }}</td>
            <td>
                <a href="{{ route('classes.edit',$classe) }}" class="btn btn-warning btn-sm">Modifier</a>

                <form action="{{ route('classes.destroy',$classe) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Supprimer</button>
                </form>

                <a href="{{ url('pdf/classe/'.$classe->id) }}" class="btn btn-success btn-sm">
                    PDF Notes
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection