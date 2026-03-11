<form method="POST" action="{{ $action }}" class="card card-body">
@csrf
@if($method !== 'POST') @method($method) @endif
<label class="form-label">Titre</label><input class="form-control" name="titre" value="{{ old('titre',$evaluation?->titre) }}">
<label class="form-label mt-2">Description</label><textarea class="form-control" name="description">{{ old('description',$evaluation?->description) }}</textarea>
<label class="form-label mt-2">Classe</label>
<select class="form-select" name="classe_id">@foreach($classes as $classe)<option value="{{ $classe->id }}" @selected(old('classe_id',$evaluation?->classe_id)==$classe->id)>{{ $classe->nom }}</option>@endforeach</select>
@if($errors->any())<div class="alert alert-danger mt-3"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<button class="btn btn-primary mt-3">Enregistrer</button>
</form>
