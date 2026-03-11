@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Classes</h1><a href="{{ route('classes.create') }}" class="btn btn-primary">Nouvelle classe</a></div>
<table class="table table-striped"><thead><tr><th>Nom</th><th>Élèves</th><th>Évaluations</th><th></th></tr></thead><tbody>
@foreach($classes as $classe)
<tr><td>{{ $classe->nom }}</td><td>{{ $classe->eleves_count }}</td><td>{{ $classe->evaluations_count }}</td><td class="text-end"><a class="btn btn-sm btn-warning" href="{{ route('classes.edit',$classe) }}">Modifier</a>
<form class="d-inline" method="POST" action="{{ route('classes.destroy',$classe) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Supprimer</button></form></td></tr>
@endforeach
</tbody></table>{{ $classes->links() }}
@endsection
