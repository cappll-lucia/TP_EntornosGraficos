<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css ">
    <title></title>
</head>

<body>
    <nav class="bg-body-tertiary navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/public/UTN_logo.png" alt="Logo" width="100" height="100    " class="d-inline-block align-text-top">
            </a>
            <span class="titulo">UTN FRRo</span>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button class="btn btn-outline-primary me-md-2" type="button" onclick="">Iniciar sesión</button>
              <button class="btn btn-outline-primary" type="button" onclick=" ">Registrarse</button>
            </div>
        </div>
    </nav>
    <div class="border"></div>
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

    <article>
        @yield('content')
    </article>

    <footer class="footer d-flex justify-content-between p-3">
      <div class="left">
        <h2>Sobre Nosotros</h2>
        <p>UTN: Universidad Tecnológica Nacional</p>
      </div>

      <div class="right text-end">
        <h2>Contacto</h2>
        <a href="#">lorem ipsum</a>
      </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>