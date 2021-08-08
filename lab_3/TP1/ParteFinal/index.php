<?php
    require_once ("./backend/validarSesion.php");
    require_once ("./clases/fabrica.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf 8" />
    <script src="./javascript/funciones.js"></script>
    <script type="text/JavaScript">
        function limpiar(){
            document.getElementById("txtDni").readOnly = false; 
            document.getElementById("txtLegajo").readOnly = false; 
            document.getElementById("accion").value = "alta";
        }
        
    </script>
    <title> HTML5 - Formulario/Listado TP 1</title>
</head>

<body>
    <h1>Sagnella, Franco Ezequiel</h1>
    <hr />

    <div>
        <h2>ABM/Listado de Empleados</h2>
        <table border="1" >
            <tr>
                <td>
                    <div id="divForm" style="height:610px;overflow:auto">
                        <form id="form" action="./backend/administracion.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="accion" id="accion" value="alta" />
                            <table align="center">

                                <!-- DATOS PERSONALES -->
                                <div>
                                    <tr>
                                        <td colspan="2">
                                            <h4>Datos personales</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>DNI:</td>
                                        <td>
                                            <input type="number" name="txtDni" id="txtDni" min="1000000" max="55000000"  />
                                        </td>
                                        <td>
                                            <span id="spanDni" style="display:none">*</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apellido:</td>
                                        <td>
                                            <input type="text" name="txtApellido" id="txtApellido" />
                                        </td>
                                        <td>
                                            <span id="spanApellido" style="display:none">*</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nombre:</td>
                                        <td>
                                            <input type="text" name="txtNombre" id="txtNombre" />
                                        </td>
                                        <td>
                                            <span id="spanNombre" style="display:none">*</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sexo:</td>
                                        <td>
                                            <select name="cboSexo" id="cboSexo">
                                                <option value="---" >Seleccione</option>
                                                <option value="M" >Masculino</option>
                                                <option value="F" >Femenino</option>
                                            </select>
                                        </td>
                                        <td>
                                            <span id="spanSexo" style="display:none">*</span>
                                        </td>
                                    </tr>
                                </div>
                                <!-- ERMINA DATOS PERSONALES

                                    DATOS LABORALES -->
                                <div>
                                    <tr>
                                        <td colspan="2">
                                            <h4>Datos laborales</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Legajo:</td>
                                        <td>
                                            <input type="number" name="txtLegajo" id="txtLegajo" min="100" max="550"  />
                                        </td>
                                        <td>
                                            <span id="spanLegajo" style="display:none">*</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sueldo:</td>
                                        <td>
                                            <input type="number" name="txtSueldo" id="txtSueldo" min="8000" step="500" />
                                        </td>
                                        <td>
                                            <span id="spanSueldo" style="display:none">*</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Turno:</td>
                                    </tr>
                                    <tr>
                                        <td align="right">
                                            <input type="radio" name="rdoTurno" id="maniana" value="Maniana" checked="checked"/>
                                        </td>
                                        <td>Ma&ntilde;ana</td>
                                    </tr>
                                    <tr>
                                        <td align="right">
                                            <input type="radio" name="rdoTurno" id="tarde" value="Tarde" />
                                        </td>
                                        <td>Tarde</td>
                                    </tr>
                                    <tr>
                                        <td align="right">
                                            <input type="radio" name="rdoTurno" id="noche" value="Noche" />
                                        </td>
                                        <td>Noche</td>
                                    </tr>
                                </div>
                                <!-- TERMINA DATOS LABORALES

                                    AGREGAR FOT -->
                                <div>
                                    <tr>
                                        <td>Foto:</td>
                                        <td>
                                            <input type="file" name="archivo" id="archivo" value="Seleccionar un archivo" />
                                        </td>
                                    </tr>
                                </div>
                                <!-- AGREGAR FOTO
                                    SUBMIT-LIMPIAR -->
                                <div>
                                    <tr>
                                        <td colspan="2">
                                            <hr />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="right">
                                            <input type="reset" id="btnLimpiar" value="Limpiar" onclick="limpiar()"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="right">
                                            <input type="button" id="btnEnviar" value="Enviar" onclick="AdministrarValidaciones()" />
                                        </td>
                                    </tr>
                                </div>
                                <!-- TERMINA SUBMIT-LIMPIAR -->
                            </table>
                        </form>
                    </div>
                </td>
                <td>
                    <div id="divLista" style="height:610px;overflow:auto">

                    </div>
                </td>
            </tr>
        </table>
        <hr/>
        <a href="./backend/cerrarSesion.php">Cerrar sesion</a>
    </div>
</body>

