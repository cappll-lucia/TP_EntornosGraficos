@extends ('layout.admin')
@section ('content')

<div class="flex-row mt-4 row d-flex justify-content-center">
	<h3 class="col-lg-4">Listado de estudiantes</h3>
	<a href="{{URL::action('App\Http\Controllers\AlumnoController@create')}}" class="col-lg-2 btn btn-primary">
		Nuevo estudiante
	</a>
</div>

<div class="row d-flex justify-content-center">
	<div class="m-3 col-lg-10 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Email</th>
					<th>Nombre Usuario</th>
					<th class="col-lg-2">Opciones</th>
				</thead>
               @foreach ($alumnos as $al)
				<tr>
					<td>{{ $al->id}}</td>
					<td>{{ $al->persona->nombre}}</td>
					<td>{{ $al->persona->apellido}}</td>
					<td>{{ $al->email}}</td>
					<td>{{ $al->nombre_usuario}}</td>
					<td>
						<a href="{{URL::action('App\Http\Controllers\AlumnoController@edit',$al->id)}}"><button class="btn btn-info">Editar</button></a> 
            			<a href="" data-target="#modal-delete-{{$al->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
				</tr>
				@include('usuarios.alumnos.modal')
				@endforeach
			</table>
		</div>
		{{$alumnos->render()}}
	</div>
</div>

@endsection