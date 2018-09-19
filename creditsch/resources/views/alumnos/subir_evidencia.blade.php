@extends('template.molde')

@section('title','Evidencias')

@section('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fileupload/css/demo.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fileupload/css/component.css')}}">
    <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
@endsection
@section('ruta')
    <a href="{{ route('alumnos.actividades') }}">Actividades</a>
    /
    <label class="label label-success">Subir Evidencia</label>
@endsection

@section('contenido')

    {!! Form::open(['route'=>'alumnos.guardar_evidencia','method'=>'POST','files'=>true]) !!}

        {!! Form::hidden('no_control',Auth::User()->no_control) !!}
        <div class="form-group">
            {!! Form::label('actividad_id','Actividad a la que pertenece la evidencia') !!}
            {!! Form::hidden('actividad_id',$actividad->id) !!}
            {!! Form::text('id_asig_activi',$actividad->nombre,['class' => 'form-control','required','readonly']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('responsables','Responsable de la actividad') !!}
            {!! Form::hidden('responsables',$responsable->id) !!}
            {!! Form::text('resp',$responsable->name,['class' => 'form-control', 'required','readonly']) !!}

        </div>

        <div class="form-group">
            {!! Form::label('valida','Nombre del quien valida la evidencia') !!}
            <select id='valida' name='valida' class="form-control select-category" required disabled>
                @if ($validador!=null)
                    <option value="{{ $validador->id }}">{{ $validador->name }}</option>
                @else
                    <option value="">{{ "No hay validador" }}</option>
                @endif
                
            </select>
            
        </div>

        <div class="form-group">
            <input type="file" name="archivos[]" id="archivos" class="inputfile inputfile-4 subida" data-multiple-caption="{count} archivos seleccionados" multiple required />
            <label for="archivos" class="subida"><figure class="subida"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" class="subida"><path class="subida" d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span class="subida">Seleccionar archivos&hellip;</span></label>
        </div>
        <div class="form-group">
            {!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
    <div style="margin-bottom: 50px;"></div>
    @section('js')
        <script src="{{ asset('plugins/fileupload/js/custom-file-input.js') }}"></script>
    @endsection
@endsection
