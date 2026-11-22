@extends('template.molde')

@section('title','Mi Perfil')

@section('ruta')
	<a href="{{ route('alumnos.avance') }}" class="label label-info">Avance</a>
	/
	<label class="label label-success">Mi perfil</label>
@endsection

@section('contenido')  
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div class="card">
                <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                    @if($alumno_data[0]->foto==null)
                        <img src="{{ asset('images/user.png') }}" class="img-fluid"/>
                    @else
                        <img src="{{ asset('storage/alumnos/img/'.$alumno_data[0]->foto) }}" class="img-fluid"/>
                    @endif
                  <a href="#!">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                  </a>
                  <p>Las imagenes deben de ser de mas de 600px de alto y de ancho</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('alumnos.edit.perfil',$alumno_data[0]->alumno_id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h5 class="card-title">{{ $alumno_data[0]->nombre }}</h5>
                        <p class="card-text">
                            Numero de control: {{ $alumno_data[0]->no_control }}
                            <br>
                            Carrera: {{ $alumno_data[0]->carrera }}
                        </p>
                        <h5>Editar fotografía</h5>
                        <input type="file" name="foto" id="foto">
                        <hr>
                        <input type="submit" value="Editar" class="btn btn-primary">                        
                    </form>                  
                </div>
              </div>
        </div>
        <div class="col-sm-4"></div>
    </div>
    <div style="margin-bottom: 200px"></div>
@endsection
