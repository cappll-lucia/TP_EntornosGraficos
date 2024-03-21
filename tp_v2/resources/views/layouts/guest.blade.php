<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
        <div class="d-flex justify-content-center align-items-center vh-70 bg-primary" style="--bs-bg-opacity: .5">
            <div class="container mb-5">
                <div class="text-center mb-2">
                    <p>Registrarse</p>
                </div>

                <div class="card mx-auto bg-light" style="width: 25rem; ">
                    <div class="card-body">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
