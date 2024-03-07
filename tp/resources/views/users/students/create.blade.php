@extends ('layout.admin')
@section ('content')
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h3 class="text-center">Registrar Estudiante</h3>
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
      <div class="row px-5  pt-3 justify-content-center">
        <label for="nombre" class="col-form-label col-sm-1">Nombre</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
      </div>
      <div class="row  px-5   pt-3 justify-content-center">
        <label for="apellido" class="col-form-label col-sm-1">Apellido</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="apellido" name="apellido">
        </div>
      </div>
      <div class="row  px-5   pt-3 justify-content-center">
        <label for="email" class="col-form-label col-sm-1">Email</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="email" name="email">
        </div>
      </div>
      <div class="row  px-5   pt-3 justify-content-center">
        <label for="name" class="col-form-label col-sm-1">UserName</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="name" name="name">
        </div>
      </div>
      <div class="row  px-5   pt-3 justify-content-center">
        <label for="clave" class="col-form-label col-sm-1">Contraseña</label>
        <div class="col-sm-3">
          <input type="password" class="form-control" id="clave" name="clave">
        </div>
      </div>
      <div class="mx-auto text-end pt-3 col-xl-4 col-lg-4 col-sm-4 col-sm-12 col-xs-12 d-flex ">
          <button class="btn btn-outline-primary">Cancelar</button>
          <button class="btn btn-primary ms-2" type="submit">Registrar</button>
      </div>
      {!!Form::close()!!}
  </div>
@stop