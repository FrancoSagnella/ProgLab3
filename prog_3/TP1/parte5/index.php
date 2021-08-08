<?php
    require_once ("./backend/validarSesion.php");
    require_once ("./clases/fabrica.php");

    $title = "<title>HTML5 - Formulario Alta Empleados</title>";
    $h2 = "<h2>Alta de empleados</h2>";
    $hdnModificar = "value='alta'";

    $txtDni = "";
    $txtApellido = "";
    $txtNombre = "";
    $cboSeleccione = "selected";
    $cboM = "";
    $cboF = "";

    $txtLegajo = "";
    $txtSueldo = "";
    $rdoManiana = "checked='checked'";
    $rdoTarde = "";
    $rdoNoche = "";

    $btnEnviar = "Enviar";

    if(isset($_POST['hiddenMod']))
    {
        $fabrica = new Fabrica("mi fabrica" , 7);
        $fabrica->traerDeArchivo("./archivos/empleados.txt");

        foreach($fabrica->getEmpleados() as $value)
        {
            if($value->getDni() == $_POST['hiddenMod'])
            {
                $title = "<title>HTML5 - Formulario Modificar Empleados</title>";
                $h2 = "<h2>Modificar empleado</h2>";
                $hdnModificar = "value='modif'";

                $txtDni = "value='".$value->getDni()."' readonly";
                $txtApellido = "value='".$value->getApellido()."'";
                $txtNombre = "value='".$value->getNombre()."'";
                $cboSeleccione = "";

                switch($value->getSexo())
                {
                    case "M":
                        $cboM = "selected";
                        break;
                    case "F":
                        $cboF = "selected";
                        break;
                }
                
                $txtLegajo = "value='".$value->getLegajo()."' readonly";
                $txtSueldo = "value='".$value->getSueldo()."'";
                $rdoManiana = "";
                switch($value->getTurno())
                {
                    case "Maniana":
                        $rdoManiana = "checked='checked'";
                        break;
                    case "Tarde":
                        $rdoTarde = "checked='checked'";
                        break;
                    case "Noche":
                        $rdoNoche = "checked='checked'";
                        break;
                }

                $btnEnviar = "Modificar";
                break;
            }
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf 8" />
    <script src="./javascript/funciones.js" ></script>
    <?php echo $title ?>

    <a href="./backend/cerrarSesion.php">Cerrar sesion</a>
</head>

<body>
    <?php echo $h2?>
    <form id="form" action="./administracion.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="hdnModificar" id="hdnModificar" <?php echo $hdnModificar?>/>
        <table align="center">

            <!--DATOS PERSONALES-->
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
                        <input type="number" name="txtDni" id="txtDni" min="1000000" max="55000000" <?php echo $txtDni?>/>
                    </td>
                    <td>
                        <span id="spanDni" style="display:none">*</span>
                    </td>
                </tr>
                <tr>
                    <td>Apellido:</td>
                    <td>
                        <input type="text" name="txtApellido" id="txtApellido" <?php echo $txtApellido?>/>
                    </td>
                    <td>
                        <span id="spanApellido" style="display:none">*</span>
                    </td>
                </tr>
                <tr>
                    <td>Nombre:</td>
                    <td>
                        <input type="text" name="txtNombre" id="txtNombre" <?php echo $txtNombre?>/>
                    </td>
                    <td>
                        <span id="spanNombre" style="display:none">*</span>
                    </td>
                </tr>
                <tr>
                    <td>Sexo:</td>
                    <td>
                        <select name="cboSexo" id="cboSexo" >
                            <option value="---" <?php echo "$cboSeleccione" ?> >Seleccione</option>
                            <option value="M" <?php echo "$cboM" ?> >Masculino</option>
                            <option value="F" <?php echo "$cboF" ?> >Femenino</option>
                        </select>
                    </td>
                    <td>
                        <span id="spanSexo" style="display:none">*</span>
                    </td>
                </tr>
            </div>
            <!--TERMINA DATOS PERSONALES-->

            <!--DATOS LABORALES-->
            <div>
                <tr>
                    <td colspan="2"><h4>Datos laborales</h4></td>
                </tr>
                <tr>
                    <td colspan="2"><hr/></td>
                </tr>
                <tr>
                    <td>Legajo:</td>
                    <td>
                        <input type="number" name="txtLegajo" id="txtLegajo" min="100" max="550" <?php echo $txtLegajo?> />
                    </td>
                    <td>
                        <span id="spanLegajo" style="display:none">*</span>
                    </td>
                </tr>
                <tr>
                    <td>Sueldo:</td>
                    <td>
                        <input type="number" name="txtSueldo" id="txtSueldo" min="8000" step="500" <?php echo $txtSueldo?> />
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
                        <input type="radio" name="rdoTurno" id="maniana" value="Maniana" <?php echo "$rdoManiana"?> />
                    </td>
                    <td>Ma&ntilde;ana</td>
                </tr>
                <tr>
                    <td align="right">
                        <input type="radio" name="rdoTurno" id="tarde" value="Tarde" <?php echo "$rdoTarde"?> />
                    </td>
                    <td>Tarde</td>
                </tr>
                <tr>
                    <td align="right">
                        <input type="radio" name="rdoTurno" id="noche" value="Noche" <?php echo "$rdoNoche"?> />
                    </td>
                    <td>Noche</td>
                </tr>
            </div>
            <!--TERMINA DATOS LABORALES-->

            <!--AGREGAR FOTO-->
            <div>
                <tr>
                    <td>Foto:</td>
                    <td>
                        <input type="file" name="archivo" id="archivo" value="Seleccionar un archivo"/>
                    </td>
                </tr>
            </div>
            <!--AGREGAR FOTO-->
            <!--SUBMIT-LIMPIAR-->
            <div>
                <tr>
                    <td colspan="2"><hr/></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <input type="reset" value="Limpiar" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <input type="submit" id="btnEnviar" value=<?php echo $btnEnviar?> onclick="AdministrarValidaciones(event)"/>
                    </td>
                </tr>
            </div>
            <!--TERMINA SUBMIT-LIMPIAR-->
        </table>
    </form>
</body>

</html>