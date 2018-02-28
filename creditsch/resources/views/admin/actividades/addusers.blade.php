@extends('template.molde')

@section('title','Actividades')

@section('ruta')
    <label class="label label-success"> Actividades</label>
@endsection

@section('contenido')
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
            <th>Nombre</th>
            <th>Area</th>
        </thead>
        <tbody>
        @foreach($responsables as $res)
            <tr>
                <td>{{$res->name}}</td>
                <td>{{$res->area}}</td>
                
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $responsables->render() !!}

@endsection