@extends('template.molde')

@section('title','Alumnos|Consulta')

@section('ruta')
    <a href="{{route('alumnos.index')}}"> Alumnos </a>
    /
    <label class="label label-success">Consulta</label>
@endsection

@section('contenido')
    <form id="formBuscarAlumno" method="get" action="{{ route('alumnos.buscar') }}">
        <div class="row">             
            <div class="col-sm-2">
                <div class="form-outline mb-4">
                    <input type="text" id="control" class="form-control"  name="control" required/>
                    <label class="form-label" for="control" id="lControl">Numero de control</label>        
                </div>            
            </div>
            <div class="col-sm-1">
                <button type="submit" class="btn btn-success" >Buscar</button>
            </div>
            <div class="col-sm-9"></div>           
        </div>
    </form>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Control</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumno as $al)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $al->no_control }}</td>
                            <td>{{ $al->nombre }}</td>
                            <td>{{ $al->carrera }}</td>
                            <td>{{ $al->status }}</td>
                        </tr>
                    @endforeach                                                        
                </tbody>
              </table>
        </div>
        <div class="col-sm-2"></div>
    </div>
    <div style="margin-bottom: 100px;"></div>
@endsection