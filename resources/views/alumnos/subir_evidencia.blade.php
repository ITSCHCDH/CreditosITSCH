@extends('template.molde')

@section('title','Evidencias')

@section('links')    
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fileupload/css/component.css')}}">
    <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
@endsection
@section('ruta')
    <a href="{{ route('alumnos.actividades') }}">Actividades</a>
    /
    <label class="label label-success">Subir Evidencia</label>
@endsection

@section('contenido')

    <form action="" method="post" enctype="multipart/form-data">
        @csrf        
        <input type="hidden" name="no_control" value="{{ Auth::User()->no_control }}">
        <div class="form-outline mb-4">
            <input type="text" name="id_asig_activi" id="id_asig_activi" class="form-control form-control-lg" required readonly value="{{ $actividad->nombre }}">
            <label for="id_asig_activi" class="form-label">Actividad a la que pertenece la evidencia</label>                             
        </div>
            <input type="hidden" name="actividad_id" value="{{ $actividad->id }}">
        <div class="form-outline mb-4">
            <input type="text" name="resp" id="resp" class="form-control form-control-lg" value="{{ $responsable->name }}" required readonly>
            <label for="resp" class="form-label">Responsable de la actividad</label>
        </div>
        <input type="hidden" name="responsables" id="responsables" value="{{ $responsable->id }}">       

        <div class="mb-4">
            <label for="valida">Nombre del quien valida la evidencia</label>           
            <select id='valida' name='valida' class="form-control form-control-lg" required disabled>
                @if ($validador!=null)
                    <option value="{{ $validador->id }}">{{ $validador->name }}</option>
                @else
                    <option value="">{{ "No hay validador" }}</option>
                @endif    
            </select>
        </div>
        <div style="width:200px; margin-left:auto; margin-right:auto;">
            <div class="form-group">
                <input type="file" name="archivos[]" id="archivos" class="inputfile inputfile-4 subida" data-multiple-caption="{count} archivos seleccionados" multiple required />
                <label for="archivos" class="subida"><figure class="subida"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" class="subida"><path class="subida" d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span class="subida">Seleccionar archivos&hellip;</span></label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>            
        </div>
    </form>         
    @section('js')
        <script src="{{ asset('plugins/fileupload/js/custom-file-input.js') }}"></script>
    @endsection
@endsection
