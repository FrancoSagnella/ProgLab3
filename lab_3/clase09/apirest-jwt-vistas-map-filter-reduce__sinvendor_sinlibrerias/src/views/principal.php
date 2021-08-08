{% extends 'layout.html' %}

{% block content %}
    <div class="container w-70" style="margin-top:30px">

        <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul id="main-nav" class="navbar-nav">
                    <img src="{{base_path() }}/images/utnLogo.png" class="navbar-brand rounded-circle" title="UTN fra" style="height:40px;width:40px" />
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            ApiRest con Ts <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="ApiRestGet()">Get</a>
                            <a class="dropdown-item" href="#" onclick="ApiRestPost()">Post</a>
                            <a class="dropdown-item" href="#" onclick="ApiRestPut()">Put</a>
                            <a class="dropdown-item" href="#" onclick="ApiRestDelete()">Delete</a>
                        </div>
                    </li>
                    <li class="dropdown dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Listado Autos <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="ApiRestGetListadoAutos()">Json</a>
                            <a class="dropdown-item" href="#" onclick="ApiRestGetListadoAutosTabla()">Tabla</a>
                            <a class="dropdown-item" href="#" onclick="ApiRestGetListadoAutosLocalStorage()">Guardar en LocalStorage</a>
                            <a class="dropdown-item" href="#" onclick="ObtenerAutosDelLocalStorage()">Recuperar de LocalStorage</a>
                        </div>
                    </li>
                    <li class="dropdown dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            MAP <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="ObtenerIdMarcas()">ID - Marcas</a>
                        </div>
                    </li>
                    <li class="dropdown dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            FILTER <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="ObtenerAutosFiltrados('marca')">Marca - Mercedes Benz</a>
                            <a class="dropdown-item" href="#" onclick="ObtenerAutosFiltrados('modelo')">Modelo - 1977</a>
                            <a class="dropdown-item" href="#" onclick="ObtenerAutosFiltrados('color')">Color - Aquamarine</a>
                        </div>
                    </li>
                    <li class="dropdown dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            REDUCE <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="ObtenerCantidadAutosPorMarca()">Cantidad por Marca</a>
                            <a class="dropdown-item" href="#" onclick="ObtenerPreciosPromedio()">Promedio de precios</a>
                            <a class="dropdown-item" href="#" onclick="ObtenerPreciosPromedioPorColor()">Promedio de precios por Color</a>
                        </div>
                    </li>

                    <li class="dropdown dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            CREDENCIALES <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="MostrarLogin()">Login</a>
                            <a class="dropdown-item" href="#" onclick="VerificarJWT()">Verificar JWT</a>
                            <a class="dropdown-item" href="#" onclick="Logout()">Logout</a>
                        </div>
                    </li>

                    <li class="dropdown dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            LISTADO (login required!) <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="ObtenerListadoCDs()">CDs</a>
                            <a class="dropdown-item" href="#">
                                <h6>Buscar por ID</h6>
                                <form class="form-inline">
                                    <input type="text" class="form-control mb-2 ml-sm-2" id="id_cd" placeholder="Id" style="width:60px">
                                    <button type="button" class="btn btn-primary mb-2" onclick="BuscarCDPorId()">
                                        <i class="bi-search"></i>
                                    </button>
                                </form>
                            </a>
                        </div>
                    </li>

                    <li class="dropdown dropdown">
                        <a class="nav-link " href="#" id="navbardrop" onclick="ArmarAltaCD()">
                        AGREGAR CD (login required!)
                        </a>
                    </li>

                    <li class="dropdown dropdown">
                        <a class="nav-link " href="#" id="navbardrop" >
                            <span id="usuario_info">---</span>
                        </a>
                    </li>
                </ul>
            </div>

        </nav>

    </div>

    <div id="cuerpo" class="container-fluid">

        <div class="row">

            <div class="col- col-md-6">
               
                <div class="row content">

                    <div id="divResultado" class="col- col-md- w-100">


                    </div>

                </div>

            </div>
            
            <div class="col- col-md-6">

                <div class="row content">
                   
                    <div class="col- col-md-12">
                        <div class="row w-100">  

                            <div class="col- col-md-4 ">
                            
                                <select id="cboMarca" class="form-control">
                                    <option>Seleccione</option>
                                </select>

                            </div>   

                            <div class="col- col-md-4 ">
                            
                                <select id="cboColor" class="form-control">
                                    <option>Seleccione</option>
                                </select>

                            </div>  

                            <div class="col- col-md-3 offset-md-1">
                            
                                <div class="btn-group mr-2" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary" id="btnMarcas">Marcas</button>
                                    <button type="button" class="btn btn-primary" id="btnColores">Colores</button>
                                </div>

                            </div> 
                        </div> 
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="container float-left">
        <div id="alert_success" class="alert alert-success w-50 invisible"></div>
    </div>

    <div class="modal" id="ventana_modal">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h4 class="modal-title text-white">Detalle del auto</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-light">
                    <p id="cuerpo_modal">Cuerpo...</p>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="ventana_modal_cd">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-white">CD - JWT</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-light">
                    <p id="cuerpo_modal_cd">Cuerpo...</p>
                </div>
            </div>
        </div>
    </div>

{% endblock %}