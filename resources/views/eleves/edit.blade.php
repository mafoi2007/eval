@extends('layouts.app')
@section('content')
<h1 class="h4">Modifier un élève</h1>
@include('eleves.form', ['action'=>route('eleves.update',$eleve),'method'=>'PUT','eleve'=>$eleve])
@endsection