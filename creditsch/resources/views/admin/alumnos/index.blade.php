@extends('template.molde')

@section('title','Alumnos')

@section('ruta')
    <label class="label label-success"> Alumnos</label>
@endsection

@section('contenido')

    @if (Auth::User()->hasAnyPermission(['VIP','CREAR_ALUMNOS']))
        <a href="{{route('alumnos.create')}}" class="btn btn-primary">Registrar nuevo alumno</a>
    @endif
    
    <!--BUSCADOR DE ARTICULOS  -->
    <!-- Boton de busqueda en la pagina -->
    {!! Form::open(['route'=>'alumnos.index','method'=>'GET','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right']) !!}

    <div class="input-group">
        {!! Form::text('valor',null,['class'=>'form-control','placeholder'=>'Control|Nombre|Carrera','aria-describedby'=>'search']) !!}
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
    <table class="table table-striped">
        <thead>
        <th>ID</th>
        <th>Numero de Control</th>
        <th>Nombre</th>
        <th>Carrera</th>
        <th>Estatus</th>
        @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS','MODIFICAR_ALUMNOS']))
            <th>Acción</th>
        @endif
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
                    @if (Auth::User()->hasAnyPermission(['VIP','MODIFICAR_ALUMNOS']))
                        <a href="{{ route('alumnos.edit',[$alu->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                    @endif
                    @if (Auth::User()->hasAnyPermission(['VIP','ELIMINAR_ALUMNOS']))
                        <a href="{{ route('admin.alumnos.destroy',$alu->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $alumno->render() !!}
    <div style="margin-bottom: 50px;"></div>
@endsection