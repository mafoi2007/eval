@extends('layouts.app')

@section('content')

<h3>Ma note</h3>

@if($note)
    <div class="alert alert-success">
        Note obtenue : <strong>{{ $note->valeur }}</strong>
    </div>
@else
    <div class="alert alert-warning">
        Aucune note disponible.
    </div>
@endif

@endsection