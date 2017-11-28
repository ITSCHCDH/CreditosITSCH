@extends('template.molde')

@section('title','Actividades')

@section('ruta')
    <label class="label label-success"> Actividades</label>
@endsection

@section('contenido')

    <a href="{{route('actividades.create')}}" class="btn btn-info">Registrar nueva actividad</a>

    <!--BUSCADOR DE ARTICULOS  -->
    <!-- Boton de busqueda en la pagina -->
    {!! Form::open(['route'=>'actividades.index','method'=>'GET','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right']) !!}

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

    <table class="table table-striped">
        <thead>
            <th>ID</th>
            <th>Actividad</th>
            <th>Porcentaje crédito</th>
            <th>Crédito</th>
            <th>Acción</th>
        </thead>
        <tbody>
        @foreach($actividad as $act)
            <tr>
                <td>{{$act->id}}</td>
                <td>{{$act->nombre}}</td>
                <td>{{$act->por_cred_actividad}}</td>
                <td>{{$act->credito->nombre}}</td>

                <td>
                    <a href="{{ route('actividades.edit',[$act->id]) }}" class="btn btn-warning"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>
                    <a href="{{ route('admin.actividades.destroy',$act->id) }}" onclick="return confirm('¿Estas seguro que deseas eliminarlo?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $actividad->render() !!}

@endsection