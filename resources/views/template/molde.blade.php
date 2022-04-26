<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title>Inicio|@yield('title','Default')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>

        {{-- MDBootstrap --}}
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
        <!-- Google Fonts Roboto -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"/>
        <!-- MDB -->
        <link rel="stylesheet" href="{{ asset('css/mdb.min.css') }}" />

         {{--Links y scripts para funcion de tabledata--}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.22/b-1.6.4/b-colvis-1.6.4/b-flash-1.6.4/b-html5-1.6.4/b-print-1.6.4/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.0/sp-1.2.0/sl-1.3.1/datatables.min.css"/>   
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    
    </head>
    <body>
        <!--Main Navigation-->
        <header>
           @include('template.partes.menu')
        </header>       
        
        <!--Section: Content-->
        <section class="text-center text-md-start">
            <h3 class="mb-5"><strong> @yield('ruta','Default') </strong></h3>               
            @include('template.flash-message')
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
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
                <div class="col-md-12 py-5">
                <div class="list-unstyled list-inline text-center">
        
                    <!-- Facebook -->
                    <a class="fb-ic">
                        <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <!-- Twitter -->
                    <a class="tw-ic">
                    <i class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <!-- Google +-->
                    <a class="gplus-ic">
                    <i class="fab fa-google-plus-g fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <!--Linkedin -->
                    <a class="li-ic">
                    <i class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <!--Instagram-->
                    <a class="ins-ic">
                    <i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <!--Pinterest-->
                    <a class="pin-ic">
                    <i class="fab fa-pinterest fa-lg white-text fa-2x"> </i>
                    </a>
                </div>
                </div>
                <!-- Grid column -->
        
            </div>
            <!-- Grid row-->
        
            </div>
            <!-- Footer Elements -->
        
            <!-- Copyright -->
            <div class="text-center py-3" style="background-color: rgba(0, 0, 0, 0.2);">© 2021 Copyright:
            <a href="https://github.com/kioselsa"> Kioselsar.com</a>
            </div>
            <!-- Copyright -->
        
        </footer>
        <!-- Footer -->
        
        
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <!-- MDB -->
        <script type="text/javascript" src="{{ asset('js/mdb.min.js') }}"></script>
       
        {{-- Scripts para datatable y para pdfmaker --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.22/b-1.6.4/b-colvis-1.6.4/b-flash-1.6.4/b-html5-1.6.4/b-print-1.6.4/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.0/sp-1.2.0/sl-1.3.1/datatables.min.js"></script>
       
        <script>
            //Script qwue cierra los mensajes flash de forma automatica
            $(document).ready(function(event)
            {
                $('.mdshide').delay(1500).fadeOut(3000);
            }); 
        </script>

        @yield('js')
       
    </body>
</html>