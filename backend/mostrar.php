

<!DOCTYPE html>
<html lang="en">

<head>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Listado de Empleados</title>
	<script src="../javascript/funciones.js"></script>
</head>
<body>
	


	
	<h2>Listado de Empleados</h2>
	

	<table align="">
		
		<tr>
			<td><h4>Info</h4></td>
			
		</tr>
		<tr>
			<td colspan="4"><hr></td>
		</tr>

		<?php
		require "persona.php";
		require "empleado.php";
		require "fabrica.php";
		require "validarSesion.php";

		$fabrica= new Fabrica("Grupo UTN");
		//$fabrica->TraerDeArchivo("archivos/empleados.txt"); //Codigo para la PARTE 5 SIN AJAX
		$fabrica->TraerDeBaseDeDatos();
		$empleados=$fabrica->GetEmpleados();

		foreach($empleados as $empleado)
		{
			$path=$empleado->GetPathFoto();
			$legajo=$empleado->GetLegajo();
			$dni=$empleado->GetDni();

			//
			$nombre=$empleado->GetNombre();
			$apellido=$empleado->GetApellido();
			$sexo=$empleado->GetSexo();
			$sueldo=$empleado->GetSueldo();
			$turno=$empleado->GetTurno();

			echo "<tr>".
					"<td>". $empleado->ToString() ."</td>".
					"<td>".
						"<img src='$path' height='90px' width='90px'>".
					"</td>".
					"<td>".
						//"<a href='eliminar.php?legajo=$legajo'>Eliminar</a> " . //Codigo para la PARTE 5 SIN AJAX
						"<a href='#' onclick='return EliminarEmpleado($legajo)'>Eliminar</a> " .
					"</td>".
					"<td>".
						//"<input type='button' value='Modificar' id='btnModificar' " . "onclick='AdministrarModificar($dni)'>". //Codigo para la PARTE 5 SIN AJAX
						'<input type="button" value="Modificar" id="btnModificar" ' . 'onclick="AdministrarModificar(\''.$dni.'\',\''.$nombre.'\',\''.$apellido.'\',\''.$sexo.'\',\''.$legajo.'\',\''.$sueldo.'\',\''.$turno.'\')">'.
					"</td>".
				  "</tr>";	
		}

		?>

		<tr>
			<td colspan="4"><hr></td>
		</tr>
		
	</table>

	

 
	
	<?php // echo "<a href='index.php'>Alta de empleados</a>" ?>
	<br>
	<a href='cerrarSesion.php'>Desloguearse</a>

	<form action="index.php" method="POST" id="formModificar">
		<input type="hidden" id="hdDni" name="hiddenDni">
	</form>
	
	

</body>
</html>

