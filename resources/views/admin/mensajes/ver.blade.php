@extends('template.molde')

@section('title','Mensajes Ver')
@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/chosen/chosen.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/Trumbowyg-master/dist/ui/trumbowyg.min.css') }}">
    <script type="text/javascript" src="{{ asset('plugins/jsCookie/js.cookie.js') }}"></script>
@endsection
@section('ruta')
	@if ($ruta)
		<a href="{{ route('mensajes.index') }}">Mensajes</a>
		/
		<a href="{{  route('mensajes.enviados') }}">Mensajes Enviados</a>
		/
		<label class="label label-success">Ver Mensaje</label>
	@else
		<a href="{{ route('mensajes.index') }}">Mensajes</a>
		/
		<label class="label label-success">Ver Mensaje</label>
	@endif
	
@endsection
@section('contenido')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('nombre','De') !!}
                {!! Form::text('nombre',$mensaje->name,['class'=>'form-control','placeholder'=>'Nombre de la actividad','required','disabled']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('asunto','Asunto') !!}
                {!! Form::text('asunto',$mensaje->notificacion,['class'=>'form-control','placeholder'=>'Nombre de la actividad','required','disabled']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('nombre','Nombre de la actividad') !!}
                <textarea class="form-control" style="text-align: left; font-size: large;" disabled id="textarea-mensaje">{{ $mensaje->mensaje }}</textarea>
            </div>
            @if (Auth::User()->hasAnyPermission(['VIP','VIP_SOLO_LECTURA','VIP_EVIDENCIA','VER_PARTICIPANTES']) && $actividad_id != null)
               <div class="toltip">
                    <a href="#" onclick="redireccionar({{$actividad_id}});" class="btn btn-success btn-sm"><i class='fas fa-person-booth' style='font-size:18px'></i> Participantes</a>
                    <span class="toltiptext">Agregar participantes</span>
                </div>  
            @endif
        </div>
        <div class="col-sm-3"></div>
    </div>
	  

    @section('js')
    	<script src="{{ asset('plugins/Trumbowyg-master/dist/trumbowyg.min.js') }}"></script>
    	<script type="text/javascript">
    		$("#textarea-mensaje").trumbowyg({
    		    lang: 'es',
    		    autogrow: true
    		});
    	</script>
        <script>
            function redireccionar(actividad_id){
                Cookies.set('participantes_actividad',actividad_id,{ expires: 1});
                window.location.href = "{{ route('participantes.index') }}";
            }
            $('#checkbox5').click(function(event){
                var value = $(this).is(':checked');
                $('#actividades-submit').submit();
            });
        </script>
    @endsection
@endsection