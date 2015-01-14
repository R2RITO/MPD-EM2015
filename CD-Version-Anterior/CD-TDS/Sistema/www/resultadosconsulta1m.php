<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra los resultados del primer tipo de consulta de pacientes
	en la interfaz movil.
<!-->
<html>
<head>
<meta name="viewport" content="width=device-width, content="text/html; charset=UTF-8", minimum-scale=1, maximum-scale=1">
<?php

session_start();
include_once ("FachadaBD.php");
include_once("Paciente.php");

/*	Funcion que se encarga de realizar la busqueda en la base de datos a partir de
	la cedula del paciente e imprime los resultados en pantalla.
*/
function realizarBusqueda(){

	$cedula = $_GET['cedula'];

	$fbd = FachadaBD::getInstance();
	$resultado = $fbd->consultarPacienteBD($cedula);
	$paciente = new Paciente();

    if (($row = oci_fetch_array($resultado, OCI_BOTH))){
        $paciente->setCI($row[0]);
        $paciente->setNombres($row[1]);
        $paciente->setApellidos($row[2]);
        $paciente->setProfesion($row[3]);
        $paciente->setLugarRes($row[4]);
        $paciente->setFechaNac($row[5]);
        $paciente->setID_Historial($row[6]);
        $paciente->setDiagnostico($row[7]);
        $paciente->setInterQuir($row[8]);
    }

	return $paciente;	
}

/*	Funcion que muestra los dispositivos que utiliza el paciente y
	el grado en que los usa.
*/
function muestraDisp(){

	$cedula = $_GET['cedula'];

	$fbd = FachadaBD::getInstance();
	$resultado = $fbd->consultarDispositivosBD($cedula);
	
	while (($row = oci_fetch_array($resultado, OCI_BOTH))) {
		echo "&nbsp;&nbsp;&nbsp;&nbsp;".$row[0]. " en un grado de ".$row[1]."<br>";
	}
}

?>




<title>Laboratorio Marcha</title>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
</head>
 
<body> 
<div data-role="page"  data-theme="b"  style="background-image:url(themes/images/img01.png)">
   <div data-role="header" data-theme="d" data-position="fixed">
   <a href="indexm.php" data-role="button" data-icon="home" data-iconpos="notext">home</a>
      <h1>CONSULTA</h1>
   <a href="logoutm.php" data-role="button" data-icon="info" data-iconpos="notext">cerrar sesión</a>
   </div><!-- /header -->
   <br/>
   <div data-role="content">
   
		<div data-role="partes" style="background-image:url(themes/images/fb1.png); background-repeat: no-repeat; background-position: 50% 50%;">
		<br/>
		<p align="center">
			  <font face="Arial" size="3" color="#515756">
				<strong>Datos Personales del Paciente</strong> 
				<br><br>
			   </font>
				 <?php $paciente = realizarBusqueda();?>
				
					<strong>Nombres:</strong> <?php echo $paciente->getNombres();?><br>
					<strong>Apellidos:</strong> <?php echo $paciente->getApellidos();?><br>
					<strong>Identificación:</strong> <?php echo $paciente->getCI();?><br>
					<strong>Profesión:</strong> <?php echo $paciente->getProfesion();?><br>
					<strong>Lugar de Residencia:</strong> <?php echo $paciente->getLugarRes();?><br>
					<strong>Fecha de Nacimiento:</strong> <?php echo $paciente->getFechaNac();?><br>
					
				<br><br><br>	
				<font face="Arial" size="3" color="#515756">
				<strong>Datos del Historial del Paciente</strong> 
				<br><br>
			   </font>
			   
				   <strong>ID del Historial del paciente:</strong> <?php echo $paciente->getID_Historial();?><br>
				   <strong>Intervenciones Quirúrgicas:</strong> <?php echo $paciente->getInterQuir();?><br><br>
				   <strong>Diagnóstico que presentó inicialmente el paciente:</strong><br> <?php echo $paciente->getDiagnostico();?><br><br>
				   
				   <strong>Dispositivos que utiliza el paciente:</strong><br><?php muestraDisp();?><br>
				
		</p>
		
		   
		</div>
		
		
		
		</br>
		
		
		
		
				
   </div><!-- /content -->
   
   <div data-role="footer" data-id="foo1" data-position="fixed" data-theme="b">
	<div data-role="navbar">
		<ul>
			
			<li><a href="consultarm.php" data-icon="back">REGRESAR</a></li>
		</ul>
	</div><!-- /navbar -->
</div><!-- /footer -->
   <!-- /header -->
   </div><!-- /page -->
</body>
</html>