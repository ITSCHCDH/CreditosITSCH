@extends('template.molde')

@section('title','Editar Roles')

@section('ruta')
    <label class="label label-success"> Editar Roles</label>
@endsection

@section('contenido')
	{!! Form::open(['route' => ['roles.role_actualizar',$role->id], 'method' => 'put'])!!}
		<div class="form-group">
			{!! Form::label('name','Nombre') !!}
			{!! Form::text('name',$role->name,['placeholder' => 'Nombre del rol','required','class'=>'form-control']) !!}
		</div>
		
		{!! Form::submit('Guardar',['class' => 'btn btn-info']) !!}
	{!! Form::close() !!}
@endsection
