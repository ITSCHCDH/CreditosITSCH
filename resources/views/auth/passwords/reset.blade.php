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
            
                                        <form method="POST" action="{{ route('perfil.password_reset') }}" id="frm_pass_reset">
                                            @csrf
                    
                                            <div class="d-flex align-items-center mb-3 pb-1">
                                                <img src="{{ asset('images/itsch.jpg') }}" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="Logo ITSCH" style="width: 100px">
                                                <span class="h1 fw-bold mb-0">ITSCH</span>
                                            </div>
                        
                                            <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sistema de créditos complementarios del ITSCH</h5>  
                                            
                                                                                     

                                            <div class="form-outline mb-4">
                                                <input type="password" id="newPass" class="form-control form-control-lg"  name="newPass" required/>
                                                <label class="form-label" for="newPass" id="lNewPass">New Password</label>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <input type="password" id="repNewPass" class="form-control form-control-lg"  name="repNewPass" required/>
                                                <label class="form-label" for="repNewPass" id="lNewPass">Repeat New Password</label>
                                            </div>

                                            
                                            <input type="hidden" readonly value="{{ $token }}" name="token">                                            

                                            <p><small>Nota: Las contraseñas deben ser de mínimo 8 caracteres e incluir al menos una letra mayúscula, un digito del 0...9 y algún carácter especial como -,/,$, etc.</small></p>
                                                                                                                         
                        
                                            <div class="pt-1 mb-4">
                                                <button type="submit" class="btn btn-primary">
                                                   Reset password
                                                </button>
                                            </div>
                        
                                          
                                    
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
    </body>
</html>