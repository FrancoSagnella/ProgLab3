<?php
require_once "clases/Ciudad.php";
$ciudadJson = isset($_POST['ciudad_json']) ? json_decode($_POST['ciudad_json'])  : NULL;
//modifico la foto y la vija la muevo, la modificada se queda aca
$verificar=new stdClass();
    $verificar->mensaje=" ";
    $verificar->exito="";
    $verificar->dato="";
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($ciudadJson!=null)
{
   // $verificar=new stdClass();
    $verificar->mensaje="error al modificar";
    $verificar->exito=false;

    $lista=Ciudad::Traer();
    $ciudadEliminar;
    $nombreFotoEliminar;
    $pahtViejoAgregado;
    foreach($lista as $ciudad)
    {
        if($ciudad->pais==$ciudadJson->pais && $ciudad->nombre==$ciudadJson->nombre )
        {

               $pahtViejoAgregado="ciudades/imagenes/" . $ciudad->pathFoto;
             $tipoDeFoto =pathinfo($pahtViejoAgregado, PATHINFO_EXTENSION);
             $nombreFotoEliminar=$ciudadJson->id . "." . $ciudadJson->nombre . ".borrado." . $tipoDeFoto;
            $ciudadEliminar=new Ciudad($ciudad->id,$ciudad->nombre,$ciudad->poblacion,$ciudad->pais,$nombreFotoEliminar);
          
            break;
        }
    }          
     // $ciudadModificar=new Ciudad($ciudadJson->id,$ciudadJson->nombre,$ciudadJson->poblacion,$ciudadJson->pais,$nombreFoto);

   if($ciudadEliminar->Eliminar())
   { 
      
    if (file_exists($pahtViejoAgregado)) {
        rename($pahtViejoAgregado,"ciudadesBorradas/" . $nombreFotoEliminar);
       // $this->pathFoto=$this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $tipoDeFoto;
    }

    $verificar->mensaje="se borro correctamente y se guardo en el archivo";
    $verificar->exito=true;
       $ciudadEliminar->GuardarEnArchivo("borrar");
    
        
   }
}
echo json_encode($verificar);
}
else if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $nombre = isset($_GET['nombre']) ? $_GET['nombre']  : NULL;
if($nombre!=null)
{
    $lista=Ciudad::Traer();
    $verificar->mensaje="no se encontro ese nombre en la base de datos";
    $verificar->exito=false;
    $verificar->dato="";
    foreach($lista as $ciudad)
    {
        if( $ciudad->nombre==$nombre )
        {
            $verificar->mensaje="esta el nombre en la base de datos";
            $verificar->exito=true;
            $verificar->dato="";
            break;
        }
    }  
    echo json_encode($verificar);
}
else {
    $ArrayCiudad=array();
    $verificar->mensaje="lista cargada";
    $verificar->exito=true;
    $verificar->dato="";
        $fp=fopen("./archivos/ciudades_borradas.json","r");

        while(!feof($fp) )
        {
             $contenido=fgets($fp);
              $ciudad=trim($contenido);

            if($ciudad=="")
            {
                 break;
            }
             $ciudad=json_decode($contenido);
            
            if($ciudad!="" );
            {
                array_push($ArrayCiudad,new Ciudad($ciudad->id,$ciudad->nombre,$ciudad->poblacion,$ciudad->pais,$ciudad->pathFoto)) ;
            }
       
        }
         fclose($fp);
         $verificar->dato=$ArrayCiudad;

        // echo var_dump($ArrayCiudad);
        echo json_encode($verificar);
}
    
    }
//echo json_encode($verificar);