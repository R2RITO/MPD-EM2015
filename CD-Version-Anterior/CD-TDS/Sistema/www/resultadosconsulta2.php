<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra los resultados del segundo tipo de consulta de pacientes.
<!-->

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


	echo "<h2>Resultados</h2>";
	echo '<table border="1">';
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

<html>
<head>
<title>Laboratorio</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<noscript>
<link rel="stylesheet" href="css/5grid/core.css" />
<link rel="stylesheet" href="css/5grid/core-desktop.css" />
<link rel="stylesheet" href="css/5grid/core-1200px.css" />
<link rel="stylesheet" href="css/5grid/core-noscript.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/style-desktop.css" />
</noscript>
<script src="css/5grid/jquery.js"></script>
<script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none"></script>
<!--[if IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
</head><body>
<div id="header-wrapper">
	<header id="header" class="5grid-layout">
		<div id="row">
			<div id="12u">
				<div id="logo">
					<h1><a href="#" class="mobileUI-site-name">registro de pacientes</a></h1>
					<p>Hospital J.M. de los Ríos</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="12u">
				<div class="5grid-layout" id="menu">
					<nav class="mobileUI-site-nav">
						<ul>
							<?php 
							if ($_SESSION['esfisio'] == 1){
								?>
							<li><a href="index.php">Home</a></li>
							<li><a href="nuevopaciente.php"> Nuevo Paciente</a></li>
							<li><a href="nuevoEFA.php">Nuevo EFA</a></li>
							<li class="current_page_item"><a href="consultarpaciente.php"> Consultar Paciente</a></li>
							<li><a href="eliminarpaciente.php">Eliminar Paciente</a></li>
								<?php
							}else{ 
								?>
							<li><a href="index.php">Home</a></li>
							<li class="current_page_item"><a href="consultarpaciente.php"> Consultar Paciente</a></li>
								<?php
							}
							?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>
</div>

</br>
<div id="wrapper">
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="12u">
				<section class="content">
					
					<?php
					realizarBusqueda();

					?>
					
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="footer1">
		<div class="row">
			<div class="12u">
				<section id="fbox1">
					<p style="text-align:right;"><a href="consultarpaciente.php" class="button-style1">Regresar</a></p>
				</section>
			</div>
		</div>
	</div>
</div>


<div class="5grid-layout" id="copyright">
	<div class="row">
		<div class="12u">
			<section align="right" style="margin-right: 62px;">
				<p>&copy; Laboratorio de Marcha | Hospital J.M de los Ríos   &nbsp; </p><a href="logout.php" class="button-style1" >Cerrar sesión</a></p>
			</section>
		</div>
	</div>
</div>
</body>
</html>