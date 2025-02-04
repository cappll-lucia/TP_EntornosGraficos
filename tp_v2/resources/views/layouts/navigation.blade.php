<head>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<div class="flex-column min-vh-100 d-flex">
  <nav x-data="{ open: false }" class="bg-light border-b border-gray-100 header">
    <!-- Primary Navigation Menu -->
    <div class="bg-light  px-1 header-line sm:px-6 lg:px-8">
      <div class="h-10 d-flex justify-content-between align-items-center">
        <div class="flex justify-content-center align-items-center">
          <!-- Logo -->

          <div class="container mr-100 ml-1 mb-10">
            <a class="navbar-brand" href="{{route('welcome')}}">
              <!-- Imagen para pantallas grandes -->
              <img src="{{ asset('logo-utn.png') }}" alt="UTN Logo" class="logo-desktop" height="80" width="400">
              <!-- Imagen para dispositivos móviles -->
              <img src="{{ asset('utn-logo-mobile.png') }}" alt="UTN Logo Mobile" class="logo-mobile" height="60"
                width="60">
            </a>
          </div>

        </div>

        @if(Auth::check())
        <!-- Buttons logueado -->
        <div class="px-4 dropdown usr-menu justify-content-md-end">
          <span class="px-2">Hola, {{Auth::user()->first_name}}!</span>
          <button class="btn usr-menu-btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
          aria-expanded="false" style="background-color:rgb(50, 146, 255); color: white;">
          <!-- Contenido del botón -->
          <i class="fa-solid fa-user"></i>
          </button>
          <ul class="dropdown-menu">
          <li>
            <a href="{{ route('profile.edit') }}" class="d-block px-3 py-2 text-decoration-none">
            {{ __('Perfil') }}
            </a>
          </li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="route('logout')" onclick="event.preventDefault();
        this.closest('form').submit();" class="d-block px-3 py-2 text-decoration-none">
              {{ __('Cerrar sesión') }}
            </a>
            </form>
          </li>
          </ul>
        </div>
    @else
    <!-- Buttons no logueado -->
    <div class="gap-2 d-grid d-md-flex justify-content-md-end">
      <a type="button" class="btn btn-outline-primary" href="{{ route('login') }}">
      {{ __('Ingresar') }}
      </a>
      <a type="button" class="btn btn-outline-primary" href="{{ route('register') }}">
      {{ __('Registrarse') }}
      </a>
    </div>
  @endif
      </div>
    </div>


    <nav id="desplegable" class="navbar navbar-expand-md">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="{{ route('welcome') }}">Inicio</a>
            </li>
            @if(Auth::check())

        <li class="nav-item">
          <a class="nav-link" href="{{ route('getPps') }}">Solicitudes</a>
        </li>
        @if(Auth::user()->role_id == '4')
      <li class="nav-item">
        <a class="nav-link" href="{{ route('getTeachers') }}">Docentes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('getStudents') }}">Alumnos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('getResponsibles') }}">Responsables</a>
      </li>
    @endif
      @endif
          </ul>
        </div>
      </div>
    </nav>
  </nav>

  <main class="flex-grow-1">
    <article>
      @yield('content')
    </article>
  </main>


  <footer class="p-3 footer d-flex justify-content-between">
    <div class="left">
      <h2>Sobre Nosotros</h2>
      <p>UTN: Universidad Tecnológica Nacional</p>
    </div>

    <div class="right text-end">
      <h2>Contacto</h2>
      <p> 0341 - 4481871</p>
    </div>
  </footer>
</div>

<style>
  /* Por defecto, solo se muestra el logo de escritorio */
  .logo-mobile {
    display: none;
  }

  /* En pantallas pequeñas (menos de 768px), cambia la visibilidad */
  @media (max-width: 768px) {
    .logo-desktop {
      display: none !important;
    }

    .logo-mobile {
      display: block !important;
    }
  }
</style>

<script>
  @yield('scripts')
</script>