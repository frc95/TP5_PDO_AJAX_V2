<?php

require "persona.php";
require "empleado.php";
require "fabrica.php";

$apellido = htmlspecialchars($_POST["apellido"]);
$dni = htmlspecialchars($_POST["dni"]);

//MANEJO DE ARCHIVOS CON EXPLODE

/*if(file_exists("archivos/empleados.txt"))
{
    
    $archivo = fopen("archivos/empleados.txt", "r");
    while(!feof($archivo))
    {
	    $datos=explode("-",fgets($archivo));
            
	    if($datos[0]!=null)
	    {
            if($datos[0]==$dni && $datos[2]==$apellido)
            {
                session_start();
                $_SESSION["DNIEmpleado"]=$dni;
                header("Location: mostrar.php");
            }
            
                    

	    }
    }
    fclose($archivo);
}*/

//MANEJO CON PDO
$fabrica= new Fabrica("Grupo UTN");
$fabrica->TraerDeBaseDeDatos();
$empleados=$fabrica->GetEmpleados();

foreach($empleados as $empleado)
{
    if($empleado->GetDni()==$dni && $empleado->GetApellido()==$apellido)
    {
        session_start();
        $_SESSION["DNIEmpleado"]=$dni;
        header("Location: index.php");
    }

}
    
echo "Error no se encontro el empleado <br>";
echo "Haga click "."<a href='../login.html'>aqui</a>"." para volver al login";
    
    
    
