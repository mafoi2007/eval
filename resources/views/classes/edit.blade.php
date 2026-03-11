@extends('layouts.app')
@section('content')
<h1 class="h4">Modifier la classe</h1>
<form method="POST" action="{{ route('classes.update',$classe) }}" class="card card-body">@csrf @method('PUT')
<label class="form-label">Nom</label><input class="form-control" name="nom" value="{{ old('nom',$classe->nom) }}">
@error('nom')<small class="text-danger">{{ $message }}</small>@enderror
<button class="btn btn-primary mt-3">Mettre à jour</button>
</form>
@endsection