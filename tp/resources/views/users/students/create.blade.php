@extends ('layout.admin')
@section ('content')
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h3>Registrar Estudiante</h3>
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

      <div class="px-5 pt-3  row">
        <label for="nombre" class="col-sm-1 col-form-label">Nombre</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
      </div>
      <div class="px-5  pt-3   row">
        <label for="apellido" class="col-sm-1 col-form-label">Apellido</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="apellido" name="apellido">
        </div>
      </div>
      <div class="px-5  pt-3   row">
        <label for="email" class="col-sm-1 col-form-label">Email</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="email" name="email">
        </div>
      </div>
      <div class="px-5  pt-3   row">
        <label for="name" class="col-sm-1 col-form-label">UserName</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="name" name="name">
        </div>
      </div>
      <div class="px-5  pt-3   row">
        <label for="clave" class="col-sm-1 col-form-label">Contraseña</label>
        <div class="col-sm-3">
          <input type="password" class="form-control" id="clave" name="clave">
        </div>
      </div>
      <div class="  pt-3 d-flex justify-content-end col-xl-4 col-lg-4 col-sm-4 col-sm-12 col-xs-12">
          <button class="btn btn-outline-primary">Cancelar</button>
          <button class="btn btn-primary ms-2" type="submit">Registrar</button>
      </div>
      {!!Form::close()!!}
  </div>
@stop