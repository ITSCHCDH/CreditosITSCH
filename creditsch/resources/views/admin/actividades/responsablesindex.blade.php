@extends('template.molde')

@section('title','Actividades')

@section('ruta')
    <a href="{{route('actividades.index')}}">Actividades</a>
    /
    <a href="{{route('responsables',$actividad->id)}}">Responsables</a>
    /
    <label class="label label-success">Asignar</label>
@endsection

@section('contenido')
    <!--BUSCADOR DE ARTICULOS  -->
    <!-- Boton de busqueda en la pagina -->
    {!! Form::open(['route'=>['responsables.index',$actividad->id],'method'=>'GET','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right']) !!}

        <div class="input-group">
            {!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Buscar.....','aria-describedby'=>'search']) !!}
            <div class="input-group-btn">
                <button type="submit" class="btn btn-primary"> Buscar
                      <span class="badge  label label-primary glyphicon glyphicon-search">
                      </span>
                </button>
            </div>
        </div>
    {!! Form::close() !!}
    <!--Nota: Se tiene que agregar el (scope) que es una funcion que se agrega en el modelo y es la encargada de hacer la consulta  -->
    <!--Fin del boton de busqueda  -->
    {!! Form::open(['route'=>'actividad_evidencias.store','method'=>'POST'])!!}
        <input type="hidden" name="actividad_id" value="{{$actividad->id}}">
        <table class="table table-striped">
            <thead>
                <th>Nombre</th>
                <th>Area</th>
                <th>Asignar</th>
            </thead>
            <tbody>
            @foreach($responsables as $res)
                <tr>
                    <td>
                        {{$res->name}}
                    </td>
                    <td>
                        {{$res->area}}
                    </td>
                    <td>
                      <label>
                        @if($res->asignado==null)
                            <input type="checkbox" name="user_id[]" value="{{$res->user_id}}">
                        @else
                            <input type="checkbox" name="user_id[]" value="{{$res->user_id}}" checked>
                        @endif
                        
                      </label>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! Form::submit('Aceptar',['class'=>'btn btn-primary']) !!}
    {!! Form::close()!!}

@endsection