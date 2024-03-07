@extends ('layout.admin')
@section ('contenido')


<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Email</th>
					<th>UserName</th>
					<th>Opciones</th>
				</thead>
               @foreach ($students as $st)
				<tr>
					<td>{{ $st->id}}</td>
					<td>{{ $st->nombre}}</td>
					<td>{{ $st->apellido}}</td>
					<td>{{ $st->email}}</td>
					<td>{{ $st->username}}</td>
					<td>
						 <a href="{{URL::action('StudentController@edit',$st->id)}}"><button class="btn btn-info">Editar</button></a> 
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