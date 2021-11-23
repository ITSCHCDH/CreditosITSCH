@extends('template.molde')

@section('title','Creditos|Altas')

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/chosen/chosen.css') }}">
@endsection

@section('ruta')
    <a href="{{route('creditos.index')}}"> Creditos </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')

    {!! Form::open(['route'=>'creditos.store','method'=>'POST']) !!}

    <div class="form-group">
        {!! Form::label('nombre','Nombre del credito') !!}
        {!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Nombre del credito','required']) !!}
    </div>
    <div class="form-group">
        <label for="areas">Areas</label>
        <select data-placeholder="Selecciones las aera que podrán crear actividades de este credito" name="areas[]" id = "areas" class="chosen-select form-control" multiple required>
            @foreach($areas as $area)
                <option value="{{ $area->id }}">{{ $area->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="credito_jefe">Jefe</label>
        <select class="form-control" required name="credito_jefe">
            <option value="">Jefe del credito</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        {!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
    @section('js')
        <script src="{{ asset('plugins/chosen/chosen.jquery.js') }}"></script>
        <script type="text/javascript">
            $(".chosen-select").chosen({
                no_results_text: "No se encontrarón resultados"
            }); 
        </script>
    @endsection
@endsection