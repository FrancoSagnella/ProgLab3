<?php
    //require_once ("./backend/validarSesion.php");
    //require_once ("./clases/fabrica.php");
?> 

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf 8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="./javascript/funciones.js"></script>

    <title> HTML5 - Formulario/Listado TP 1</title>
</head>

<body style="background-color:lightslategrey">

    <div class="container-fluid" >

        <div class="page-header"><h1>Sagnella Franco Ezequiel</h1></div>

        <div class="row" style="height:550px;overflow:auto">

            <div class="col-md-6 border border-white container-fluid" id="FrmDiv">
                <div class="page-header"><h4>Formulario ABM Empleados</h4></div>
                <form id="Form"> 

                    <div class="row" style="height:348px;overflow:auto">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="DNI">DNI:</label>
                                <input class="form-control" type="number" id="DNI" placeholder="Ingresa tu DNI"/>
                            </div>

                            <div class="form-group">
                                <label for="Nombre">Nombre:</label>
                                <input class="form-control" type="text" id="Nombre" placeholder="Ingresa tu nombre"/>
                            </div>

                            <div class="form-group">
                                <label for="Apellido">Apellido:</label>
                                <input class="form-control" type="text" id="Apellido" placeholder="Ingresa tu apellido"/>
                            </div>

                            <div class="form-group"><label for="Sexo">Sexo:</label>
                                <select class="form-control" id="Sexo" >
                                    <option value="---" >Seleccione</option>
                                    <option value="M" >Masculino</option>
                                    <option value="F" >Femenino</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-6" >
                            <div class="form-group">
                                <label for="Legajo">Legajo:</label>
                                <input class="form-control" type="number" id="Legajo" placeholder="Ingresa tu Legajo"/>
                            </div>

                            <div class="form-group">
                                <label for="Sueldo">Sueldo:</label>
                                <input class="form-control" type="number" id="Sueldo" placeholder="Ingresa tu Nombre"/>
                            </div>

                            <div class="form-group">
                                <label for="rdoTurno">Turno:</label>
                                <input type="radio" name="rdoTurno" id="Mañana" checked/>
                                <input type="radio" name="rdoTurno" id="Tarde" />
                                <input type="radio" name="rdoTurno" id="Noche" />
                            </div>
                        </div>

                    </div>

                    <div class="row" style="height:200px;overflow:auto">

                        <div class="col-12" >foto de perfil</div>

                    </div>

                </form>

            </div>

            <div class="col-md-6 border border-white" id="ListDiv">

            </div>  
        </div>

        <div class="row"><p>Aca van los botones para desloguear</p></div>
    </div>
</body>

