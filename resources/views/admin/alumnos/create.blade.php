@extends('template.molde')

@section('title','Alumnos|Altas')

@section('ruta')
    <a href="{{route('alumnos.index')}}"> Alumnos </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')
    <form action="{{ route('alumnos.store') }}" method="post">    
        @csrf
        <div class="form-group">
            <label for="no_control">Numero de Control</label>
            <input type="text" name="no_control" id="no_control" class="form-control" placeholder="Numero de control" required>            
        </div>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre Completo" required>          
        </div>

        <div class="form-group">
            <label for="carrera">Carrera</label>          
            <select name="carrera" id="carrera" class="form-control">
                <option value="">Seleccione una carrera</option>
                @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="***********" required>           
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="" selected>Seleccione un elemento</option>
                <option value="Pendiente">Pendiente</option> 
                <option value="Liberado">Liberado</option>   
            </select>             
        </div>

        <div class="form-group">
            <input type="submit" value="Registrar" class="btn btn-primary">           
        </div>
    </form>
        <div style="margin-bottom: 50px;"></div>
@endsection