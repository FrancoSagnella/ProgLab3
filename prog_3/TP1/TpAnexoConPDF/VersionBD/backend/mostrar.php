<?php
require_once("../clases/empleado.php");
require_once("../clases/fabrica.php");

$accion = isset($_POST['accion']) ? $_POST['accion'] : false;

switch ($accion) {
    case "mostrar":

        $fabrica = new Fabrica('Mi fabrica', 7);
        $fabrica->traerDeBD();

        $lista = '<table>
                <thead>
                    <tr>
                        <td colspan="3" >
                        <h4>Info</h4>                    
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" ><hr /></td>
                    </tr>
                </thead>
                <tbody>';

        foreach ($fabrica->getEmpleados() as $value) {
            $lista .= '<tr>
                <td>
                    ' . $value->toString() . '
                </td>
                <td>
                    
                    <img src=' . $value->getPathFoto() . ' width=90 height=90 />
                </td>
                <td>
                    <table>
                        <tr>
                            <td>
                            <input type="button" name="btnEliminar" id="btnEliminar" value="eliminar" onclick="AdministrarEliminar(' . $value->getLegajo() . ')"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <input type="button" name="btnModificar" id="btnModificar" value="modificar" onclick="AdministrarModificar(' . $value->getDni() . ', \'' . $value->getApellido() . '\'' . ', \'' . $value->getNombre() . '\'' . ', \'' . $value->getSexo() . '\'' . ', ' . $value->getLegajo() . ', ' . $value->getSueldo() . ', \'' . $value->getTurno() . '\')"/>                                                                                                        
                            </td>
                        </tr>
                    </table>        
                </td>
            </tr>';
        }

        $lista .= "</tbody>
                    </table>";

        echo $lista;
        break;
    }
