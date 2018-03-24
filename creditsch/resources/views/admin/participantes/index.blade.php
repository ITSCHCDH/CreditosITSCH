@extends('template.molde')

@section('title','Participantes')

@section('ruta')
    <label class="label label-success"> Participantes</label>
@endsection
<!-- HTML index de los participantes -->
@section('contenido')
    <a href="{{ route('evidencias.create') }}" class='btn btn-primary'>Agregar evidencia</a>
    {!! Form::open(['route'=>'participantes.index','method'=>'GET','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-left']) !!}
        <div class="input-group">
            <!--Cargamos las actividades y sus ID's, valor seleccionado por defecto es id de la actividad
                al que estan asignados los participantes -->
           {!! Form::select('actividades_id',$actividades,$participantes->id_actividad,['class'=>'form-control','required','placeholder'=>'Seleccione una opcion','method'=>'GET']) !!}
            <div class="input-group-btn">
                <button type="submit" class="btn btn-primary"> Buscar
                    <span class="badge  label label-primary glyphicon glyphicon-search">
                          </span>
                </button>
            </div>
        </div>
    {!! Form::close() !!}
    <!-- Abrimos el formulario para guardar los participantes -->
    {!! Form::open(['route'=>'participantes.store','method'=>'POST','class'=>'form-inline my-2 my-lg-0 mr-lg-2 navbar-form pull-right']) !!}
        <div class="input-group">
            {!! Form::text('no_control',null,['class'=>'form-control','placeholder'=>'No Control','required']) !!}
            <!-- Enviamos el id de la evidencia en un formulario oculto -->
            {!! Form::hidden('id_evidencia',$id_evidencia)!!}
            @php
                // Validamos si se ha seleccionado una actividad -->      
                if( isset($_GET['actividades_id']) ){
                echo '<form method="GET">
                        <input type="hidden" name="id_actividad" value='.$_GET["actividades_id"].'>
                        </form>';
                }
            @endphp    
            <div class="input-group-btn">
                <button type="submit" class="btn btn-primary"> Agregar </button>
            </div>
        </div>
    {!! Form::close() !!}
    <!-- Tabla donde se muestran los participantes -->
    <table class="table table-striped" id="mitabla">
        <!-- instancia al archivo table, dentro de este mismo direcctorio -->
        @include('admin.participantes.table')
    </table>
@endsection