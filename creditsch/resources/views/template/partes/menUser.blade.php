<!-- Tabla para los mensajes de alerta y busqueda -->

    <nav class="navbar navbar-expand-sm  ">                 
            <!-- Menu para cerrar la sesion--> 
               <ul class="navbar-nav"> 
            @if (Auth::guard('alumno')->check())
                <!-- Link para cambiar perfil y cerrar cesión en la seccion alumnos -->  
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbardrop" data-toggle="dropdown">                           
                        {{ Auth::guard('alumno')->user()->nombre }}
                    </a>
                    <div class="dropdown-menu">
                        <!-- Agregamos la ruta para poder iniciar sesion -->
                        <a class="dropdown-item" href="{{ route('alumnos.logout')}}" onclick="event.preventDefault(); document.getElementById('alumnos-logout-form').submit();">Cerrar sesión</a>
                        <!-- Creamos el formularios en orden para que nos podramos cerrar sesion -->
                        <form id="alumnos-logout-form" action="{{ route('alumnos.logout')}}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            @else
                  <!-- Link para cambiar perfil y cerrar cesión en la seccion administrativos-->        
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbardrop" data-toggle="dropdown">
                     {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('perfil.index')}}">Mi perfil</a>
                        <a class="dropdown-item" href="{{ route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>                             
                        <form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">
                           {{ csrf_field() }}
                        </form>                       
                    </div>
                </li>
            @endif 
        </ul>
    </nav>          


