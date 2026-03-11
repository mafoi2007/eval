@extends('layouts.app')
@section('content')
<h1 class="h4">Créer une évaluation</h1>
@include('evaluations.form', ['action'=>route('evaluations.store'),'method'=>'POST','evaluation'=>null])
@endsection