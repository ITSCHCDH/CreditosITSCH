@extends('template.molde')

@section('title','Creditos|Altas')

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/chosen/chosen.css') }}">
@endsection

@section('ruta')
    <a href="{{route('creditos.index')}}"> Créditos </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')

    <form action="{{ route('creditos.store') }}" method="post">  
        @csrf
        <div class="form-outline">
            <input type="text" name="nombre" id="nombre"class="form-control" required />
            <label class="form-label" for="nombre">Nombre del crédito</label>
        </div>
        <br>
        
        <div class="form-group">
            <label for="areas">Areas</label>
            <select name="areas[]" id ="areas" class="form-control" multiple required>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="credito_jefe">Jefe</label>
            <select class="form-control" required name="credito_jefe">
                <option value="">Jefe del crédito</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="submit" value="Registrar" class="btn btn-primary">            
        </div>

    </form>   
@endsection