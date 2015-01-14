<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que valida los campos ingresados para el tercer tipo de consulta de un paciente.
<!-->

<?php

session_start();
include_once ("FachadaBD.php");

/*	Funcion que verifica si la cedula existe en la base de datos.
*/
function verificar_campo(){
	$fbd = FachadaBD::getInstance();
	$id = $_POST["cedula"];
	if(trim($id) == ""){
		echo "**debe introducir un valor para el campo";
	} else if(!preg_match("/^[[:digit:]]+$/", $id)){
		echo "El campo solo puede ser rellenado con numeros";
	} else if(!$fbd->validarPacienteBD($id)){
		echo "El paciente no existe en la base de datos";
	} else{
		$string = "Location: resultadosconsulta3.php?cedula=".$id;
		header($string);
	}
}

/*	Funcion que busca las etiquetas del peso almacenadas en 
	la base de datos para presentarlas al usuario para su
	seleccion para la busqueda.
*/
function buscarEtiquetasPeso(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPesoBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/*	Funcion que busca las etiquetas del tono flexor dorsal izq
	almacenadas en la base de datos para presentarlas al 
	usuario para su	seleccion para la busqueda.
*/
function buscarEtiquetasTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaTonoFlexDorIzqBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/*	Funcion que busca los dominios del tono flexor dorsal izq
	almacenados en la base de datos para presentarlos al 
	usuario para su	seleccion para la busqueda.
*/
function buscarDominioTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoTonoFlexDorIzqBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/*	Funcion que busca los dominios del tono flexor dorsal der
	almacenados en la base de datos para presentarlos al 
	usuario para su	seleccion para la busqueda.
*/
function buscarDominioTFDD(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoTonoFlexDorDerBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/*	Funcion que busca las etiquetas del tono flexor dorsal der
	almacenadas en la base de datos para presentarlas al 
	usuario para su	seleccion para la busqueda.
*/
function buscarEtiquetasTFDD(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaTonoFlexDorDerBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/*	Funcion que busca las etiquetas de las caracteristicas de marcha
	almacenadas en la base de datos para presentarlas al 
	usuario para su	seleccion para la busqueda.
*/
function buscarEtiquetasCaracMarcha(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaCaracMarchaBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
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
<div id="wrapper">
	<form action="validar_paciente.php" method="post">
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="12u">
				<section class="content">
					<h2>Consultar Paciente</h2>
					Ingrese cédula de identidad del paciente:<br>
					<input type="text" name="cedula">
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="footer1">
		<div class="row">
			<div class="12u">
				<section id="fbox1">
					<p style="text-align:right;"><input class="button-style1" type="submit" value="Ingresar"/></p>	
				</section>
			</div>
		</div>
	</div>
	</form>
</div>

</br>
<div id="wrapper">
	<form action="resultadosconsulta2.php" method="post">
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="12u">
				<section class="content">
					<h2>Consultas generales</h2>
					Seleccione las condiciones de la búsqueda:<br><br>
					<p>
						<INPUT TYPE="checkbox" NAME="parametro1" VALUE="Y">Peso
						<select name="peso">
							<option value="">Seleccione...</option>
							<?php buscarEtiquetasPeso();?>
							</select>
						<BR>
						<INPUT TYPE="checkbox" NAME="parametro2" VALUE="Y">Tono Flexor Dorsal Izquierdo
						<select name="tonoflexdorizq">
							<option value="">Seleccione...</option>
							<?php buscarEtiquetasTFDI();?>
							</select>
							O Dominio Fijo
						<select name="dominioTFDI">
							<option value="">Seleccione...</option>
							<?php buscarDominioTFDI();?>
							</select>
						<BR>
						<INPUT TYPE="checkbox" NAME="parametro3" VALUE="Y">Tono Flexor Dorsal Derecho
						<select name="tonoflexdorder">
							<option value="">Seleccione...</option>
							<?php buscarEtiquetasTFDD();?>
							</select>
							O Dominio Fijo
						<select name="dominioTFDD">
							<option value="">Seleccione...</option>
							<?php buscarDominioTFDD();?>
							</select>
						<BR>
						<INPUT TYPE="checkbox" NAME="parametro4" VALUE="Y">Características de Marcha
						<select name="caracmarcha">
							<option value="">Seleccione...</option>
							<?php buscarEtiquetasCaracMarcha();?>
							</select>
						<BR>
						</p>
					
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="footer1">
		<div class="row">
			<div class="12u">
				<section id="fbox1">
					<p style="text-align:right;"><input class="button-style1" type="submit" value="Ingresar"/></p>
				</section>
			</div>
		</div>
	</div>
	</form>
</div>

<div id="wrapper">
	<form action="validar_paciente3.php" method="post">
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="12u">
				<section class="content">
					<h2>Comparaciones entre Pacientes</h2>
					Ingrese la cédula de identidad del paciente a comparar:<br>
					<p>
						<input type="text" name="cedula"><?php verificar_campo();?><br>
					</p>
					
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="footer1">
		<div class="row">
			<div class="12u">
				<section id="fbox1">
					<p style="text-align:right;"><input class="button-style1" type="submit" value="Ingresar"/></p>
				</section>
			</div>
		</div>
	</div>
	</form>
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