<!DOCTYPE html>
<html>
<head>
    <title>Application Evaluation</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Evaluation</a>

        <div>
            @auth
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('classes.index') }}" class="btn btn-outline-light btn-sm">Classes</a>
                    <a href="{{ route('eleves.index') }}" class="btn btn-outline-light btn-sm">Élèves</a>
                    <a href="{{ route('evaluations.index') }}" class="btn btn-outline-light btn-sm">Evaluations</a>
                @endif

                @if(auth()->user()->role == 'eleve')
                    <a href="{{ url('ma-note') }}" class="btn btn-outline-light btn-sm">Ma note</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-danger btn-sm">Déconnexion</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>