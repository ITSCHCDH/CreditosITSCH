@extends('template.molde')

@section('title','Mensajes Crear')
@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/chosen/chosen.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/Trumbowyg-master/dist/ui/trumbowyg.min.css') }}">
@endsection
@section('ruta')
	<a href="{{ route('mensajes.index') }}">Mensajes</a>
	/
	<label class="label label-success">Crear Mensaje</label>
@endsection
@section('contenido')
	<form action="{{ route('mensajes.enviar') }}" method="post">
		{{ csrf_field() }}
		<div class="form-group">
			<label>De:</label>
			<input type="text" name="user_name" value="{{ Auth::User()->name }}" class="form-control" disabled>
			<input type="hidden" name="creador_id" value="{{ Auth::User()->id }}">
			<label>Para:</label>
			<select data-placeholder = "Seleccione destinatarios" class="form-control chosen-select" multiple required name="destinatarios_id[]">
				@foreach ($users as $user)
					<option value="{{ $user->id }}">{{ $user->name }}</option>
				@endforeach
			</select>
			<label>Asunto:</label>
			<input type="text" name="notificacion" class="form-control" required>
			<label>Mensaje</label>
			<textarea class="form-control" name="mensaje" required id="textarea-mensaje">
			</textarea>
		</div>
		<input type="submit" name="" value="Enviar" class="btn btn-primary">
	</form>
	<div style="padding: 30px;"></div>
	
	@section('js')
		<script src="{{ asset('plugins/Trumbowyg-master/dist/trumbowyg.min.js') }}"></script>
		<script src="{{ asset('plugins/chosen/chosen.jquery.js') }}"></script>
		<script type="text/javascript">
			$(".chosen-select").chosen({
				no_results_text: "No se encontrarón resultados"
			}); 
			$("#textarea-mensaje").trumbowyg({
				lang: 'es',
				autogrow: true
			});
		</script>		
	@endsection
@endsection