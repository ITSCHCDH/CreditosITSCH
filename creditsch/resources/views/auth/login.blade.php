@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Inicio
                    <img src="{{ asset('images/Customer_Male_Light.png') }}" border="0" width="30" height="30" class="img-rounded">
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('alumnos.login') }}" id="frm-login">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') || $errors->has('no_control') ? ' has-error' : '' }}">
                            <label for="email" id="label-username" class="col-md-4 control-label">No de Control</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="no_control" required autofocus>

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
                            <label for="password" class="col-md-4 control-label">Password</label>

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
                            <label for="tipo-login" class="col-md-4 control-label">Tipo</label>

                            <div class="col-md-6">
                                <select id="tipo-login" name="tipo-login" class="form-control">
                                    <option value="0" selected>Alumno</option>
                                    <option value="1">Administrativo</option>
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
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordar Usuario
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Inicio
                                </button>
                                <a class="btn btn-link" href="{{ route('password.request') }}">
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
                }else{
                    email.name = "email";
                    formulario.action = "{{ route('login') }}";
                    label.innerHTML = "Dirección E-Mail";
                }
            });
        }
        $(document).ready(function(){
            comboTipo();
        });
    </script>
@endsection
@endsection
