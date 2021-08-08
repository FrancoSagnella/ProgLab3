<?php
require_once "clases/Ciudad.php";
$ciudadJson = isset($_POST['ciudad_json']) ? json_decode($_POST['ciudad_json'])  : NULL;
$foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;
$tipoArchivo =pathinfo($foto, PATHINFO_EXTENSION);
//modifico la foto y la vija la muevo, la modificada se queda aca
$verificar=new stdClass();
    $verificar->mensaje="error";
    $verificar->exito=false;
    $verificar->dato="";
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($ciudadJson!=null)
{
   // $verificar=new stdClass();
    $verificar->mensaje="error al modificar";
    $verificar->exito=false;
    $nombreFotoModificar= $ciudadJson->id . "." . $ciudadJson->nombre . "." . $ciudadJson->pais . ".modificado". "." . $tipoArchivo;
    $nombreFoto= $ciudadJson->nombre . "." . $ciudadJson->pais . "." . date("Gis") . "." . $tipoArchivo;
    $ciudadModificarArchivo;
    $lista=Ciudad::Traer();
    $pathFoto;
    foreach($lista as $ciudad)
    {
        if($ciudad->id==$ciudadJson->id)
        {
            $ciudadModificarArchivo=new Ciudad($ciudad->id,$ciudad->nombre,$ciudad->poblacion,$ciudad->pais,$nombreFotoModificar);
            $pathFoto=$ciudad->pathFoto;

            break;
        }
    }          
      $ciudadModificar=new Ciudad($ciudadJson->id,$ciudadJson->nombre,$ciudadJson->poblacion,$ciudadJson->pais,$nombreFoto);

   if($ciudadModificar->Modificar())
   { 
       $pahtViejoAgregado="ciudades/imagenes/" . $pathFoto;
    $tipoDeFoto =pathinfo($pahtViejoAgregado, PATHINFO_EXTENSION);
    if (file_exists($pahtViejoAgregado)) {
        rename($pahtViejoAgregado,"ciudadesModificadas/" . $nombreFotoModificar);
       // $this->pathFoto=$this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $tipoDeFoto;


       
    }
    $destino = "ciudades/imagenes/" . $nombreFoto;

    move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);

    $verificar->mensaje="se modifico correctamente y se guardo en el archivo";
    $verificar->exito=true;
    $ciudadModificarAr=new Ciudad($ciudadJson->id,$ciudadJson->nombre,$ciudadJson->poblacion,$ciudadJson->pais,$nombreFotoModificar);

       $ciudadModificarArchivo->GuardarEnArchivo("modificar");
    
        
   }
}
echo json_encode($verificar);
}
else if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $ArrayCiudad=array();
    $verificar->mensaje="lista cargada";
    $verificar->exito=true;
    $verificar->dato="";
        $fp=fopen("./archivos/ciudades_modificadas.json","r");

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
//echo json_encode($verificar);