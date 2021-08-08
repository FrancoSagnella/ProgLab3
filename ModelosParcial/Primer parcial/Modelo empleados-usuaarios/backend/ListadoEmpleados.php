<?php
        require_once "./clases/empleado.php";
        $aux = isset($_GET) ? true : false;
    
        if($aux){
            $accion = isset($_GET['tabla']) ? $_GET['tabla'] : 'No se paso tabla';
    
            $empArray = Empleado::TraerTodos();
    
            switch($accion)
            {
                case 'mostrar':
                    $tabla = "<table border=1>
                                <thead>
                                    <tr>
                                        <td>Id</td>
                                        <td>Nombre</td>
                                        <td>Correo</td>
                                        <td>id_Perfil</td>
                                        <td>Perfil</td>
                                        <td>Foto</td>
                                        <td>Sueldo</td>
                                    </tr>
                                </thead>
                                <tbody>";
    
                                foreach($empArray as $emp)
                                {
                                    $tabla.="<tr><td>$emp->id</td><td>$emp->nombre</td><td>$emp->correo</td><td>$emp->id_perfil</td><td>$emp->perfil</td>";
                                    $tabla.='<td><img src='.$emp->foto.' width=90 height=90 /></td>';
                                    $tabla.="<td>$emp->sueldo</td><tr></tr>";
                                }
                    $tabla .=   "</tbody>
                              </table>";
    
                    echo $tabla;
    
                    break;
                default:
                    
                    echo json_encode($empArray);
                    break;
            }
        }
        else{
            echo 'No se recibio parametro GET';
        }