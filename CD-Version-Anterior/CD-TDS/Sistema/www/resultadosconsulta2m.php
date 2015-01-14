<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra los resultados del segundo tipo de consulta de pacientes
	en la interfaz movil.
<!-->
<html>
<head>
<meta name="viewport" content="width=device-width, content="text/html; charset=UTF-8", minimum-scale=1, maximum-scale=1">


<?php

session_start();
include_once ("FachadaBD.php");

/*	Funcion de verificacion de la seleccion de la busqueda en cuanto al peso.
*/
function parametro1(){
	if (isset($_POST['parametro1']) && ($_POST['parametro1'] == "Y")) {
		if (isset($_POST['peso'])) {
			return $_POST['peso'];
		} else {
		return 'a';
		}
	} else {
		return 'a';
	}
}

/*	Funcion de verificacion de la seleccion de la busqueda en cuanto al
	tono flexor dorsal izquierdo.
*/
function parametro2(){
	if (isset($_POST['parametro2']) && ($_POST['parametro2'] == "Y")) {
		if ($_POST['tonoflexdorizq'] <> '') {
			return $_POST['tonoflexdorizq'];
		} else if ($_POST['dominioTFDI'] <> '') {
			return $_POST['dominioTFDI'];
		} else {
		return 'a';
		}
	} else {
		return 'a';
	}
}

/*	Funcion de verificacion de la seleccion de la busqueda en cuanto al
	tono flexor dorsal derecho.
*/
function parametro3(){
	if (isset($_POST['parametro3']) && ($_POST['parametro3'] == "Y")) {
		if (isset($_POST['tonoflexdorder']) && $_POST['tonoflexdorder'] <> '') {
			return $_POST['tonoflexdorder'];
		} else if (isset($_POST['dominioTFDD']) && $_POST['dominioTFDI'] <> '') {
			return $_POST['dominioTFDD'];
		}else {
		return 'a';
		}
	} else {
		return 'a';
	}
}

/*	Funcion de verificacion de la seleccion de la busqueda en cuanto a las 
	caracteristicas de marcha.
*/
function parametro4(){
	if (isset($_POST['parametro4']) && ($_POST['parametro4'] == "Y")) {
		if (isset($_POST['caracmarcha'])  && $_POST['caracmarcha'] <> '') {
			return $_POST['caracmarcha'];
		} else {
		return 'a';
		}

	} else {
		return 'a';
	}
}

/*	Funcion que realiza la busqueda en la base de datos dependiendo de las
	selecciones del usuario y hace la tabla que muestra los resultados obtenidos.
*/
function realizarBusqueda(){

	$etiquetaP = parametro1();
	$etiquetaTFDI = parametro2();
	$etiquetaTFDD = parametro3();
	$etiquetaCM = parametro4();

	$fbd = FachadaBD::getInstance();
	$results = $fbd->compararAtributosBD($etiquetaP, $etiquetaTFDI, $etiquetaTFDD, $etiquetaCM, 1, 10);


	
	echo '<table border="1" align="center">';
	echo "<tr>";
	echo "<th>Nombres</th>";
	echo "<th>Apellidos</th>";
	echo "<th>Cedula</th>";
	echo "<th>Id Historial</th>";
	echo "<th>Fecha Examen</th>";
	$j = 4;

	if (parametro1() <> 'a'){
		echo "<th>Peso</th>";
		$j = $j + 1;
	}
		
	if (parametro2() <> 'a') {
		echo "<th>Tono Flexor \n Dorsal Izq</th>";
		$j = $j + 1;
	}


	if (parametro3() <> 'a') {
		echo "<th>Tono Flexor \n Dorsal Der</th>";
		$j = $j + 1;
	}


	if (parametro4() <> 'a') {
		echo "<th>Caracteristicas \n de Marcha</th>";
		$j = $j + 1;
	}

	echo "</tr>";
	
	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo "<tr>";

		for ($i=0; $i <= $j; $i++) {
			echo "<td>".$row[$i]."</td>";
		}

		echo "</tr>";
	}
		echo "</table>";
	
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
				<strong>Se ha obtenido como resultado:</strong> 
				<br><br>
			    </font>
				
				
			  
				<?php
					realizarBusqueda();

					?>
				
				<br><br>
				
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