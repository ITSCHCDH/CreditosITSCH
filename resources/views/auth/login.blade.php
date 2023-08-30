<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ITSCH</title>

        <!-- Font Awesome -->
        <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet"
        />
        <!-- Google Fonts -->
        <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
        />
        <!-- MDB -->
        <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.css"
        rel="stylesheet"
        />
    </head>
    <body>
        @include('sweetalert::alert')
        <section class="vh-100" style="background-color: #000000;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0">
                                <div class="col-md-6 col-lg-5 d-none d-md-block">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                                </div>
                                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                    <div class="card-body p-4 p-lg-5 text-black">

                                        <form method="POST" action="{{ route('login') }}" id="frm_login">
                                            @csrf

                                            <div class="d-flex align-items-center mb-3 pb-1">
                                                <img src="{{ asset('images/itsch.jpg') }}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="Logo ITSCH" style="width: 100px">
                                                <span class="h1 fw-bold mb-0">ITSCH</span>
                                            </div>

                                            <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sistema de créditos complementarios del ITSCH</h5>


                                            <div class="mb-4">
                                                <Label class="form-label" >Tipo de usuario</Label>
                                                <select id="tipo-login" name="tipo-login" class="form-control form-control-lg" required>
                                                    <option value="1" selected>Administrativo</option>
                                                    <option value="0">Alumno</option>
                                                </select>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <input type="email" id="email" class="form-control form-control-lg"  name="email" required/>
                                                <label class="form-label" for="email" id="user">Email address</label>
                                            </div>

                                           <div class="row" >
                                                <div class="col-sm-10">
                                                    <div class="form-outline mb-4">
                                                        <input type="password" id="password" class="form-control form-control-lg" name="password" required/>
                                                        <label class="form-label" for="password" id="passwd">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn btn-primary btn-lg" onclick="mostrarPassword()" title="Ver password"><i class="fa fa-eye-slash" id="icon1"></i></button>
                                                </div>
                                           </div>

                                            <div class="pt-1 mb-4">
                                                <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                                            </div>

                                            <a class="small text-muted" href="{{ route('perfil.password_mail') }}" id="olvidaste">¿Olvidaste tu contraseña?</a>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </section>

        <!-- MDB -->
        <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.0.0/mdb.min.js"
        ></script>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{asset('plugins/vendorTem/jquery/jquery.min.js')}}"></script>


        <script type="text/javascript">
            function comboTipo(){
                $('#tipo-login').change(function(event){
                    event.preventDefault();
                    var tipo_val = $(this).val();
                    if(tipo_val==0){
                        $("#user").text("no_control@cdhidalgo.tecnm.mx");
                        $('#frm_login').attr('action', "{{ route('alumnos.login') }}");
                        $('#passwd').text('Password del SICE');
                        $('#email').attr('name','email');
                        $('#email').attr('type','text');
                    }else{
                        $("#user").text("Email address");
                        $('#frm_login').attr('action', "{{ route('login') }}");
                        $('#passwd').text('Password');
                        $('#email').attr('name','email');
                        $('#email').attr('type','email');
                    }
                });
            }

            $(document).ready(function(){
                comboTipo();
            });

            function mostrarPassword(){
                var cambio = document.getElementById("password");
                if(cambio.type == "password"){
                    cambio.type = "text";
                    $('#icon1').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                }else{
                    cambio.type = "password";
                    $('#icon1').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                }
            }
        </script>

    </body>
</html>
