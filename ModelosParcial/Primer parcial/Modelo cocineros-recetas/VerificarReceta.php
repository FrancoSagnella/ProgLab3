<?php
        require_once "clases/Recetas.php";
        $receta = isset($_POST['receta']) ? $_POST['receta'] : NULL;
        
        $receta=json_decode($receta);
        
        $aux = new Recetas(null,$receta->nombre,null,$receta->tipo);
        $listaRecetas = $aux->Traer();
    
        
        if($aux->Existe($listaRecetas))
        {
            foreach ($listaRecetas as $unaReceta) {
    
                if ($receta->nombre == $unaReceta->nombre && $unaReceta->tipo == $receta->tipo) {
                    
                    echo $unaReceta->ToJSON();
                    break;
                 
                } else if ($receta->nombre != $unaReceta->nombre) {
                    echo "No hay coincidencias con ese Nombre!";
                    break;
                } else if ($unaReceta->tipo != $receta->tipo) {
            
                    echo "No hay coincidencias con ese tipo!";
                    break;
                }
            }
        }else
            echo "No hay coincidencias con ese Nombre ni ese tipo!";
        