<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aguas de Choluteca')</title>

    <!-- Fuente y Bootstrap -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
            padding-top: 80px;
        }

        nav.navbar {
            background-color: #2e64a1;
        }

        nav .navbar-brand img {
            height: 60px;
        }

        footer {
            background-color: #2e64a1;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 4rem;
        }
    </style>
</head>
<body>
    <!-- 🔹 NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('aguaslogo.avif') }}" alt="Logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reclamos.publico.crear') }}">Registrar Reclamo</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reclamos.publico.consulta') }}">Consultar Reclamo</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 🔹 CONTENIDO DE CADA VISTA -->
    <main class="container mt-4">
        @yield('content')
    </main>

    <footer>
        <p class="mb-0">&copy; {{ date('Y') }} Aguas de Choluteca S.A. de C.V. — Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
