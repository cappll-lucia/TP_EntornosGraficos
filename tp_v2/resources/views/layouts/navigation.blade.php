<nav x-data="{ open: false }" class="header bg-light border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="bg-light  px-1 sm:px-6 lg:px-8">
        <div class="h-16 d-flex justify-content-between align-items-center">
            <div class="flex justify-content-center align-items-center">
                <!-- Logo -->
                <a class="navbar-brand" href="{{route('welcome')}}">
                    <div class="container mr-100 ml-1">
                       <img src="{{ asset('UTN_logo.jpg') }}" alt="UTN Logo" height="50" width="65" >
                    </div>
                </a>
                <h1 class="">UTN FRRo</h1>
            </div>


            @if(Auth::check())
            <!-- Buttons logueado -->
            <div class="dropdown usr-menu justify-content-md-end">
              <span class="px-5">Bienvenido, {{Auth::user()->first_name}}!</span>
                <button class="btn usr-menu-btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa-solid fa-user"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('profile.edit') }}">
                            {{ __('Perfil') }}
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a  href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </a>
                </form> 
                    </li>
                </ul>
            </div>


        </div>
            @else
            <!-- Buttons no logueado -->
            <div class="container-fluid gap-2 d-grid d-md-flex justify-content-md-end">

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
    <nav class="bg-body-tertiary navbar navbar-expand-lg">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Docentes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Consultas</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Ver más
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
    </nav>
</nav>

<article>
    @yield('content')
</article>

<footer class="p-3 footer d-flex justify-content-between">
      <div class="left">
        <h2>Sobre Nosotros</h2>
        <p>UTN: Universidad Tecnológica Nacional</p>
      </div>

      <div class="right text-end">
        <h2>Contacto</h2>
        <a href="#">lorem ipsum</a>
      </div>
</footer>