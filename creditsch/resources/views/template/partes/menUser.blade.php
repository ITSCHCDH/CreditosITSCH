<!-- Tabla para los mensajes de alerta y busqueda -->
               
            <!-- Menu para cerrar la sesion--> 
              
            @if (Auth::guard('alumno')->check())
                <!-- Link para cambiar perfil y cerrar cesión en la seccion alumnos -->     
                    {{ Auth::guard('alumno')->user()->nombre }}                  
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
                     {{ Auth::user()->name }}                   
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('perfil.index')}}">Mi perfil</a>
                        <a class="dropdown-item" href="{{ route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>                             
                        <form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">
                           {{ csrf_field() }}
                        </form>                       
                    </div>
                </li>
            @endif 
        
  


