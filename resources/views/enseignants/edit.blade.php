@extends('layouts.app')
@section('content')
<h1 class="h4">Modifier un administrateur</h1>
@include('enseignants.form', ['action'=>route('enseignants.update',$enseignant),'method'=>'PUT','enseignant'=>$enseignant])
@endsection