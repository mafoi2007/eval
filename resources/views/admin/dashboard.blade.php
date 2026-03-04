@extends('layouts.app')

@section('content')

<h3>Dashboard Administrateur</h3>

<div class="row">

    <div class="col-md-4">
        <div class="card bg-primary text-white p-3">
            <h4>{{ \App\Models\Classe::count() }}</h4>
            <p>Classes</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white p-3">
            <h4>{{ \App\Models\Eleve::count() }}</h4>
            <p>Élèves</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-warning text-white p-3">
            <h4>{{ \App\Models\Evaluation::count() }}</h4>
            <p>Evaluations</p>
        </div>
    </div>

</div>

@endsection