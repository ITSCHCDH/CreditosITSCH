@extends('template.molde');

@section('title','Tutorias')

@section('ruta')
    <label class="label label-success"> <a href="#">STA</a> / <a href="{{ route('tutorias.index') }}">Tutorias</a>/Grupos </label> 
@endsection

@section('contenido')
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4"></div>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <th>Numero</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Status</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach ($grupos as $grupo)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$grupo->gpo_Nombre}}</td>
                        <td>{{$grupo->carrera}}</td>
                        <td>@if($grupo->status==0)Sin asignar @else Asignado @endif</td>
                        <td>                            
                            <a href="{{ route('tutorias.updateGrupo',$grupo->id) }}" type="button" class="btn btn-warning" title="Editar grupo"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('tutorias.deleteGrupo',$grupo->id) }}" type="button" class="btn btn-danger" title="Eliminar grupo"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection