<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title>Creditsch|@yield('title','Default')</title>
        <link rel="icon" href="{{ asset('images/itsch.ico') }}">
        <meta name="description" content="Este es el sistema de administración de créditos complementarios del TECNM Campus Ciudad Hidalgo, que permite el control del avance de los créditos de cada estudiante.">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>

        {{--Links y scripts para funcion de tabledata--}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/r-2.3.0/sc-2.0.7/sb-1.3.4/sl-1.4.0/datatables.min.css"/>

        {{-- MDBootstrap --}}
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
        <!-- Google Fonts Roboto -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"/>
        <!-- MDB -->
        <link rel="stylesheet" href="{{ asset('css/mdb.min.css') }}" />
        {{-- Estilos sta --}}
        <link rel="stylesheet" href="{{ asset('css/sta/estilos.css') }}" />

        <style>
            .error {
                border: 1px solid red;
            }
        </style>

        @yield('links')
    </head>
    <body>
        <!--Main Navigation-->
        <header>
           @include('template.partes.menu')
        </header>

        <!--Section: Content-->
        <section class="text-center text-md-start">

            @include('sweetalert::alert')
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10" style="margin-bottom: 200px;">
                    <h3 class="mb-5"><strong> @yield('ruta','Default') </strong></h3>
                    @yield('contenido','Default')<!-- Contenido general del sistema -->
                </div>
                <div class="col-sm-1"></div>
            </div>
        </section>
        <!--Section: Content-->

        <!-- Footer -->
        <footer class="page-footer font-small fixed-bottom bg-dark text-center text-white">
            <!-- Footer Elements -->
            <div class="container">

            <!-- Grid row-->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12 py-3">
                <div class="list-unstyled list-inline text-center">

                    <!-- Facebook -->
                    <a class="fb-ic" href="https://www.facebook.com/profile.php?id=100057428089409" target="_blank">
                        <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>  
                    &nbsp;&nbsp;                 
                    <!--Linkedin -->
                    <a class="li-ic" href="https://www.linkedin.com/in/oscar-delgado-camacho-68bab2114/">
                        <i class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>       
                    &nbsp;&nbsp;
                    <a href="https://kioselsar.com" target="_blank" >
                        <i class="fas fa-globe"></i>
                    </a>
                </div>
                </div>
                <!-- Grid column -->

            </div>
            <!-- Grid row-->

            </div>
            <!-- Footer Elements -->

            <!-- Copyright -->
            <div class="text-center py-3" style="background-color: rgba(0, 0, 0, 0.2);">© 2022 Copyright:
                <a href="https://github.com/kioselsa" target="_blank"> Kioselsar</a> & <a href="https://github.com/Madophs" target="_blank">Madophs</a> ,Contact: <a href="https://kioselsar.com" target="_blank">kioselsar.com</a>
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->


        <!-- Scripts Section -->
        <script type="text/javascript"> const ASSET_URL = "{{ asset('/') }}" </script>

        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        {{-- CDN sweetalert --}}
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        {{-- Scripts para datatable y para pdfmaker --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/r-2.3.0/sc-2.0.7/sb-1.3.4/sl-1.4.0/datatables.min.js"></script>

        <!-- MDB -->
        <script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>

        <!-- Scripts de la aplicacion -->
        <script type="text/javascript" src="{{ asset('js/utilidades.js') }}"></script>

        @yield('js')

    </body>
</html>
