<?php
require_once __DIR__ . '/vendor/autoload.php';
require "persona.php";
require "empleado.php";
require "fabrica.php";

header('content-type:application/pdf');

session_start();

$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 
                        'pagenumPrefix' => 'Página nro. ',
                        'pagenumSuffix' => ' - ',
                        'nbpgPrefix' => ' de ',
                        'nbpgSuffix' => ' páginas']);

$mpdf->SetProtection(array(), $_SESSION["DNIEmpleado"], $_SESSION["DNIEmpleado"]);

$mpdf->SetHeader('Amarilla Godoy Franco Nahuel||{PAGENO}{nbpg}');
$mpdf->setFooter('https://tp5-pdo-franco-v2.herokuapp.com/||{PAGENO}');

$datos="";
$fabrica= new Fabrica("Grupo UTN");
$fabrica->TraerDeBaseDeDatos();
$empleados=$fabrica->GetEmpleados();
foreach($empleados as $empleado)
{
    $path=$empleado->GetPathFoto();

    $datos= $datos."<tr>".
                        "<td>". $empleado->ToString() ."</td>".
                        "<td>".
                            "<img src='$path' height='90px' width='90px'>".
                        "</td>".
                    "</tr>";	
}

$tabla='<table align="">
            <tr>
                <td><h4>Info</h4></td>
            </tr>
            <tr>
                <td colspan="4"><hr></td>
            </tr>'.
            $datos.
            '<tr>
			    <td colspan="4"><hr></td>
		    </tr>
	    </table>';

$mpdf->WriteHTML('<h2>Listado de Empleados</h2>');

$mpdf->WriteHTML($tabla);

$mpdf->Output('mi_pdf.pdf', 'I');
?>
