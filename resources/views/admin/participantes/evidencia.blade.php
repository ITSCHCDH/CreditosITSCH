@extends('template.molde')

@section('title','Evidencias')

@section('links')
	<link rel="stylesheet" type="text/css" href="{{ asset('cssGaleria/galeria.css') }}">
@endsection
@section('ruta')
	<a href="{{ route('participantes.index') }}">Participantes</a>
	/
	<label class="label label-success">Evidencias</label>
@endsection

@section('contenido')
<style type="text/css">
	div.gallery{
		height: 350px;
	}
</style>
	<div class="pull-left">
		<p><strong>Actividad: </strong>
			@if ($actividad!=null)
				{{ $actividad->nombre }}
			@else
				{{ "No existe!!!" }}
			@endif	
		</p>
	</div>
	<div class="resetear"></div>
	<div class="pull-left">
		<p><strong>Alumno: </strong>{{ $alumno->nombre }}</p>
	</div>
	<div class="resetear"></div>
	<div id="mensaje-parte-superior">
		
    </div>
    <div>
		@if (Auth::User()->hasAnyPermission(['VIP','VIP_EVIDENCIA','VIP_ACTIVIDAD','VERIFICAR_EVIDENCIA']))
			@if ($validado->count()!=0)
				@if ($validado[0]->validado == "true" && ($participante_data->momento_agregado == "posteriormente" && $participante_data->evidencia_validada == "no"))
					<form action="{{ route('participantes.validar_evidencia') }}" method="post">
						@csrf
						<input type="hidden" name="participante_id" value="{{ $participante->id }}">
						<button type="submit" class="btn btn-primary">Validar evidencia</button>
					</form>					
				@endif
			@endif
		@endif
    </div>
	<div>
        @foreach ($evidencias as $evidencia)
			<div class="gallery">
				<a href="{{ asset('storage/evidencias/'.$evidencia->actividad_nombre.'/'.$evidencia->evidencia_nombre) }}">
					@php
						$extension = substr($evidencia->evidencia_nombre, strlen($evidencia->evidencia_nombre)-4);
					@endphp
					@if ($extension == ".pdf")
						<img src="{{ asset('images/pdf_icono2.png') }}" width='300' heigth='200' class='imagenes'>
					@else
						<img src="{{ asset('storage/evidencias/'.$evidencia->actividad_nombre.'/'.$evidencia->evidencia_nombre) }}" width='300' heigth='200' class='imagenes'>
					@endif
					<a href="#" data-actividad = "{{ $evidencia->actividad_nombre }}" data-archivo = "{{ $evidencia->evidencia_id }}" data-archivo_nombre = "{{ $evidencia->evidencia_nombre }}" class="eliminar-evidencia">
						<img src='{{ asset('images/eliminar_icono.png') }}' class='eliminar' width='40' heigth='40'>
					</a>
					<div class="desc">
						<p><strong>Responsable: </strong>{{ $evidencia->usuario_nombre }}</p>
						<p><strong>Fecha: </strong>{{ $evidencia->fecha }}</p>
					</div>
				</a>
			</div>
		@endforeach
	</div>
	<div style="margin-bottom: 60px;" class="resetear"></div>
	@section('js')
		@if ($validado->count()!=0)
			@if ($validado[0]->validado == "false" || ($participante_data->momento_agregado == "posteriormente" && $participante_data->evidencia_validada == "no"))
				<script type="text/javascript">
					function elhover(){
						$(document).on('mouseover','.gallery' ,function(event){
							$(this).find('img.eliminar').css('visibility','visible');
						});
						$(document).on('mouseout','.gallery' ,function(event){
							$(this).find('img.eliminar').css('visibility','hidden');
						});
					}
					function eliminarEvidencia(){
						$(document).on('click','.eliminar-evidencia',function(event){
							event.preventDefault();
							var confirmacion = confirm("¿Estas seguro que deseas eliminar esta evidencia?");
							if(confirmacion){
								var actividad = $(this).attr('data-actividad');
								var archivo_id = $(this).attr('data-archivo');
								var archivo_nombre = $(this).attr('data-archivo_nombre');
								var referencia = $(this);
								$.ajax({
									type: "get",
									dataType: "json",
									url: "{{ route('participantes.eliminar_evidencia') }}",
									data:{
										actividad: actividad,
										archivo: archivo_id,
										archivo_nombre: archivo_nombre,
                                        no_control: "{{ $alumno->no_control }}"
									}, 
									success: function(response){
										mostrarMensaje(response['mensaje'],'mensaje-parte-superior',response['tipo']);
										if(response['tipo']=="exito"){
											referencia.parent().css('display','none');
										}
									}, error: function(){
										console.log("Error al eliminar la evidencia");
									}
								});
								
							}
						});
					}
					$(document).ready(function(){
						elhover();
						eliminarEvidencia();
					});
				</script>
			@endif
		@endif
	@endsection
@endsection