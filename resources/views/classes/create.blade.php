@extends('layouts.app')
@section('content')
<h1 class="h4">Créer une classe</h1>
<form method="POST" action="{{ route('classes.store') }}" class="card card-body">@csrf
<label class="form-label">Nom</label><input class="form-control" name="nom" value="{{ old('nom') }}">
@error('nom')<small class="text-danger">{{ $message }}</small>@enderror
<button class="btn btn-primary mt-3">Enregistrer</button>
</form>
@endsection