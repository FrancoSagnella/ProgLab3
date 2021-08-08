<?php
    require_once "./clases/usuario.php";
    $aux = isset($_GET) ? true : false;

    if($aux){
        $accion = isset($_GET['tabla']) ? $_GET['tabla'] : 'No se paso tabla';

        $userArray = Usuario::TraerTodos();
        $userArraySinClave = Usuario::DevolverArrayUsuariosSinClave($userArray);

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
                                </tr>
                            </thead>
                            <tbody>";

                            foreach($userArraySinClave as $user)
                            {
                                $tabla.="<tr><td>$user->id</td>
                                <td>$user->nombre</td>
                                <td>$user->correo</td>
                                <td>$user->id_perfil</td>
                                <td>$user->perfil</td>
                                </td></tr>";
                            }
                $tabla .=   "</tbody>
                          </table>";

                echo $tabla;

                break;
            default:
                
                echo json_encode($userArraySinClave);
                break;
        }
    }
    else{
        echo 'No se recibio parametro GET';
    }