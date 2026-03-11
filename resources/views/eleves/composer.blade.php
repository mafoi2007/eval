@extends('layouts.app')
@section('content')
<h1 class="h4">Composer : {{ $evaluation->titre }}</h1>
<p>{{ $evaluation->description }}</p>
<form method="POST" action="{{ route('eleve.composer.store',$evaluation) }}" class="card card-body">@csrf
<label class="form-label">Votre composition / réponse</label>
<textarea class="form-control" name="contenu" rows="6">{{ old('contenu', $note?->contenu) }}</textarea>
@error('contenu')<small class="text-danger">{{ $message }}</small>@enderror
<button class="btn btn-success mt-3">Soumettre</button>
</form>
@endsection