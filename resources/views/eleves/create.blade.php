@extends('layouts.app')
@section('content')
<h1 class="h4">Créer un élève</h1>
@include('eleves.form', ['action'=>route('eleves.store'),'method'=>'POST','eleve'=>null])
@endsection