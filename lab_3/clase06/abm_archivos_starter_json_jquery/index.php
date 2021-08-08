<?php
require_once("clases\producto.php");
$tituloVentana = "PRODUCTOS - con archivos y AJAX - JSON - JQUERY";
?>
<!doctype html>
<html>
<head>
	<title> <?php echo $tituloVentana; ?> </title>
	  
	<link href="./img/utnLogo.png" rel="icon" type="image/png" />

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="animacion.css">		
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<!-- Agrego Jquery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
	<script type="text/javascript" src="./JavaScript/ajax.js"></script>
	<script type="text/javascript" src="./JavaScript/app.js"></script>
		
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1>PRODUCTOS</h1>      
		</div>
		<div class="CajaInicio animated bounceInRight" style="width:1100px">
			<h1>Ejemplo ABM-LISTADO - con archivos y AJAX - JSON - JQUERY</h1>
			<table>
				<tbody>
					<tr>
						<td width="50%">
							<div id="divFrm" style="height:600px;overflow:auto;margin-top:100px">
								<form id="frm" enctype="multipart/form-data" >
									<input type="text" name="codBarra" id="codBarra" placeholder="Ingrese c&oacute;digo de barras" />
									<input type="text" name="nombre" id="nombre" placeholder="Ingrese nombre" />
									<input type="file" name="archivo" id="archivo"  /> 
									<img src="default-avatar.png" height="100" width="100" id="img" />
									
									<input type="button" id="guardar" class="MiBotonUTN" value="Guardar"  />
									<input type="reset" id="reset" class="MiBotonUTN" value="Cancelar"  />
									<input type="hidden" id="hdnQueHago" name="queHago" value="agregar" />
								</form>
							</div>
						</td>
						<td rowspan="2">
							<div id="divGrilla" style="height:610px;overflow:auto;border-style:solid">
							
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>