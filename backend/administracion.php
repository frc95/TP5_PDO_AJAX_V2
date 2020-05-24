<?php
require "persona.php";
require "empleado.php";
require "fabrica.php";


$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
$apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : null;
$dni = isset($_POST["dni"]) ? $_POST["dni"] : null;
$sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : null;
$legajo = isset($_POST["legajo"]) ? $_POST["legajo"] : null;
$sueldo = isset($_POST["sueldo"]) ? $_POST["sueldo"] : null;
$turno = isset($_POST["rdoTurno"]) ? $_POST["rdoTurno"] : null;


$destino = "fotos/" . $_FILES["archivo"]["name"];
$tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);

$validarDniLegajo=false;
$empleadoEncontrado="";


$hidden = isset($_POST["hdnModificar"]) ? $_POST["hdnModificar"] : null;

$fabrica= new Fabrica("Grupo UTN");
//$fabrica->TraerDeArchivo("archivos/empleados.txt"); <- Codigo para la parte 5 SIN AJAX
$fabrica->TraerDeBaseDeDatos();


if($hidden)
{
    $empleados=$fabrica->GetEmpleados();
    foreach($empleados as $empleado)
    {
        if($empleado->GetDni() == $dni)
        {
            $fabrica->EliminarEmpleado($empleado);
            break;
        }
    }
}


//Validar Legajo y dni
$empleados=$fabrica->GetEmpleados();
foreach($empleados as $empleado)
{
    if($empleado->GetDni() == $dni || $empleado->GetLegajo() == $legajo)
    {
        $validarDniLegajo=true;
        $empleadoEncontrado=$empleado->ToString();
        break;
    }
}

if(!$validarDniLegajo)
{

    if($tipoArchivo == "jpeg" || $tipoArchivo == "jpg" || $tipoArchivo == "bmp" || $tipoArchivo == "gif" || $tipoArchivo == "png")
    {
        //echo "Cumple con la extension <br>";
        if ($_FILES["archivo"]["size"] <= 1000000 )
        {   
            //echo "El tamaño del archivo es correcto <br>";

            if (file_exists($destino)) 
            {
                //echo "El archivo ya existe <br>";
                
            }
            else
            {

                $empleado = new Empleado($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno);
                $empleado->SetPathFoto("fotos/".$dni."-".$apellido.".".$tipoArchivo);

                

                if($fabrica->AgregarEmpleado($empleado))
                {
                    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino))
                    {
                        rename($destino,"fotos/".$dni."-".$apellido.".".$tipoArchivo);
                        //echo "El archivo ha sido subido exitosamente.<br>";
                    } 
                    else 
                    {
                        echo "Lamentablemente ocurrio un error y no se pudo subir el archivo.<br>";
                    }

                    //$fabrica->GuardarEnArchivo("archivos/empleados.txt"); <-Codigo para la parte 5 SIN AJAX
                    if($hidden)
                    {
                        $fabrica->ModificarEnBaseDeDatos($dni, $empleado);
                        echo "MODIFICACION EXITOSA";
                    }
                    else
                    {
                        $fabrica->GuardarEnBaseDeDatos($empleado);
                        echo "ALTA EXITOSA";
                    }
                    //echo "Haga click "."<a href='mostrar.php'>aqui</a>"." para ver el contenido del archivo";
                }
                else
                {
                    echo "La fabrica esta llena";
                    //echo "Haga click "."<a href='index.php'>aqui</a>"." para volver al formulario";
                }
                
            }
        }
        else
        {
            echo "El archivo es demasiado grande";
            //echo "Haga click "."<a href='index.php'>aqui</a>"." para volver al formulario";
        }
    }
    else
    {
        echo "No se acepta esa extension";
        //echo "Haga click "."<a href='index.php'>aqui</a>"." para volver al formulario";
    }
}
else
{
    echo "Existe un empleado con ese legajo o DNI \n";
    echo $empleadoEncontrado;
    //echo "<br> Haga click "."<a href='index.php'>aqui</a>"." para volver al formulario";
}  









