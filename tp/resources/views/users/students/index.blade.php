@extends ('layout.admin')
@section ('content')

<div class="flex-row mt-4 row d-flex">
	<h3 class="col-lg-4">Listado de estudiantes</h3>
	<button class="col-lg-2 btn btn-primary">
			<a href="{{URL::action('App\Http\Controllers\StudentController@create')}}">
				Nuevo estudiante
			</a>
	</button>
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
					<th>UserName</th>
					<th class="col-lg-2">Opciones</th>
				</thead>
               @foreach ($students as $st)
				<tr>
					<td>{{ $st->id}}</td>
					<td>{{ $st->persona->nombre}}</td>
					<td>{{ $st->persona->apellido}}</td>
					<td>{{ $st->email}}</td>
					<td>{{ $st->name}}</td>
					<td>
						<a href="{{URL::action('App\Http\Controllers\StudentController@edit',$st->id)}}"><button class="btn btn-info">Editar</button></a> 
            			<a href="" data-target="#modal-delete-{{$st->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
				</tr>
				@include('users.students.modal')
				@endforeach
			</table>
		</div>
		{{$students->render()}}
	</div>
</div>

@endsection