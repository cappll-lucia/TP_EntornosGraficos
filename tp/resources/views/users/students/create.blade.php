@extends ('layout.admin')
@section ('content')
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h3 class="m-3 text-center">Registrar Estudiante</h3>
      @if (count($errors)>0)
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
      @endif

      {!!Form::open(array('url'=>'users/students/create','method'=>'POST'))!!}
    <div class="justify-content-center">
      <div class="row px-5 pt-3 justify-content-center">
        <label for="nombre" class="text-sm-end col-form-label col-sm-2">Nombre</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
      </div>
      <div class="row  px-5   pt-3 justify-content-center">
        <label for="apellido" class="text-sm-end col-form-label col-sm-2">Apellido</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="apellido" name="apellido">
        </div>
      </div>
      <div class="row  px-5   pt-3 justify-content-center">
        <label for="email" class="text-sm-end col-form-label col-sm-2">Email</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="email" name="email">
        </div>
      </div>
      <div class="row  px-5   pt-3 justify-content-center">
        <label for="name" class="text-sm-end col-form-label col-sm-2">UserName</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="name" name="name">
        </div>
      </div>
      <div class="row  px-5   pt-3 justify-content-center">
        <label for="clave" class="text-sm-end col-form-label col-sm-2">Contraseña</label>
        <div class="col-sm-3">
          <input type="password" class="form-control" id="clave" name="clave">
        </div>
      </div>
      <div class="mt-3 row justify-content-center">
        <div class="flex-row col-sm-4 col-10 d-flex">
          <button type="button" class="w-50 btn btn-outline-primary" onclick="cancelar()">Cancelar</button>
          <button class="w-50 btn btn-primary ms-2" type="submit">Registrar</button>
        </div>
      </div>
    </div>
      {!!Form::close()!!}
  </div>

<script>
  function cancelar(){
    window.location.href = '/users/students';
  }
</script>

@stop