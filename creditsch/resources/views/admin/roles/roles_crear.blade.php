@extends('template.molde')

@section('title','Roles|Crear')

@section('ruta')
    <label class="label label-success"> Crear Roles</label>
@endsection

@section('contenido')
	{!! Form::open(['route' => 'roles.roles_guardar', 'method' => 'post'])!!}
		<div class="form-group">
			{!! Form::label('name','Nombre') !!}
			{!! Form::text('name',null,['placeholder' => 'Nombre del rol','required','class'=>'form-control']) !!}
		</div>
		
		{!! Form::submit('Agregar',['class' => 'btn btn-info']) !!}
	{!! Form::close() !!}
@endsection