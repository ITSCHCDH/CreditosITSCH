@extends('template.molde')

@section('title','Mensajes Ver')
@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/chosen/chosen.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/Trumbowyg-master/dist/ui/trumbowyg.min.css') }}">
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
    @section('js')
    	<script src="{{ asset('plugins/Trumbowyg-master/dist/trumbowyg.min.js') }}"></script>
    	<script type="text/javascript">
    		$("#textarea-mensaje").trumbowyg({
    		    lang: 'es',
    		    autogrow: true
    		});
    	</script>
    @endsection
@endsection