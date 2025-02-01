<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('favicon-utn.png') }}">

    <title></title>
</head>
<body>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])



    @include('layouts.navigation')



</body>

</html>

<style>
    /*@import '~@fortawesome/fontawesome-free/scss/fontawesome';
@import '~@fortawesome/fontawesome-free/scss/regular';
@import '~@fortawesome/fontawesome-free/scss/brands';
@import '~@fortawesome/fontawesome-free/scss/solid';*/

.footer {
    width: 100%;
    position: relative;
    bottom: 0;
    background-color: #cfcccc;
}

.page-body {
    min-height: 70vh;
}

.navbar {
    background-color: rgb(34, 167, 211);
}

.usr-menu-btn {
    color: blue;
}

.header {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

.modal-content {
    color: black;
}

.usr-menu ul {
    padding: 0;
    overflow: hidden;
}
.usr-menu ul li {
    padding: 1rem;
}

.usr-menu ul li:hover {
    background-color: rgb(219, 218, 218);
}

html, body {
    height: 100%;
    margin: 0;
  }
  
.min-vh-100 {
    min-height: 100vh;
}
  
.flex-grow-1 {
    flex-grow: 1;
}


</style>