<?php
require_once ("clases/producto.php");
require_once ("clases/archivo.php");

$queHago = isset($_POST['queHago']) ? $_POST['queHago'] : NULL;

switch($queHago){

	case "mostrarGrilla":
	
		$ArrayDeProductos = Producto::TraerTodosLosProductos();

		$grilla = '<table class="table">
					<thead style="background:rgb(14, 26, 112);color:#fff;">
						<tr>
							<th>  COD. BARRA </th>
							<th>  NOMBRE     </th>
							<th>  FOTO       </th>
							<th>  ACCION       </th>
						</tr>  
					</thead>';   	

		foreach ($ArrayDeProductos as $prod){
		
			$grilla .= "<tr>
							<td>".$prod->GetCodBarra()."</td>
							<td>".$prod->GetNombre()."</td>
							<td><img src='archivos/".$prod->GetPathFoto()."' width='100px' height='100px'/></td>
							<td><input type='button' class='MiBotonUTN' onclick='Main.EliminarProducto(".json_encode('{"codBarra":"'.$prod->GetCodBarra().'", "nombre":"'.$prod->GetNombre().'", "pathFoto":"'.$prod->GetPathFoto().'"}').")' value='Eliminar' />
							<input type='button' class='MiBotonUTN' onclick='Main.ModificarProducto(".json_encode('{"codBarra":"'.$prod->GetCodBarra().'", "nombre":"'.$prod->GetNombre().'", "pathFoto":"'.$prod->GetPathFoto().'"}').")' value='Modificar' /></td>
						</tr>";						
		}
		
		$grilla .= '</table>';		
		
		echo $grilla;
		
		break;
		
	case "agregar":
	case "modificar":

		$res = Archivo::Subir();
		$ret = new stdClass();
		$ret->exito = false;

		if(!$res["Exito"]){
			$ret->mensaje = $res["Mensaje"];
			echo json_encode($ret);
			break;
		}

		$codBarra = isset($_POST['codBarra']) ? $_POST['codBarra'] : NULL;
		$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : NULL;
		$archivo = $res["PathTemporal"];

		$p = new Producto($codBarra, $nombre, $archivo);
		
		if($queHago === "agregar"){
			if(!Producto::Guardar($p)){
				$ret->mensaje = "Error al generar archivo";
			}
			else{
				$ret->exito = true;
				$ret->mensaje = "producto guardado con exito";
			}
		}

		if($queHago === "modificar"){
			if(!Producto::Modificar($p)){
				$ret->mensaje = "Lamentablemente ocurrio un error y no se pudo escribir en el archivo.";
			}
			else{
				$ret->exito = true;
				$ret->mensaje = "producto modificado con exito";
			}
		}

		echo json_encode($ret);
		
		break;
	
	case "eliminar":
		$codBarra = isset($_POST['codBarra']) ? $_POST['codBarra'] : NULL;

		$ret = new stdClass();
		$ret->exito = false;
		$ret->mensaje = "Lamentablemente ocurrio un error y no se pudo escribir en el archivo.";
	
		if(!Producto::Eliminar($codBarra)){
		}
		else{
			$ret->mensaje = "El archivo fue escrito correctamente. PRODUCTO eliminado CORRECTAMENTE!!!";
			$ret->exito = true;
		}
	
		echo json_encode($ret);
		
		break;
		
	default:
		echo ":(";
}
?>