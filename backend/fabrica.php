<?php

require "interfaces.php";


class Fabrica implements IArchivo
{
    private $_cantidadMaxima;
    private $_empleados;
    private $_razonSocial;

    public function __construct($razonSocial)
    {
        $this->_razonSocial=$razonSocial;
        $this->_cantidadMaxima=7;
        $this->_empleados=array();
    }

    public function AgregarEmpleado($emp)
    {
        $validar=false;
        
        if( count($this->_empleados) < $this->_cantidadMaxima)
        {
            array_push($this->_empleados,$emp);

            $this->EliminarEmpleadoRepetido();
        
            $validar=true;
        }
        
        
        return $validar;
    }

    public function CalcularSueldos()
    {
        $total=0;
        foreach($this->_empleados as $empleado)
        {
            $total=$total+$empleado->GetSueldo();
        }
        return $total;
    }

    public function EliminarEmpleado($emp)
    {
        $validar=false;
        $contador=0;
        foreach($this->_empleados as $empleado)
        {
            
            
            if($empleado->GetLegajo() == $emp->GetLegajo())
            {
                $ruta=trim($emp->GetPathFoto());
                unlink($ruta);
                unset($this->_empleados[$contador]);
                
                $validar=true;
                break;
            }
            $contador++;
        }
        return $validar;
    }

    private function EliminarEmpleadoRepetido()
    {
        
        $this->_empleados=array_unique($this->_empleados,SORT_REGULAR);
    }

    public function GetEmpleados()
    {
        return $this->_empleados;
    }
    
    public function ToString()
    {
        $salida=$this->_razonSocial."-".$this->_cantidadMaxima."<br>";
        foreach($this->_empleados as $empleado)
        {
            $salida=$salida."-".$empleado->ToString()."<br>";
        }
        return $salida;
    }

    //MANEJO DE ARCHIVOS

    function GuardarEnArchivo($nombreArchivo)
    {
        $archivo = fopen($nombreArchivo, "w+");    
        foreach($this->_empleados as $empleado)
        {
            
            if($empleado!=null)
            {
                $empleadoSinEspacio=trim($empleado->ToString());
                $cant = fwrite($archivo,$empleadoSinEspacio."\r\n");
                if($cant <= 0)
                {
	                echo "<h2>Error en la escritura </h2><br/>";
                }
                
            }  
        }  
        fclose($archivo);
    }

    function TraerDeArchivo($nombreArchivo)
    {
        if(file_exists($nombreArchivo))
        {
            $archivo = fopen($nombreArchivo, "r");
            while(!feof($archivo))
            {
	            $datos=explode("-",fgets($archivo));
            
	            if($datos[0]!=null)
	            {
                    
                    $empleado = new Empleado($datos[1],$datos[2],$datos[0],$datos[3],$datos[4],$datos[5],$datos[6]);
                    $empleado->SetPathFoto($datos[7]."-".$datos[8]);
                    
		            $this->AgregarEmpleado($empleado);
	            }
            }
            fclose($archivo);   
        }
    
    }

    //MANEJO CON PDO

