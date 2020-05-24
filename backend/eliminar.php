<?php

require "persona.php";
require "empleado.php";
require "fabrica.php";

$legajo = htmlspecialchars($_GET["legajo"]);


//MANEJO DE ARCHIVOS CON EXPLODE

/*$archivo = fopen("archivos/empleados.txt", "r");
while(!feof($archivo))
{
    $datos=explode("-",fgets($archivo));
      
	if($datos[0]!=null && $datos[4]==$legajo)
	{
          
        $empleado = new Empleado($datos[1],$datos[2],$datos[0],$datos[3],$datos[4],$datos[5],$datos[6]);
        $empleado->SetPathFoto($datos[7]."-".$datos[8]);
        
        $fabrica= new Fabrica("Grupo UTN");
        $fabrica->TraerDeArchivo("archivos/empleados.txt");
        
        if($fabrica->EliminarEmpleado($empleado))
        {
            $fabrica->GuardarEnArchivo("archivos/empleados.txt");
            echo "El empleado fue eliminado con exito <br>";

        }
        else
        {
            echo "No se pudo eliminar al empleado <br>";
        }            
        break;
    }
}
fclose($archivo);*/

//MANEJO CON PDO

$fabrica= new Fabrica("Grupo UTN");
$fabrica->TraerDeBaseDeDatos();
$empleados=$fabrica->GetEmpleados();
foreach($empleados as $empleado)
{
    if($empleado->GetLegajo() == $legajo)
    {
        $fabrica->EliminarEmpleado($empleado);
        $fabrica->EliminarEnBaseDeDatos($legajo);
        echo "El empleado fue eliminado con exito";
        break;
    }
}


//echo "Haga click "."<a href='mostrar.php'>aqui</a>"." para ver el contenido del archivo <br>";

//echo "Haga click "."<a href='index.php'>aqui</a>"." para volver al formulario";

