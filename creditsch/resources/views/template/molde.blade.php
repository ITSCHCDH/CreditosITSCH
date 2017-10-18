<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio|@yield('title','Default')</title>
    <link rel="stylesheet" href="{{asset('menu/fontello.css')}}">
    <link rel="stylesheet" href="{{asset('cssMenu/estilos.css')}}">

    <!-- Custom fonts for this template-->
    <link href="{{asset('plugins/vendorTem/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset('plugins/vendorTem/font-awesome/css/sb-admin.css')}}" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{asset('complementos/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('complementos/css/bootstrap-theme.css')}}" rel="stylesheet">
</head>
<body>
    <main id="acordion">
        <div class="content-all" >
            <header>
            </header>
            <input type="checkbox" id="check">
            <label for="check" class="fa fa-bars">Menu</label>


            <!-- Imagen ITSCH -->
            <div style="position: fixed;left: 97%;top: 8px;">
                <a  href="{{ url('/home') }}">
                    <div style="text-align: center;">
                        <img src="{{ asset('images/itsch.jpg') }}" border="0" width="35" height="40" class="img-rounded">
                    </div>
                </a>
            </div>

            <!-- Incluye sistema de alertas-->
            @include('template.partes.alertas')



            <!-- Incluye el menu al sistema -->
            @include('template.partes.menu')

        </div>

        <!--Div para el contenido de todo el sistema -->
        <div class="container" id="divPrincipal">
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active"> @yield('ruta','Default')
                    </li>
                </ol>
                <div class="container" id="contenido">
                    <div class="col-md-12">
                        <h1>Sistema de creditos complementarios CREDITSCH</h1>
                        <h3>Contenido del sistema</h3>
                        <section>
                            @include('flash::message') <!-- Esto es para mostrar los mensajes en los formularios -->
                        </section>
                        @yield('contenido','Default')<!-- Contenido general del sistema -->
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Incluye el menu al sistema -->
    @include('template.partes.pie')



    <script src="{{asset('plugins/vendorTem/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('complementos/js/bootstrap.js')}}"></script>
    <script src="{{asset('js2/js2.js')}}"> </script>

</body>
</html>