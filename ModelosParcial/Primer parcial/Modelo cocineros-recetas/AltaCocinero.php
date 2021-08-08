<?php
    require_once "clases/Cocinero.php";
    $especialidad = isset($_POST['especialidad']) ? $_POST['especialidad'] : NULL;
    $email = isset($_POST['email']) ? $_POST['email'] : NULL;
    $clave = isset($_POST['clave']) ? $_POST['clave'] : NULL;

    $cocinero = new Cocinero($especialidad,$email, $clave);

    $flag = $cocinero->GuardarEnArchivo();

    echo json_encode($flag);
?>