@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Élèves</h1><a href="{{ route('eleves.create') }}" class="btn btn-primary">Nouvel élève</a></div>
<table class="table table-bordered"><thead><tr><th>Nom</th><th>Email</th><th>Classe</th><th></th></tr></thead><tbody>
@foreach($eleves as $eleve)
<tr><td>{{ $eleve->user->name }}</td><td>{{ $eleve->user->email }}</td><td>{{ $eleve->classe->nom }}</td><td class="text-end"><a href="{{ route('eleves.edit',$eleve) }}" class="btn btn-sm btn-warning">Modifier</a>
<form class="d-inline" method="POST" action="{{ route('eleves.destroy',$eleve) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Supprimer</button></form></td></tr>
@endforeach
</tbody></table>{{ $eleves->links() }}
@endsection
