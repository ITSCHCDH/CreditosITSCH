@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" >
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Inicio
                    <img src="{{ asset('images/Customer_Male_Light.png') }}" border="0" width="30" height="30" class="img-rounded">
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}" id="frm-login">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') || $errors->has('no_control') ? ' has-error' : '' }}">
                            <label for="email" id="label-username" class="col-md-4 control-label" style="font-size: 0.9vw" >Dirección E-Mail</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                @if ($errors->has('no_control'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('no_control') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label" style="font-size: 0.9vw" >Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipo-login" class="col-md-4 control-label" style="font-size: 0.9vw">Tipo</label>

                            <div class="col-md-6">
                                <select id="tipo-login" name="tipo-login" class="form-control">
                                    <option value="1" selected>Administrativo</option>
                                    <option value="0">Alumno</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block" style="color:red;">
                                        <strong>{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label style="font-size: 0.9vw">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} style="font-size: 0.9vw"> Recordar Usuario
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Inicio
                                </button>
                                <a class="btn btn-link" href="{{ route('password.request') }}" id="olvidaste">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script type="text/javascript">
        function comboTipo(){
            $('#tipo-login').change(function(event){
                event.preventDefault();
                var tipo_val = $(this).val();
                var username = document.getElementById('email');
                var formulario = document.getElementById('frm-login');
                var label = document.getElementById('label-username');
                if(tipo_val==0){
                    email.name = "no_control";
                    formulario.action = "{{ route('alumnos.login') }}";
                    label.innerHTML = "No de Control";
                    $('#olvidaste').css('display','none');
                }else{
                    email.name = "email";
                    formulario.action = "{{ route('login') }}";
                    label.innerHTML = "Dirección E-Mail";
                    $('#olvidaste').css('display','inline');
                }
            });
        }
        $(document).ready(function(){
            comboTipo();
        });
    </script>
@endsection
@endsection
