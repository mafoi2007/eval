@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Évaluations</h1><a href="{{ route('evaluations.create') }}" class="btn btn-primary">Nouvelle évaluation</a></div>
<table class="table table-bordered"><thead><tr><th>Titre</th><th>Classe</th><th></th></tr></thead><tbody>
@foreach($evaluations as $evaluation)
<tr><td>{{ $evaluation->titre }}</td><td>{{ $evaluation->classe->nom }}</td><td class="text-end">
<a class="btn btn-sm btn-info" href="{{ route('notes.index',$evaluation) }}">Notes</a>
<a class="btn btn-sm btn-warning" href="{{ route('evaluations.edit',$evaluation) }}">Modifier</a>
<form class="d-inline" method="POST" action="{{ route('evaluations.destroy',$evaluation) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Supprimer</button></form></td></tr>
@endforeach
</tbody></table>{{ $evaluations->links() }}
@endsection
