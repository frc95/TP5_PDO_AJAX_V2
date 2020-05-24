<?php

class Empleado extends Persona
{
    protected $_legajo;
    protected $_pathFoto;
    protected $_sueldo;
    protected $_turno;

    public function __construct($nombre,$apellido,$dni,$sexo,$legajo,$sueldo,$turno)
    {
        parent::__construct($nombre,$apellido,$dni,$sexo);
        $this->_legajo=$legajo;
        $this->_sueldo=$sueldo;
        $this->_turno=$turno;
    }

    public function GetLegajo()
    {
        return $this->_legajo;
    }
    public function GetPathFoto()
    {
        return $this->_pathFoto;
    }
    public function GetSueldo()
    {
        return $this->_sueldo;
    }
    public function GetTurno()
    {
        return $this->_turno;
    }

    public function Hablar($idioma)
    {
        $totalDeIdiomas="";
        $count=0;
        foreach($idioma as $item)
        {
            
            $totalDeIdiomas=$totalDeIdiomas.$item.", ";
        }

        $cantidad=strlen($totalDeIdiomas);
        $totalDeIdiomas[$cantidad-2]=" ";
        
        return "El empleado habla ".$totalDeIdiomas;
    }

    public function SetPathFoto($foto)
    {
        $this->_pathFoto=$foto;
    }

    public function ToString()
    {
        
        return parent::ToString()."-".$this->_legajo."-".$this->_sueldo."-".$this->_turno."-".$this->_pathFoto;
    }

}