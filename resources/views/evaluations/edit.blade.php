@extends('layouts.app')
@section('content')
<h1 class="h4">Modifier une évaluation</h1>
@include('evaluations.form', ['action'=>route('evaluations.update',$evaluation),'method'=>'PUT','evaluation'=>$evaluation])
@endsection