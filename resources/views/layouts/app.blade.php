<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SISTEMA RECLAMOS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/appblade-styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="d-flex flex-column h-100">

    @auth('usuariolog')

        <header class="navbar navbar-expand-lg sticky-top bg-body-tertiary shadow-sm">
            <div class="container-fluid">
                <button class="btn custom-btn-toggle" type="button" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <a class="navbar-brand ms-3" href="#">Sistema Reclamos</a>
                <div class="ms-auto">
                    <a class="btn btn-light" href="#">
                        <i class="bi bi-person-circle"></i> Hola, {{ auth()->guard('usuariolog')->user()->user_name }}!
                    </a>
                </div>
            </div>
        </header>
        <div class="d-flex flex-grow-1">

            <aside class="offcanvas-start sidebar-custom-color text-white p-3 d-lg-block d-flex flex-column" tabindex="-1"
                id="sidebarMenu" aria-labelledby="sidebarMenuLabel" style="width: var(--sidebar-width);">

                <div class="offcanvas-header border-bottom border-secondary">
                    <h5 class="offcanvas-title text-white" id="sidebarMenuLabel">Menú Principal</h5>
                    <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <div class="offcanvas-body flex-grow-1 p-0 overflow-auto">
                    <nav class="nav flex-column mt-3">

                        @if (auth()->guard('usuariolog')->user()->user_tipo == '1')

                            <a class="nav-link text-white-50" href="{{ route('dashboard') }}">Dashboard</a>

                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#sectorCollapse" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="sectorCollapse">
                                    Sector
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="sectorCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('sectores.crear') }}">Crear Sector</a>
                                    </li>
                                    <li><a class="nav-link text-white-50" href="{{ route('sectores.leer') }}">Listar Sector</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#barriosCollapse" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="barriosCollapse">
                                    Barrios
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="barriosCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('barrios.crear') }}">Crear Barrio</a>
                                    </li>
                                    <li><a class="nav-link text-white-50" href="{{ route('barrios.leer') }}">Listar Barrio</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#abonadosCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="abonadosCollapse">
                                    Abonado
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="abonadosCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('abonados.crear') }}">Crear Abonado</a>
                                    </li>
                                    <li><a class="nav-link text-white-50" href="{{ route('abonados.leer') }}">Listar
                                            Abonados</a></li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#noticiasCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="noticiasCollapse">
                                    Lista Noticias
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="noticiasCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('noticias.crear') }}">Crear Noticia</a>
                                    </li>
                                    <li><a class="nav-link text-white-50" href="{{ route('noticias.leers') }}">Listar
                                            Noticia</a></li>
                                    <li><a class="nav-link text-white-50" href="{{ route('noticias.leers') }}">Eliminar</a></li>
                                </ul>
                            </li>

                            <div class="offcanvas-header border-bottom border-secondary">
                                <h5 class="offcanvas-title text-white" id="sidebarMenuLabel">Gestion de Usuarios</h5>
                                <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#usuariosCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="usuariosCollapse">
                                    Empleados
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="usuariosCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('usuarios.crear') }}">Crear
                                            Usuarios</a></li>
                                    <li><a class="nav-link text-white-50" href="{{ route('usuarios.leer') }}">Listar
                                            Usuarios</a></li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#usuarioslogsCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="usuarioslogsCollapse">
                                    Usuarios
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="usuarioslogsCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('registrarse.crearlogs') }}">Crear
                                            Usuarios</a></li>
                                    <li><a class="nav-link text-white-50" href="{{ route('usuariolog.leer') }}">Listar
                                            Usuarios</a></li>

                                </ul>
                            </li>



                            <div class="offcanvas-header border-bottom border-secondary">
                                <h5 class="offcanvas-title text-white" id="sidebarMenuLabel">Gestion de Reclamos</h5>
                                <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#reclamosCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="reclamosCollapse">
                                    Reclamos
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="reclamosCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('reclamos.crear') }}">Crear Reclamo</a>
                                    </li>
                                    <li><a class="nav-link text-white-50" href="{{ route('reclamos.leer') }}">Listar
                                            Reclamos</a></li>
                                    <li>
                                        <hr class="dropdown-divider bg-white">
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#categoriaCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="categoriaCollapse">
                                    Categoria Reclamos
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="categoriaCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('categoria.crear') }}">Crear
                                            Categoria</a></li>
                                    <li><a class="nav-link text-white-50" href="{{ route('categoria.leer') }}">Listar
                                            Categorias</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#distribucionCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="distribucionCollapse">
                                    Distribución Operador
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="distribucionCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('distribucion.crear') }}">Crear
                                            Distribución</a></li>
                                    <li><a class="nav-link text-white-50" href="{{ route('distribucion.index') }}">Listar</a>
                                    </li>
                                </ul>
                            </li>

                        @else
                            <a class="nav-link text-white-50" href="{{ route('dashboard') }}">Dashboard</a>

                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#sectorCollapse" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="sectorCollapse">
                                    Sector
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="sectorCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('sectores.crear') }}">Crear Sector</a>
                                    </li>
                                    <li><a class="nav-link text-white-50" href="{{ route('sectores.leer') }}">Listar Sector</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#barriosCollapse" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="barriosCollapse">
                                    Barrios
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="barriosCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('barrios.crear') }}">Crear Barrio</a>
                                    </li>
                                    <li><a class="nav-link text-white-50" href="{{ route('barrios.leer') }}">Listar Barrio</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#abonadosCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="abonadosCollapse">
                                    Abonado
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="abonadosCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('abonados.crear') }}">Crear Abonado</a>
                                    </li>
                                    <li><a class="nav-link text-white-50" href="{{ route('abonados.leer') }}">Listar
                                            Abonados</a></li>
                                </ul>
                            </li>

                            <div class="offcanvas-header border-bottom border-secondary">
                                <h5 class="offcanvas-title text-white" id="sidebarMenuLabel">Gestion de Colaboradores</h5>
                                <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#usuariosCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="usuariosCollapse">
                                    Usuarios de Operadores
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="usuariosCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('usuarios.crear') }}">Crear
                                            Operadores</a></li>
                                    <li><a class="nav-link text-white-50" href="{{ route('usuarios.leer') }}">Listar
                                            Operadores</a></li>
                                </ul>
                            </li>
                            <div class="offcanvas-header border-bottom border-secondary">
                                <h5 class="offcanvas-title text-white" id="sidebarMenuLabel">Gestion de Reclamos</h5>
                                <button type="button" class="btn-close btn-close-white d-lg-none" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#reclamosCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="reclamosCollapse">
                                    Reclamos
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="reclamosCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('reclamos.crear') }}">Crear Reclamo</a>
                                    </li>
                                    <li><a class="nav-link text-white-50" href="{{ route('reclamos.leer') }}">Listar
                                            Reclamos</a></li>
                                    <li>
                                        <hr class="dropdown-divider bg-white">
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white dropdown-toggle" href="#categoriaCollapse"
                                    data-bs-toggle="collapse" role="button" aria-expanded="false"
                                    aria-controls="categoriaCollapse">
                                    Categoria Reclamos
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="categoriaCollapse">
                                    <li><a class="nav-link text-white-50" href="{{ route('categoria.crear') }}">Crear
                                            Categoria</a></li>
                                    <li><a class="nav-link text-white-50" href="{{ route('categoria.leer') }}">Listar
                                            Categorias</a></li>
                                </ul>
                            </li>


                        @endif
                    </nav>
                </div>

                <div class="mt-auto p-3">
                    <hr class="text-white-50">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger w-100" type="submit">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </aside>

            <main class="flex-grow-1 p-4">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
        </div>
    @endauth

    @guest('usuariolog')
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    @endguest

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>

        // En tu código actual:
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.getElementById('sidebarToggle');
            if (toggleButton) {
                toggleButton.addEventListener('click', function () {
                    // Esto solo añade o quita una clase. NO usa el Offcanvas de Bootstrap.
                    document.body.classList.toggle('sidebar-closed');
                });
            }
        });

    </script>

</body>

</html>