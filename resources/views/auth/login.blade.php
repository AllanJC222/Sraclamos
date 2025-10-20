@extends('layouts.app2')
@section('content')
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Modern</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      /* Colores principales */
      --bg1: #0039be9d;
      --bg2: #2400c780;
      --accent: #ada3d6ff;
    }

    *{box-sizing:border-box}
    html,body{height:100%;margin:0;padding:0}

    /* ===== Fondo principal ===== */
    /* ===== background: linear-gradient(135deg,var(--bg1) 0%, var(--bg2) 60%); ===== */
    body{
      font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color:  #777171e8;
      display:flex;
      flex-direction:column;
      min-height:100vh;
    }

    /* ===== Navbar ===== */
    /* Estilos para la barra de navegación */
    .main-navbar {
        display: flex;
        flex-wrap: nowrap;
        justify-content: flex-start;
        padding: 0.5rem 1rem;
        background-color: #12343b; /* Color de fondo oscuro, similar a Bootstrap */
    }

    /* Enlace de la marca (brand) */
    .brand-link {
        padding-top: 0.3125rem;
        padding-bottom: 0.3125rem;
        margin-right: 1rem;
        font-size: 1.25rem;
        color: #fff; /* Color del texto */
        text-decoration: none;
        white-space: nowrap;
    }

    /* Estilos para los enlaces de navegación */
    .nav-links {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-item {
        margin-right: 1rem;
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.55); /* Color de enlace inactivo */
        padding: 0.5rem 0.5rem;
        text-decoration: none;
    }

    .nav-link.current {
        color: #fff; /* Color de enlace activo */
        border-bottom: 2px solid #fff;
    }

    /* ===== Contenedor principal (formulario + panel informativo) ===== */
    main{
      flex:1;
      display:grid;
      place-items:center;
      padding:32px;
    }
    .container{
      width:100%;
      max-width:980px;
      display:grid;
      grid-template-columns:1fr 420px;
      gap:0;
      align-items:stretch;
      border-radius:14px;
      overflow:hidden;
      box-shadow:0 10px 30px rgba(232, 233, 240, 0.6);
      background: #fff;
    }

    /* ===== Panel informativo ===== */
    .hero{
      padding:28px;
      background: #2c7f90;
      display:flex;
      flex-direction:column;
      justify-content:center;
      color:#fff;
    }
    .hero h1{font-size:26px;margin:0 0 12px 0;letter-spacing:-0.2px}
    .hero p{margin:0;color:#e0e0e0;line-height:1.5}

    /* ===== Formulario ===== */
    .card{
      padding:32px;
      background:#fff;
      color:#000;
      display:flex;
      flex-direction:column;
      justify-content:center;
    }

    .brand h2{margin:0 0 10px;font-size:20px;color:#0d4f8b}
    .brand p{margin:0;font-size:14px;color:#666}

    /* ===== Campos de entrada ===== */
    form{display:flex;flex-direction:column;gap:12px}
    .field{position:relative;}
    input[type="text"], input[type="password"], input[type="email"]{
      width:100%;
      padding:12px;
      border-radius:6px;
      border:1px solid #ccc;
      font-size:14px;
    }
    input:focus{border-color:#0d4f8b;outline:none;}

    /* ===== Opciones extra (recordarme/olvidé contraseña) ===== */
    .options{display:flex;justify-content:space-between;align-items:center;margin-top:4px;font-size:13px}
    .options a{color:#0d4f8b;text-decoration:none}
    .options label{color:#333;display:flex;gap:6px;align-items:center}

    /* ===== Botón principal ===== */
    .btn{
      margin-top:6px;padding:12px;border-radius:6px;border:0;cursor:pointer;font-weight:600;font-size:15px;
      background:#0d4f8b;
      color:#fff;
    }

    /* ===== Texto pequeño y botones sociales ===== */
    .small{font-size:13px;color:#555;text-align:center;margin-top:12px}
    .social{display:flex;gap:8px;margin-top:10px}
    .social button{flex:1;padding:10px;border-radius:6px;border:1px solid #ccc;background:#f8f8f8;cursor:pointer}

    /* ===== Responsivo ===== */
    @media(max-width:880px){
      .container{grid-template-columns:1fr;}
      .hero{display:none}
    }
  </style>
</head>
<body>
   <!-- Barra de navegación -->
   <nav class="main-navbar">
        <div class="container-fluid">
           
                <ul class="nav-links">
                     <a class="brand-link" href="{{ url('/categoria/crear') }}">Mi Aplicación</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                    <li class="nav-item">
                        <a class="nav-link current" aria-current="page" href="{{ url('/') }}">Inicio</a>
                    </li>
                </ul>
          
        </div>
    </nav>

  <!-- Contenido principal -->
  <main>
    <section class="container">
      <!-- Panel izquierdo informativo -->
      <section class="hero">
        <h1>Aguas de Choluteca</h1>
        <p>Bienvenido al sistema de gestión de abonados.<br>
        Aquí podrás administrar tu cuenta, revisar tus facturas y más.</p>
      </section>

      <!-- Formulario de login -->
      <aside class="card">
        <div class="brand">
          <h2>Ingreso Usuario</h2>
          <p>Introduce tus credenciales para continuar</p>
        </div>

        <form  method="POST" action="{{ route('login') }}" >
          @csrf
          <div class="field">
            <input id="user_name" name="user_name" type="text" placeholder="Nombre de Usuario" required />
          </div>
          <div class="field">
            <input id="user_pass" name="user_pass" type="password" placeholder="Contraseña" required />
          </div>

          <div class="options">
            <label><input type="checkbox" name="remember" /> Recordarme</label>
            <a href="#">¿Olvidaste tu contraseña?</a>
          </div>

          <button class="btn" type="submit">Ingresar</button>
          <div class="small">Usuario de Aguas Choluteca</div>
        </form>
        @if ($errors ->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                     @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                     @endforeach
                </ul>
            </div>
        @endif
      </aside>
    </section>
  </main>


</body>
</html>
