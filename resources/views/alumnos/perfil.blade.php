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
                        <img src="{{ asset('images/user2.png') }}" class="img-fluid"/>
                    @endif
                  <a href="#!">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                  </a>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <h5 class="card-title">{{ $alumno_data[0]->nombre }}</h5>
                        <p class="card-text">
                            Numero de control: {{ $alumno_data[0]->no_control }}
                            <br>
                            Carrera: {{ $alumno_data[0]->carrera }}
                        </p>
                        <input type="file" name="foto" id="foto" required>
                        <hr>
                        <input type="submit" value="Editar foto" class="btn btn-primary">                        
                    </form>                  
                </div>
              </div>
        </div>
        <div class="col-sm-4"></div>
    </div>
    <div style="margin-bottom: 200px"></div>
@endsection