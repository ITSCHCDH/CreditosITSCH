@extends('template.molde')

@section('title','Ver Evidencias')
@section('ruta')
	<a href="{{ route('verifica_evidencia.index') }}">Verifica Evidencias</a>
	/
	<label class="label label-success">Ver Evidencias</label>
@endsection
@section('contenido')
	<style>
	div.gallery {
	    margin: 5px;
	    border: 1px solid #ccc;
	    float: left;
	    width: 250px;
	    heigth: 200px;
	}

	div.gallery:hover {
	    border: 1px solid #777;
	}

	div.gallery img {
	    width: 100%;
	    height: auto;
	    height: 250px;
	}

	div.desc {
	    padding: 7px;
	    text-align: left;
	}
	</style>

	<div>
		@foreach ($evidencias as $evi)
			<div class="gallery">
				<a href="{{asset('storage/evidencias/'.$evi->actividad_nombre.'/'.$evi->nom_imagen)}}">
					@php
						$extension = substr($evi->nom_imagen, -3);
					@endphp
					@if (strtolower($extension)=='pdf')
						<img class="imagenes" src="{{ asset('images/pdf_icono2.png')}}" width="300" height="200">
					@else
						<img class="imagenes" src="{{ asset('storage/evidencias/'.$evi->actividad_nombre.'/'.$evi->nom_imagen)}}" width="300" height="200">
					@endif
				</a>
				<div class="desc">
					<p><strong>Actividad: </strong>{{ $evi->actividad_nombre }}</p>
					<p><strong>Responsables: </strong>{{ $evi->usuario_nombre }}</p>
					<p><strong>Fecha: </strong>{{ $evi->fecha_subida }}</p>
				</div>
			</div>
		@endforeach
	</div>

@endsection