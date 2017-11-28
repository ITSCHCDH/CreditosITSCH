<!-- Tabla para los mensajes de alerta y busqueda -->
<div class="table-responsive alertas" id="tabAlertas">
    <table class="table">
        <thead>
        <tr>
            <td>
                <!--  Menu de alertas y mensajes -->
                <ul class="navbar-nav ml-auto">
                    <!-- Link para los mensajes-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-envelope"></i>
                            <span class="d-lg-none txt">Mensajes
                                                        <span class="badge badge-pill badge-primary">5 Nuevos</span>
                                                    </span>
                            <span class="indicator text-primary d-none d-lg-block">
                                                        <i class="fa fa-fw fa-circle" id="indMensajes"></i>
                                                    </span>
                        </a>

                        <!--Div para los mensajes recibidos -->
                        <div class="dropdown-menu" aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">Nuevos Mensajes:</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                                        <span class="text-success">
                                                            <strong>
                                                                 <i class="fa fa-long-arrow-up fa-fw"></i>Mensaje 1</strong>
                                                         </span>
                                <span class="small float-right text-muted">11:21 AM</span>
                                <div class="dropdown-message small">Esate es el primer mensaje recibido</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                                            <span class="text-danger">
                                                                <strong>
                                                                    <i class="fa fa-long-arrow-down fa-fw"></i>Mensaje 2</strong>
                                                            </span>
                                <span class="small float-right text-muted">11:40 AM</span>
                                <div class="dropdown-message small">Este es el segundo mensaje recibido.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item small" href="#">View all messages</a>
                        </div>
                    </li>

                    <!-- Link para las alertas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-bell"></i>
                            <span class="d-lg-none txt">Alerts
                                                    <span class="badge badge-pill badge-warning">6 New</span>
                                                </span>
                            <span class="indicator text-warning d-none d-lg-block">
                                                    <i class="fa fa-fw fa-circle" id="indAlert"></i>
                                                </span>
                        </a>
                        <!--Mensajes de las alertas -->
                        <div class="dropdown-menu" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">New Alerts:</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                                    <span class="text-success">
                                                        <strong>
                                                             <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
                                                     </span>
                                <span class="small float-right text-muted">11:21 AM</span>
                                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                                        <span class="text-danger">
                                                            <strong>
                                                                <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
                                                        </span>
                                <span class="small float-right text-muted">11:21 AM</span>
                                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                                            <span class="text-success">
                                                                <strong>
                                                                    <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
                                                            </span>
                                <span class="small float-right text-muted">11:21 AM</span>
                                <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item small" href="#">View all alerts</a>
                        </div>

                    </li>
                </ul>
            </td>
            <td>
                <!-- Boton de busqueda de paginas -->

                <form class="form-inline my-2 my-lg-0 mr-lg-2" id="buscar">
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Buscar pagina...">
                        <div class="input-group-btn">
                            <button class="btn btn-primary" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </td>
            <td>
                <!-- Menu para cerrar la sesion-->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-fw fa-sign-out"></i>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Cerrar sesión</a>
                    </div>
                </li>

            </td>
        </tr>
        </thead>
    </table>
</div>

<!-- Div para mostrar solo la imagen de salir en resolucuiones de menos de 800px -->
<div class="salir" id="divSalir">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-sign-out"></i>
            {{ auth::user()->name }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">Cerrar sesión</a>
        </div>
    </li>
</div>