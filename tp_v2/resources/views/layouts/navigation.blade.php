<nav x-data="{ open: false }" class="bg-light border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="bg-light  px-1 sm:px-6 lg:px-8">
        <div class="h-16 d-flex justify-content-between align-items-center">
            <div class="flex">
                <!-- Logo -->
                <a class="navbar-brand" href="{{route('welcome')}}">
                    <div class="container mr-100 ml-1">
                        <img src="/public/UTN_logo.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-top">
                    </div>
                </a>

                <h2 class="">UTN FRRo</h2>

            </div>


            @if(Auth::check())
            <!-- Buttons logueado -->
            <div class="container-fluid gap-2 d-grid d-md-flex justify-content-md-end d-none d-md-block">
                <button class="">
                    <div>Hola, {{ Auth::user()->first_name }}!</div>
                </button>

                <a type="button" class="btn btn-outline-primary" href="{{ route('profile.edit') }}">
                    {{ __('Perfil') }}
                </a>

            
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a type="button" class="btn btn-outline-danger" href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </a>
                </form>
            </div>
            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

            <!-- Responsive Settings Options -->
            
            <div class="border-t border-gray-200 pt-4 pb-1 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="space-y-1 mt-3">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>
                
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
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

            <!-- Hamburger -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open" class="rounded-md p-2 transition ease-in-out text-gray-400 duration-150 inline-flex items-center justify-center dark:text-gray-500 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-500 dark:hover:bg-gray-900 dark:hover:text-gray-400 dark:focus:bg-gray-900 dark:focus:text-gray-400">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
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