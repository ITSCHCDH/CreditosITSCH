@extends('template.molde')

@section('title','Creditos|Edit')

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/chosen/chosen.css') }}">
@endsection

@section('ruta')
    <a href="{{route('creditos.index')}}"> Creditos </a>
    /
    <label class="label label-success"> Altas</label>
@endsection

@section('contenido')

    <form action="{{ route('creditos.update', $credito->id) }}" method="post">
        @csrf
        <div class="form-outline">
            <input type="text" name="nombre" id="nombre"class="form-control" value="{{ $credito->nombre }}" required />
            <label class="form-label" for="nombre">Nombre del crédito</label>
        </div>
        <br>

        <div class="form-group">
            <label for="areas">Areas</label>
            <select name="areas[]" id = "areas" class="form-control" multiple required>
                @foreach($areas as $area)
                    @if($area->credito_id == null)
                        <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                    @else
                        <option value="{{ $area->id }}" selected>{{ $area->nombre }}</option>
                    @endif                
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="credito_jefe">Jefe</label>
            <select  class="form-control" name="credito_jefe" id="credito_jefe" required>
                <option value="">Seleccione un jefe para este credito</option>
                @foreach($usuarios as $usuario)
                    @if($usuario->id==$credito->credito_jefe)
                        <option value="{{ $usuario->id }}" selected style="background-color: blue; color: white;">{{ $usuario->name }}</option>
                    @else
                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="vigente">Vigente</label>
            <select class="form-control" name="vigente" required>
                @if($credito->vigente=="true")
                    <option value="true" selected>SI</option>
                    <option value="false">NO</option>
                @else
                    <option value="true">SI</option>
                    <option value="false" selected>NO</option>
                @endif
            </select>
        </div>
        <div class="form-group">
            <input type="submit" value="Registrar" class="btn btn-primary">            
        </div>
    </form>
    @section('js')
        <script src="{{ asset('plugins/chosen/chosen.jquery.js') }}"></script>
        <script type="text/javascript">
            $(".chosen-select").chosen({
                no_results_text: "No se encontrarón resultados"
            }); 
        </script>
    @endsection
@endsection