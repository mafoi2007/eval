@extends('layouts.app')
@section('content')
<h1 class="h3 mb-4">Tableau de bord enseignant</h1>
<div class="row g-3">
    <div class="col-md-3"><div class="card"><div class="card-body"><strong>Enseignants</strong><div class="display-6">{{ $enseignants }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><strong>Élèves</strong><div class="display-6">{{ $eleves }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><strong>Évaluations</strong><div class="display-6">{{ $evaluations }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><strong>Notes publiées</strong><div class="display-6">{{ $notes }}</div></div></div></div>
</div>
@endsection
