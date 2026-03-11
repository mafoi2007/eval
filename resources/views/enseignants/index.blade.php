@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Administrateurs (enseignants)</h1><a href="{{ route('enseignants.create') }}" class="btn btn-primary">Ajouter</a></div>
<table class="table"><thead><tr><th>Nom</th><th>Email</th><th></th></tr></thead><tbody>
@foreach($enseignants as $enseignant)
<tr><td>{{ $enseignant->name }}</td><td>{{ $enseignant->email }}</td><td class="text-end"><a href="{{ route('enseignants.edit',$enseignant) }}" class="btn btn-sm btn-warning">Modifier</a>
<form method="POST" class="d-inline" action="{{ route('enseignants.destroy',$enseignant) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Supprimer</button></form></td></tr>
@endforeach
</tbody></table>{{ $enseignants->links() }}
@endsection
