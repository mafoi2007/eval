@extends('layouts.app')
@section('content')
<h1 class="h4">Créer un administrateur</h1>
@include('enseignants.form', ['action'=>route('enseignants.store'),'method'=>'POST','enseignant'=>null])
@endsection