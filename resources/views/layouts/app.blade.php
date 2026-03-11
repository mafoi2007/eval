<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gestion Évaluations</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container">
                <a class="navbar-brand" href="{{ route('dashboard') }}">Évaluation App</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button>
                <div id="menu" class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto">
                     @if(auth()->check() && auth()->user()->role === 'enseignant')
                        <li class="nav-item"><a class="nav-link" href="{{ route('enseignants.index') }}">Admins</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('classes.index') }}">Classes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('eleves.index') }}">Élèves</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('evaluations.index') }}">Évaluations</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('eleve.evaluations') }}">Mes évaluations</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('eleve.notes') }}">Mes notes</a></li>
                    @endif
                    </ul>
                    @auth
                    <span class="text-white me-3">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-light btn-sm">Déconnexion</button></form>
                     @endauth
                </div>
            </div>
        </nav>

        <div class="container pb-5">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @yield('content')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>