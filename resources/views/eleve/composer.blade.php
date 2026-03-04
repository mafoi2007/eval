@extends('layouts.app')

@section('content')

<h3>Composer : {{ $evaluation->titre }}</h3>

<form method="POST">
    @csrf

    <div class="mb-3">
        <label>Votre note (simulation)</label>
        <input type="number" name="valeur" class="form-control" required>
    </div>

    <button class="btn btn-success">Valider</button>
</form>

@endsection