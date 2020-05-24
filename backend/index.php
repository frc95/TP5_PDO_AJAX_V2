<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <?php
    $dni = isset($_POST["hiddenDni"]) ? $_POST["hiddenDni"] : NULL;
    if(isset($dni))
    {
        echo "<title>Formulario Modificar Empleado</title>";
    }
    else
    {
        echo "<title>Formulario Alta Empleado</title>";
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../javascript/funciones.js"></script>
    <script>MostrarAjax()</script>
</head>
<body>
    

    <?php require "validarSesion.php" ?>

    <?php

    require "persona.php";
    require "empleado.php";
    require "fabrica.php";

    $apellido=NULL;
    $nombre=NULL;
    $sexo=NULL;
    $legajo=NULL;
    $sueldo=NULL;
    $turno=NULL;
    

    $sexoM=NULL;
    $sexoF=NULL;

    $checkedT=NULL;
    $checkedN=NULL;

    $readOnly=NULL;

    $validarHidden=false;

    $btn="Enviar";

    $dni = isset($_POST["hiddenDni"]) ? $_POST["hiddenDni"] : NULL;
    if(isset($dni))
    {
        $validar=false;
        $fabrica= new Fabrica("Grupo UTN");
        //$fabrica->TraerDeArchivo("archivos/empleados.txt");
        $fabrica->TraerDeBaseDeDatos();
        $empleados=$fabrica->GetEmpleados();
        foreach($empleados as $empleado)
        {
            if($empleado->GetDni() == $dni)
            {
                $apellido=$empleado->GetApellido();
                $nombre=$empleado->GetNombre();
                $sexo=$empleado->GetSexo();
                $legajo=$empleado->GetLegajo();
                $sueldo=$empleado->GetSueldo();
                $turno=$empleado->GetTurno();
                



                $validar=true;
                break;
            }
        }
        if($validar==true)
        {
            echo "<h2>Modificar Empleado</h2>";
            $readOnly="readonly";
            $btn="Modificar";
            $validarHidden=true;
            
        }
        if($sexo=="M")
        {
            $sexoM="selected";
        }
        else if($sexo=="F")
        {
            $sexoF="selected";
        }
        if($turno=="T")
        {
            $checkedT="checked";
        }
        else if($turno=="N")
        {
            $checkedN="checked";
        }
        
    }
    else
    {
        //echo "<h2>Alta de Empleados</h2>";
        echo "<div id='divTitulo'><h2>Alta de Empleados</h2></div>";
        
    }
    

    echo '
    
    <form action="administracion.php" method="POST" enctype="multipart/form-data">
    

        
        <table align="" border="0">
            <tr>
                <td><h4>Datos Personales</h4></td>
                
            </tr>
            
            <tr>
                <td colspan="2"><hr></td>
            </tr>
    
           
                
            <tr>
                    
                <td><label for="txtDni">DNI:</label></td>
                <td><input type="number" id="txtDni" min="1000000" max="55000000" name="dni" value='.$dni.' required  '.$readOnly.'> <span style="display: none;" id="spanDni">*</span></td>
            </tr>
            <tr>
                <td><label for="txtApellido">Apellido:</label></td>
                <td><input type="text" id="txtApellido" name="apellido" required value='.$apellido.' > <span style="display: none;" id="spanApellido">*</span></td>
            </tr>
            <tr>
                <td><label for="txtNombre">Nombre:</label></td>
                <td><input type="text" id="txtNombre" name="nombre" required value='.$nombre.' > <span style="display: none;" id="spanNombre">*</span></td>
            </tr>
            <tr>
                <td><label for="cboSexo">Sexo:</label></td>
                <td><select name="sexo" id="cboSexo" required>
                    <option value="" selected>Seleccione</option>
                    <option value="M" '.$sexoM.' >Masculino</option>
                    <option value="F" '.$sexoF.' >Femenino</option>
                    </select>
                    <span style="display: none;" id="spanSexo">*</span>
                </td>
            </tr>
                
    
            
    
            <tr>
                <td><h4>Datos Laborales</h4></td>
            </tr>
    
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            
           
            <tr>
                <td><label for="txtLegajo">Legajo:</label></td>
                <td><input type="number" id="txtLegajo" min="100" max="550" name="legajo" required value='.$legajo.' '.$readOnly.' > <span style="display: none;" id="spanLegajo">*</span></td>
            </tr>
            <tr>
                <td><label for="txtSueldo">Sueldo:</label></td>
                <td><input type="number" id="txtSueldo" min="8000" step="500" max="" name="sueldo" required value='.$sueldo.' > <span style="display: none;" id="spanSueldo">*</span></td>
            </tr>
    
            <tr>
                <td><label for="">Turno:</label></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="radio" name="rdoTurno" value="M" id="rdoMañana" checked>
                    <label for="rdoMañana">Mañana</label>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="radio" name="rdoTurno" value="T" id="rdoTarde" '.$checkedT.'>
                    <label for="rdoTarde">Tarde</label>
                </td>
            </tr>
            <tr>
                <td></td>

                <td>
                    <input type="radio" name="rdoTurno" value="N" id="rdoNoche"  '.$checkedN.'>
                    <label for="rdoNoche">Noche</label>
                </td>
            </tr>
           
            <tr>
                <td>
                    <label for="archivo">Foto:</label>
                </td>
                <td>
                    <input type="file" name="archivo" id="imageFoto" required accept="image/*"  ><span style="display: none;" id="spanFoto">*</span>
                </td>
            </tr>
    
            <tr>
                <td colspan="2"><hr></td>
            </tr>
    
            
            <tr>
                <td colspan="2" align="right"><input type="reset" value="Limpiar" id="btnLimpiar"></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><input type="button" value='.$btn.' id="btnEnviar" onclick="AdministrarValidaciones()"></td>
            </tr>
  
        </table>

        <input type="hidden" name="hdnModificar" value='.$validarHidden.'> 
   
    
    </form>';?>

    <?php // echo "<a href='cerrarSesion.php'>Desloguearse</a>" ?>

    <form action="mostrarPDF.php" method="POST">
        <input type="submit" value="Mostrar empleados PDF">
    </form>
    

    <div id="divMostrar"></div>

  
</body>
</html>