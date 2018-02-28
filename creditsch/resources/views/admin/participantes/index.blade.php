@extends('template.molde')

@section('title','Participantes')

@section('ruta')
    <label class="label label-success"> Participantes</label>
@endsection

@section('contenido')
    
    {!! Form::open(['route'=>'participantes.store','method'=>'POST','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-left']) !!}
        <div class="input-group">
            {!! Form::text('no_control',null,['class'=>'form-control','placeholder'=>'No Control','required']) !!}
            <div class="input-group-btn">
                <button type="submit" class="btn btn-primary"> Agregar </button>
            </div>
        </div>
    {!! Form::close() !!}
    
    {!! Form::open(['route'=>'participantes.index','method'=>'GET','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right']) !!}

    <div class="input-group">
        {!! Form::text('valor',null,['class'=>'form-control','placeholder'=>'Control|Nombre','aria-describedby'=>'search']) !!}
        <div class="input-group-btn">
            <button type="submit" class="btn btn-primary"> Buscar
                <span class="badge  label label-primary glyphicon glyphicon-search">
                      </span>
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <table class="table table-striped">
        <thead>
        <th>ID</th>
        <th>Numero de Control</th>
        <th>ID_evidencia</th>
        
        </thead>
        <tbody>
        @foreach($participante as $par)
            <tr>
                <td>{{$par->id}}</td>
                <td>{{$par->no_control}}</td>
                <td>{{$par->id_evidencia}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $participante->render() !!}

@endsection