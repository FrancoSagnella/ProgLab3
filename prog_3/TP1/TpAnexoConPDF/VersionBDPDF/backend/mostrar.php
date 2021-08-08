<?php
require_once("../clases/empleado.php");
require_once("../clases/fabrica.php");
require_once './vendor/autoload.php';

$accion = isset($_POST['accion']) ? $_POST['accion'] : false;

switch ($accion) {
    case "mostrar":

        $fabrica = new Fabrica('Mi fabrica', 7);
        $fabrica->traerDeBD();

        $lista = '<table>
                <thead>
                    <tr>
                        <td >
                            <h4>Nombre</h4>                    
                        </td>
                        <td >
                            <h4>Apellido</h4>                    
                        </td>
                        <td >
                            <h4>DNI</h4>                    
                        </td>
                        <td >
                            <h4>Sexo</h4>                    
                        </td>
                        <td >
                            <h4>Legajo</h4>                    
                        </td>
                        <td >
                            <h4>Sueldo</h4>                    
                        </td>
                        <td >
                            <h4>Turno</h4>                    
                        </td>
                        <td >
                            <h4>PathFoto</h4>                    
                        </td>
                        <td>
                            <a href="./backend/MostrarPDF.php" target="_blank">Ver listado en PDF</a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" ><hr /></td>
                    </tr>
                </thead>
                <tbody>';

        foreach ($fabrica->getEmpleados() as $value) {
            $lista .= '<tr>
            <td >
                '.$value->getNombre().'                    
            </td>
            <td >
            '.$value->getApellido().'                                    
            </td>
            <td >
            '.$value->getDni().'                                      
            </td>
            <td >
            '.$value->getSexo().'                                       
            </td>
            <td >
            '.$value->getLegajo().'                                       
            </td>
            <td >
            '.$value->getSueldo().'                                       
            </td>
            <td >
            '.$value->getTurno().'                                      
            </td>
            <td >
            '.$value->getPathFoto().'                                       
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
