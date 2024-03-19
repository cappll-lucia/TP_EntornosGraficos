@extends ('layout.admin')
@section ('content')
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h3>Editar Estudiante</h3>
      @if (count($errors)>0)
  <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
      @endif

    <form method="PUT" action="/usuarios/alumnos/edit//{{ $alumno->id }}">
    @csrf
    @method('PUT')
      <div class="row px-5  pt-3">
        <label for="nombre" class="col-form-label col-sm-1">Nombre</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="nombre" name="nombre" value="{{$alumno->nombre}}">
        </div>
      </div>
      <div class="row  px-5   pt-3">
        <label for="apellido" class="col-form-label col-sm-1">Apellido</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="apellido" name="apellido" value="{{$alumno->apellido}}">
        </div>
      </div>
      <div class="row  px-5   pt-3">
        <label for="email" class="col-form-label col-sm-1">Email</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="email" name="email" value="{{$alumno->usuario->email}}">
        </div>
      </div>
      <div class="row  px-5   pt-3">
        <label for="name" class="col-form-label col-sm-1">Nombre Usuario</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="{{$alumno->usuario->nombre_usuario}}">
        </div>
      </div>
      <div class="row  px-5   pt-3">
        <label for="clave" class="col-form-label col-sm-1">Contraseña</label>
        <div class="col-sm-3">
          <input type="password" class="form-control" id="clave" name="clave" value="{{$alumno->usuario->clave}}">
        </div>
      </div>
      <div class="  pt-3 col-xl-4 col-lg-4 col-sm-4 col-sm-12 col-xs-12 d-flex justify-content-end">
          <button class="btn btn-outline-primary" type="button" onclick="cancelar()">Cancelar</button>
          <button class="btn btn-primary ms-2" type="submit">Registrar</button>
      </div>

  </div>
  </form>
<script>
  function cancelar(){
    window.location.href = '/usuarios/alumnos';
  }
</script>

@endsection