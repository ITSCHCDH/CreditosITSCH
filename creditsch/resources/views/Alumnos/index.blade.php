@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> Alumnos</label>
@endsection

@section('contenido')

    <a href="{{route('alumnos.create')}}" class="btn btn-info">Registrar nuevo usuario</a>
    <table class="table table-striped">
        <thead>
        <th>ID</th>
        <th>Numero de Control</th>
        <th>Nombre</th>
        <th>Carrera</th>
        <th>Estatus</th>
        <th>Acción</th>
        </thead>
        <tbody>
        @foreach($alumno as $alu)
            <tr>
                <td>{{$alu->id}}</td>
                <td>{{$alu->no_control}}</td>
                <td>{{$alu->nombre}}</td>
                <td>{{$alu->carrera}}</td>
                <td>
                    @if($alu->status=="Pendiente")
                        <span class="label label-danger">{{$alu->status}}</span>
                    @else
                        <span class="label label-primary">{{$alu->status}}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('alumnos.edit',[$alu->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                    <a href="{{ route('admin.alumnos.destroy',$alu->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $alumno->render() !!}
@endsection