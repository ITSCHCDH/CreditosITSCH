@extends('template.molde')

@section('title','Roles|Crear')

@section('ruta')
	<a href="{{ route('roles.index') }}">Roles</a>
	/
    <label class="label label-success"> Crear Permiso</label>
@endsection

@section('contenido')
	{!! Form::open(['route' => 'roles.permisos_guardar', 'method' => 'post'])!!}
		<div class="form-group">
			{!! Form::label('name','Nombre') !!}
			{!! Form::text('name',null,['placeholder' => 'Nombre del permiso','required','class'=>'form-control']) !!}
		</div>
		
		{!! Form::submit('Agregar',['class' => 'btn btn-info']) !!}
	{!! Form::close() !!}
@endsection