    function TraerDeBaseDeDatos()
    {
        try {

            $usuario='uidbrpkd3olvfjg9';
            $clave='vClNDYRB6pkwrrjjKUZo';
            $host="bqgqjbpaxuokugb6yuxq-mysql.services.clever-cloud.com";
            $dbname="bqgqjbpaxuokugb6yuxq";
        
            $objetoPDO = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $usuario, $clave);
            $sql = $objetoPDO->query('SELECT id AS _id, dni AS _dni, nombre AS _nombre, apellido AS _apellido, sexo AS _sexo, legajo AS _legajo, sueldo AS _sueldo, turno AS _turno, foto AS _foto FROM empleados');
            
        
            
            $resultado = $sql->fetchall();
            
            foreach ($resultado as $fila)
            {
                $empleado = new Empleado($fila[2],$fila[3],$fila[1],$fila[4],$fila[5],$fila[6],$fila[7]);
                $empleado->SetPathFoto($fila[8]);
                $this->AgregarEmpleado($empleado);   
                
            }
            
        } catch (PDOException $e) {
        
            
            echo "Error!!!\n" . $e->getMessage();
        }
    }

    function GuardarEnBaseDeDatos($empleado)
    {
        try{
            $usuario='uidbrpkd3olvfjg9';
            $clave='vClNDYRB6pkwrrjjKUZo';
            $host="bqgqjbpaxuokugb6yuxq-mysql.services.clever-cloud.com";
            $dbname="bqgqjbpaxuokugb6yuxq";

            $objetoAlta = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $usuario, $clave);
            $sql = $objetoAlta->prepare("INSERT INTO empleados ( dni, nombre, apellido, sexo, legajo, sueldo, turno, foto)"
            . "VALUES(  :dni, :nombre, :apellido, :sexo, :legajo, :sueldo, :turno, :foto)");


            
            
            $sql->bindValue(':dni', $empleado->GetDni(), PDO::PARAM_INT);
            $sql->bindValue(':nombre', $empleado->GetNombre(), PDO::PARAM_STR);
            $sql->bindValue(':apellido', $empleado->GetApellido(), PDO::PARAM_STR);
            $sql->bindValue(':sexo', $empleado->GetSexo(), PDO::PARAM_STR);
            $sql->bindValue(':legajo', $empleado->GetLegajo(), PDO::PARAM_INT);
            $sql->bindValue(':sueldo', $empleado->GetSueldo(), PDO::PARAM_STR);
            $sql->bindValue(':turno', $empleado->GetTurno(), PDO::PARAM_STR);
            $sql->bindValue(':foto', $empleado->GetPathFoto(), PDO::PARAM_STR);
        
            $sql->execute();
        }
        
        catch (PDOException $e) {
        
            
            echo "Error!!!\n" . $e->getMessage();
        }
    }

    function EliminarEnBaseDeDatos($legajo)
    {
        try{
            $usuario='uidbrpkd3olvfjg9';
            $clave='vClNDYRB6pkwrrjjKUZo';
            $host="bqgqjbpaxuokugb6yuxq-mysql.services.clever-cloud.com";
            $dbname="bqgqjbpaxuokugb6yuxq";

            $objeto = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $usuario, $clave);
            $sql = $objeto->prepare("DELETE FROM empleados WHERE legajo = :legajo");
        
            $sql->bindValue(':legajo', $legajo, PDO::PARAM_INT);
            
        
            $sql->execute();
        }
        
        catch (PDOException $e) {
        
            
            echo "Error!!!\n" . $e->getMessage();
        }
    }

    function ModificarEnBaseDeDatos($dni, $empleado)
    {
        try{
            $usuario='uidbrpkd3olvfjg9';
            $clave='vClNDYRB6pkwrrjjKUZo';
            $host="bqgqjbpaxuokugb6yuxq-mysql.services.clever-cloud.com";
            $dbname="bqgqjbpaxuokugb6yuxq";

            $objeto = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $usuario, $clave);
            $sql = $objeto->prepare("UPDATE empleados SET nombre = :nombre, apellido = :apellido, 
                        sexo = :sexo, sueldo = :sueldo, turno = :turno, foto = :foto WHERE dni = :dni");
        
            $sql->bindValue(':dni', $dni, PDO::PARAM_INT);
            $sql->bindValue(':nombre', $empleado->GetNombre() , PDO::PARAM_STR);
            $sql->bindValue(':apellido', $empleado->GetApellido(), PDO::PARAM_STR);
            $sql->bindValue(':sexo', $empleado->GetSexo(), PDO::PARAM_STR);
            $sql->bindValue(':sueldo', $empleado->GetSueldo(), PDO::PARAM_STR);
            $sql->bindValue(':turno', $empleado->GetTurno(), PDO::PARAM_STR);
            $sql->bindValue(':foto', $empleado->GetPathFoto(), PDO::PARAM_STR);
            
        
            $sql->execute();
        }
        
        catch (PDOException $e) {
        
            
            echo "Error!!!\n" . $e->getMessage();
        }
    }
}