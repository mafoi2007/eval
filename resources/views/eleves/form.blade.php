<form method="POST" action="{{ $action }}" class="card card-body">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <label class="form-label">Nom</label>
    <input class="form-control" name="name" value="{{ old('name', $eleve?->user?->name) }}">

    <label class="form-label mt-2">Email</label>
    <input class="form-control" name="email" type="email" value="{{ old('email', $eleve?->user?->email) }}">

    <label class="form-label mt-2">Classe</label>
    <select class="form-select" name="classe_id">
        @foreach($classes as $classe)
            <option value="{{ $classe->id }}" @selected(old('classe_id',$eleve?->classe_id)==$classe->id)>{{ $classe->nom }}</option>
        @endforeach
    </select>

    <label class="form-label mt-2">Mot de passe {{ $method !== 'POST' ? '(laisser vide pour garder)' : '' }}</label>
    <input class="form-control" name="password" type="password">
    <label class="form-label mt-2">Confirmation</label>
    <input class="form-control" name="password_confirmation" type="password">

    @if($errors->any())<div class="alert alert-danger mt-3"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <button class="btn btn-primary mt-3">Enregistrer</button>
</form>
