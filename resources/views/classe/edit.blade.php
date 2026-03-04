@extends('layouts.app')

@section('content')

<h3>{{ isset($classe) ? 'Modifier' : 'Ajouter' }} Classe</h3>

<form method="POST"
      action="{{ isset($classe) ? route('classes.update',$classe) : route('classes.store') }}">

    @csrf
    @if(isset($classe)) @method('PUT') @endif

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control"
               value="{{ $classe->nom ?? '' }}" required>
    </div>

    <button class="btn btn-primary">Enregistrer</button>

</form>

@endsection