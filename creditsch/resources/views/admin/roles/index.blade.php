@extends('template.molde')

@section('title','Alumnos|Edit')

@section('ruta')
	<a href="{{route('roles.index')}}"> Alumnos </a>
	/
    <label class="label label-success"> Roles</label>
@endsection

@section('contenido')
	<a href="{{ route('roles.roles_crear')}}">Crear Rol</a>
	<br>
	<a href="{{ route('roles.permisos_crear')}}">Crear Permiso</a>
	<br>
	<a href="{{ route('roles.roles_index')}}">Ver roles</a>
@endsection