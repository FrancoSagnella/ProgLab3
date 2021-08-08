<?php

class Producto
{
    public $nombre;
    public $origen;

    public function __construct($nombre,$origen)
    {
        $this->nombre=$nombre;
        $this->origen=$origen;
    }
    public function ToJSON(){
            
        return '{"nombre": "'. $this->nombre . '","origen": "'. $this->origen . '"}';
    }
    public function GuardarJSON($path)
    {
        $validarJSon=json_decode('{"validar":"false", "mensaje":"no se logro guardar correctamente"}');
        $fp = fopen($path,"a");
        $producto=$this->ToJSON();
        $guardar=trim($producto);
        if(fwrite($fp,$guardar . "\r\n")>0)
        {
            $validarJSon->validar="true";
            $validarJSon->mensaje="guardado correctamente";
        }
        fclose($fp);
           
        return $validarJSon;
    }
    public static function TraerJSon()
    {
        $ArrayProductos=array();

        $fp=fopen("./archivos/productos.json","r");

        while(!feof($fp) )
        {
             $contenido=fgets($fp);
              $producto=trim($contenido);

            if($producto=="")
            {
                 break;
            }
             $producto=json_decode($contenido);
            
            if($producto!="" );
            {
                array_push($ArrayProductos,new Producto($producto->nombre,$producto->origen)) ;
            }
       
        }
         fclose($fp);
        return $ArrayProductos;
    }
    public static function VerificarProductoJSon($producto)
    {
        
            $ret = new stdClass();
            $ret->validar = false;
            $ret->mensaje = "No se encontro el producto en el archivo";
            $cont = array();

            $array_prod = Producto::TraerJSON();

            foreach($array_prod as $prod)
            {
                if($prod->nombre == $producto->nombre && $prod->origen == $producto->origen)
                {
                    $ret->validar = true;
                    if(!isset($cont[$prod->origen]))
                    {
                        $cont[$prod->origen] = 1;
                    }
                    else
                    {
                        $cont[$prod->origen]++;
                    }
                }
                if(!isset($cont[$prod->nombre]))
                {
                    $cont[$prod->nombre] = 1;
                }
                else
                {
                    $cont[$prod->nombre]++;
                }
            }

            if($ret->validar)
            {
                $ret->mensaje = "Se encontro el producto, hay ".$cont[$producto->origen]." productos registrados con el mismo origen";
            }
            else
            {
                $aux = 0;
                foreach($cont as $nombre => $cant)
                {
                    if($cant > $aux)
                    {
                        $aux = $cant;
                        $ret->mensaje = "No se encontro el producto, El producto mas popular es ".$nombre." y aparecio ".$cant." veces";
                    }
                }
            }
            return json_encode($ret);
        
        /*$validarJSon=json_decode('{"validar":"false", "mensaje":"no se logro guardar correctamente"}');

        $arrayProducdo=$producto->TraerJSon();
        foreach($arrayProducdo as $auxProducto)
        {
            if($auxProducto->nombre==$producto->nombre && $auxProducto->origen==$producto->origen)
            {
                $cantidad=0;
                foreach($arrayProducdo as $auxProducto)
                {
                    
                    if($auxProducto->origen==$producto->origen)
                    {
                        $cantidad++;
                    }
                }
                $validarJSon->validar="true";
            $validarJSon->mensaje="el producto existe y tiene ". $cantidad ." productos con mismo origen";
            break;
            }

            else
            {
                
                $popular=0;
                $origenPopular="";
                $origenPopularV="";
                foreach($arrayProducdo as $auxProducto)
                {
                    $cantidad=0;
                    if($auxProducto->origen==$auxProducto->origen)
                    {
                        $cantidad++;
                        $cantidadMax=$cantidad;
                        
                    }
                    if($popular<$cantidadMax)
                          {
                             $popular=$cantidadMax;
                             $origenPopular=$auxProducto->origen;
                             $origenPopularV="";

                           }
                        if($popular==$cantidadMax)
                           {
                               $origenPopularV.=" " . $auxProducto->origen;
                           }
                    
                }
                if( $origenPopularV==""
                )
                {
                                    $validarJSon->mensaje="el/los productos mas populares es/son ". $origenPopular;

                }
                else 
                {
                    $validarJSon->mensaje="el/los productos mas populares es/son ". $origenPopularV;

                }
            }
        }
        return $validarJSon;*/
    }
}