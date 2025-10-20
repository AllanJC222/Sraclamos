<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aguas de Choluteca</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* ESTILOS ESPECÍFICOS DEL SITIO */
        :root {
            --primary-color: #2e64a1; /* Azul principal */
            --dark-overlay: rgba(0, 0, 0, 0.4);
        }

        body {
            font-family: 'Figtree', sans-serif;
        }

        /* AJUSTE CLAVE: NAVBAR POSICIONADO ENCIMA DE TODO */
        .navbar-custom {
            position: fixed; /* CAMBIO CLAVE: Usa 'fixed' para mantenerlo en la parte superior del viewport */
            width: 100%;
            top: 0;
            z-index: 1000; /* Alto z-index para asegurar que esté encima de otros elementos */
            background-color: transparent; /* Fondo transparente por defecto */
            transition: background-color 0.3s ease;
        }

        /* Color del navbar cuando se hace scroll */
        .navbar-scrolled {
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        /* ESTILO DEL NAVBAR */
        .navbar-custom .nav-link,
        .navbar-custom .navbar-brand {
            color: white !important;
            font-weight: 600;
        }

        .navbar-brand img {
            height: 80px;
        }

        /* ESTILO DE LA SECCIÓN HERO */
        .hero-section {
            position: relative;
            height: 80vh; 
            background-image: url('{{ asset('backaguas1.jpg') }}');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding-top: 56px; /* Para que el contenido no quede debajo del navbar fijo */
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--dark-overlay);
        }

        .hero-content {
            z-index: 1;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .btn-contact {
            background-color: transparent;
            color: white;
            border: 2px solid white;
            padding: 0.75rem 2rem;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-contact:hover {
            background-color: white;
            color: var(--primary-color);
        }

        /* ESTILO DE LAS CARDS DE SERVICIOS */
        .services-section {
            background-color: var(--primary-color);
            color: white;
            padding: 3rem 0;
        }

        .service-card {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            padding: 1.5rem;
            text-align: center;
            border-radius: 10px;
        }

        .service-card h5 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom" id="mainNavbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('aguaslogo.avif') }}" alt="Aguas de Choluteca Logo">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Empresa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light ms-lg-3" href="{{ url('login') }}">LOGIN</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Aguas de Choluteca <br> SA de CV</h1>
            <p class="hero-subtitle">Proveedores de los servicios de Agua Potable y Saneamiento</p>
            <a href="#" class="btn-contact">Contáctanos</a>
        </div>
    </header>

    <section class="services-section">
        <div class="container py-5">
            <div class="row row-cols-1 row-cols-md-3 g-4">

                <!-- Opción 1: Crear Reclamo -->
                <div class="col">
                    <div class="service-card">
                        <h5>Registrar Reclamo</h5>
                        <p>Realiza tu reclamo de forma rápida, sin necesidad de iniciar sesión.</p>
                        <a href="{{ route('reclamos.publico.crear') }}" class="btn-contact">Ingresar</a>
                    </div>
                </div>

                <!-- Opción 2: Consultar Reclamo -->
                <div class="col">
                    <div class="service-card">
                        <h5>Seguimiento de Reclamo</h5>
                        <p>Consulta el estado de tu reclamo usando tu código de seguimiento.</p>
                        <a href="{{ route('reclamos.publico.consulta') }}" class="btn-contact">Consultar</a>
                    </div>
                </div>

                <!-- Opción 3: Usuarios Internos -->
                <div class="col">
                    <div class="service-card">
                        <h5>Usuarios Internos</h5>
                        <p>Acceso para personal de Aguas de Choluteca y operadores del sistema.</p>
                        <a href="{{ url('login') }}" class="btn-contact">Ingresar</a>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Script para cambiar el color del navbar al hacer scroll
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    </script>
</body>
</html>