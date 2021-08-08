<?php
require_once "clases/Ciudad.php";
$ciudadJson = isset($_POST['ciudad']) ? json_decode($_POST['ciudad'])  : NULL;
if($ciudadJson!=null)
{
    $encontro=true;
    $lista=Ciudad::Traer();
    foreach($lista as $ciudad)
    {
        if($ciudadJson->pais==$ciudad->pais && $ciudadJson->nombre==$ciudad->nombre)
        {
            $encontro=false;
            echo json_encode($ciudad) ;
            break;
        }

    }
    if($encontro)
    {
        $concidenciaNombre=false;
        $concidenciapais=false;
        $nombre = array_column($lista, "nombre");
        foreach($nombre as $aux)
        {
            if($ciudadJson->nombre==$aux)
            {
                $concidenciaNombre=true;
                break;
            }
    
        }
        $pais = array_column($lista, "pais");
        if($concidenciaNombre==false)
        {
            foreach($pais as $aux)
            {
                 if($ciudadJson->pais==$aux)
                  {
                     $concidenciapais=true;
                        break;
                 }
            
           }
        }
        
        if($concidenciaNombre==true && $concidenciapais==false)
        {
            echo("no coincide el pais");
        }
        else if($concidenciaNombre==false && $concidenciapais==true)
        {
            echo("no coincide el nombre");

        }
        else
        {
            echo("no coincide el nombre ni el pais");
        }
    }

}
