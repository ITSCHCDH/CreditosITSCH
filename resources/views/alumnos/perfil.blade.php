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
                    <form action="{{ route('alumnos.edit.perfil',$alumno_data[0]->alumno_id) }}" method="post">
                        @csrf
                        <h5 class="card-title">{{ $alumno_data[0]->nombre }}</h5>
                        <p class="card-text">
                            Numero de control: {{ $alumno_data[0]->no_control }}
                            <br>
                            Carrera: {{ $alumno_data[0]->carrera }}
                        </p>
                        <input type="file" name="foto" id="foto">
                        <hr>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Password</span>
                            <input type="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="password" id="txtPassword" required value=" {{ $alumno_data[0]->password }}"/>
                            <button type="button" class="btn btn-primary" onclick="mostrarPassword()"><i class="fa fa-eye-slash" id="icon1"></i></button>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Confirm Password</span>
                            <input type="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="txtConfirmPassword" id="txtConfirmPassword" required value=" {{ $alumno_data[0]->password }}"/>
                            <button type="button" class="btn btn-primary" onclick="mostrarConfPassword()"><i class="fa fa-eye-slash" id="icon2"></i></button>
                        </div>
                        <p id="msjPassword" style="color: orange"></p>
                        <input type="submit" value="Editar" class="btn btn-primary">                        
                    </form>                  
                </div>
              </div>
        </div>
        <div class="col-sm-4"></div>
    </div>
    <div style="margin-bottom: 200px"></div>
@endsection

@section('js')
<script type="text/javascript">
    window.onload = function () {
        var txtPassword = document.getElementById("txtPassword");
        var txtConfirmPassword = document.getElementById("txtConfirmPassword");
        txtPassword.onchange = ConfirmPassword;
        txtConfirmPassword.onkeyup = ConfirmPassword;
        function ConfirmPassword() {            
            if (txtPassword.value != txtConfirmPassword.value) {
                $('#msjPassword').text("Los passwords no coinsiden");             
            }
            else
            {
                $('#msjPassword').text("");
            }
        }
    }

    function mostrarPassword(){
		var cambio = document.getElementById("txtPassword");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('#icon1').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('#icon1').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 

    function mostrarConfPassword(){
		var cambio = document.getElementById("txtConfirmPassword");
		if(cambio.type == "password"){
			cambio.type = "text";
			$('#icon2').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		}else{
			cambio.type = "password";
			$('#icon2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		}
	} 
</script>
@endsection