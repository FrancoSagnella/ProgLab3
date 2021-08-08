<?php
require_once "./clases/usuario.php";
    $aux = isset($_GET) ? true : false;

    if($aux){
        $user_array = Usuario::TraerTodosJSON();
        echo json_encode($user_array);
    }
    else{
        echo 'No se recibio GET';
    }