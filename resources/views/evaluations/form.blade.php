<form method="POST" action="{{ $action }}" class="card card-body">
@csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    <label class="form-label">Titre</label>
    <input class="form-control" name="titre" value="{{ old('titre', $evaluation?->titre) }}">

    <label class="form-label mt-2">Description</label>
    <textarea class="form-control" name="description">{{ old('description', $evaluation?->description) }}</textarea>

    <label class="form-label mt-2">Classe</label>
    <select class="form-select" name="classe_id">
        @foreach($classes as $classe)
            <option value="{{ $classe->id }}" @selected(old('classe_id', $evaluation?->classe_id) == $classe->id)>{{ $classe->nom }}</option>
        @endforeach
    </select>

    @php
        $questionsInitiales = old('questions', $evaluation?->questions?->map(fn ($q) => [
            'type' => $q->type,
            'intitule' => $q->intitule,
            'choix_a' => $q->choix_a,
            'choix_b' => $q->choix_b,
            'choix_c' => $q->choix_c,
            'choix_d' => $q->choix_d,
            'bonne_reponse' => $q->bonne_reponse,
            'points' => $q->points,
        ])->toArray() ?? []);
    @endphp

    <hr class="my-4">
    <label class="form-label">Nombre de questions (1 à 20)</label>
    <input id="question-count" class="form-control" type="number" min="1" max="20" value="{{ max(1, count($questionsInitiales)) }}">

    <div id="questions-container" class="mt-3"></div>

    <small class="text-muted">La somme des pondérations doit être exactement égale à 20.</small>

    @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <button class="btn btn-primary mt-3">Enregistrer</button>
</form>

<script>
    const initialQuestions = @json(array_values($questionsInitiales));
    const questionCountInput = document.getElementById('question-count');
    const container = document.getElementById('questions-container');

    function defaultQuestion(index) {
        return {
            type: 'qcm',
            intitule: '',
            choix_a: '',
            choix_b: '',
            choix_c: '',
            choix_d: '',
            bonne_reponse: 'a',
            points: Number((20 / Number(questionCountInput.value || 1)).toFixed(2)),
        };
    }

    function questionCard(index, q = null) {
        const question = q || defaultQuestion(index);
        return `
            <div class="card card-body mb-3">
                <h6>Question ${index + 1}</h6>
                <label class="form-label">Type</label>
                <select class="form-select" name="questions[${index}][type]">
                    <option value="qcm" ${question.type === 'qcm' ? 'selected' : ''}>QCM</option>
                    <option value="vrai_faux" ${question.type === 'vrai_faux' ? 'selected' : ''}>Vrai / Faux</option>
                </select>

                <label class="form-label mt-2">Énoncé</label>
                <textarea class="form-control" name="questions[${index}][intitule]">${question.intitule ?? ''}</textarea>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Choix A</label>
                        <input class="form-control" name="questions[${index}][choix_a]" value="${question.choix_a ?? ''}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Choix B</label>
                        <input class="form-control" name="questions[${index}][choix_b]" value="${question.choix_b ?? ''}">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="form-label">Choix C</label>
                        <input class="form-control" name="questions[${index}][choix_c]" value="${question.choix_c ?? ''}">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="form-label">Choix D</label>
                        <input class="form-control" name="questions[${index}][choix_d]" value="${question.choix_d ?? ''}">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Bonne réponse</label>
                        <select class="form-select" name="questions[${index}][bonne_reponse]">
                            <option value="a" ${question.bonne_reponse === 'a' ? 'selected' : ''}>A</option>
                            <option value="b" ${question.bonne_reponse === 'b' ? 'selected' : ''}>B</option>
                            <option value="c" ${question.bonne_reponse === 'c' ? 'selected' : ''}>C</option>
                            <option value="d" ${question.bonne_reponse === 'd' ? 'selected' : ''}>D</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pondération</label>
                        <input type="number" min="0.25" step="0.25" max="20" class="form-control" name="questions[${index}][points]" value="${question.points ?? ''}">
                    </div>
                </div>
            </div>
        `;
    }

    function renderQuestions() {
        const count = Math.max(1, Math.min(20, Number(questionCountInput.value || 1)));
        questionCountInput.value = count;

        const cards = [];
        for (let i = 0; i < count; i++) {
            cards.push(questionCard(i, initialQuestions[i]));
        }
        container.innerHTML = cards.join('');
    }

    questionCountInput.addEventListener('input', renderQuestions);
    renderQuestions();
</script>