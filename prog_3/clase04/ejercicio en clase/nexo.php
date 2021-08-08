<?php


$accion = isset($_POST["accion"]) ? $_POST["accion"] : "nada";

switch ($accion) 
{
    case "alta":

        $destino = "./fotos/" . $_FILES["foto"]["name"];
        $_FILES["foto"]["name"] = $_POST["legajo"] . "." . pathinfo($destino, PATHINFO_EXTENSION);
        $destino = "./fotos/" . $_FILES["foto"]["name"];

        move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);

        $fp = fopen("./archivos/alumnos.txt", "a");

        fputs($fp, "$_POST[legajo] - $_POST[nombre] - $_POST[apellido] - $destino\r\n");

        fclose($fp);
        break;

    case "listado":

        $fp = fopen("./archivos/alumnos.txt", "r");

        echo fread($fp, filesize("./archivos/alumnos.txt"));

        fclose($fp);
        break;

    case "verificar":

        $aux = verificar();
        if($aux != false)
        {
            session_start();
            $_SESSION['legajo'] = $aux[0];
            $_SESSION['nombre'] = $aux[1];
            $_SESSION['apellido'] = $aux[2];

            header('location: ./principal.php');
        }
        else
        {
            echo "El alumno con el legajo $_POST[legajo] no se encuentra en el listado";
        }
        break;

    default:
        echo "No se recibio ningun caso por post";

}

//busca que haya en el listado, un alumno que tenga el mismo legajo
//que recibi por post
//me devuelve null si no existe, o el array con sus datos si s existe
function verificar()
{
    $retorno = false;

    $fp = fopen("./archivos/alumnos.txt", "r");

    //me devuelve true o false si el cursor que esta leyendo el archivo llego al final o no
    //cuando llega al final devuelve true, entonces como esta negado devuelve false y se corta el while
    while(!feof($fp))
    {
       //Dentro de cada iteracion voy leyendo linea por linea con fgets y lo guardo en un string
        //Esto me va a ir moviendo el cursor hasta llegar al final del archivo
        $stringAux = fgets($fp);

        //con el string que lei, uso explode que me devuelve un array
        //dividiendo la cadena cada vez que se encuentra los caracteres
        //del primer parametro que le paso
        $arrayAlumno = explode(" - ", $stringAux);

        //en el array se me guardan en cada indice, los datos que fui seprando
        //osea: [0] el legajo (el primer dato segun la lista) [1] el nombre y asi
        //entonces comparo el indice donde esta el legajo(el [0]) con el
        //valor que me vino desde el POST del legajo, si son iguales lo muestro, si no, no
        if($arrayAlumno[0] == $_POST["legajo"])
        {
            $retorno = $arrayAlumno;
            break;
        }
    }
    fclose($fp);
    return $retorno;
}