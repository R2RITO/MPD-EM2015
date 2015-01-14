<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra el formulario para agregar un nuevo examen fisico articular
	de un paciente existente en la base de datos.
<!-->

<script type="text/javascript">
    function updateTextInput1(val) {
      document.getElementById('textInput1').value=val; 
    }

    function updateTextInput2(val) {
      document.getElementById('textInput2').value=val; 
    }
</script>

<?php

session_start();

include_once ("FachadaBD.php");

/*	Funcion que busca las etiquetas del peso almacenadas en 
	la base de datos para presentarlas al usuario para su
	seleccion para la busqueda.
*/
function buscarEtiquetasPeso(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosiblePesoBD();

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
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

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
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

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
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

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
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

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
	$results = $fbd->consultarEtiquetaPosibleCaracMarchaBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}


?>

<html>
<head>
<title>Laboratorio</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
					<h1><a href="#" class="mobileUI-site-name">Ingreso de Nuevo EFA</a></h1>
					<p>Hospital J.M. de los Ríos</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="12u">
				<div class="5grid-layout" id="menu">
					<nav class="mobileUI-site-nav">
						<ul>
							<li><a href="index.php">Home</a></li>
							<li><a href="nuevopaciente.php">Nuevo Paciente</a></li>
							<li class="current_page_item"><a href="#">Nuevo EFA</a></li>
							<li><a href="consultarpaciente.php">Consultar Paciente</a></li>
							<li><a href="eliminarpaciente.php">Eliminar Paciente</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>
</div>
<div id="wrapper">
	<form action="validarhistpaciente.php" method="post">
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="6u">
				<section class="content">
					<h2>Datos del Examen</h2>
					Cédula del Paciente: <input type="text" name="cedula"><br>
					Fecha del Examen: <input type="date" name="testdate"><br>
					Nombre del médico <br> que envió al paciente: <input type="text" name="medicoref"><br>
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="6u">
				<section class="content">
					<h2>Datos Recogidos</h2>
					<input type="text" name="P"> Peso<br>
					<select name="TFDI">
						<option value="">Seleccione...</option>
						<?php buscarDominioTFDI();?>
						</select> Tono Flexor Dorsal Izquierdo<br><br>
					<select name="TFDD"> 
						<option value="">Seleccione...</option>
						<?php buscarDominioTFDD();?>
						</select> Tono Flexor Dorsal Derecho<br><br>
					<select name="CM">
						<option value="">Seleccione...</option>
						<?php buscarEtiquetasCaracMarcha();?>
						</select> Características de Marcha<br><br>
						<BR>
				</section>
			</div>
			<div class="6u">
				<section class="content">
					<h2></h2>
					<h1>Puede completar su historia agregando las etiquetas a los resultados:</h1><br>
					<select name="PE">
						<option value="">Seleccione...</option>
						<?php buscarEtiquetasPeso();?>
						</select> Peso<br><br>
					<select name="TFDIE">
						<option value="">Seleccione...</option>
						<?php buscarEtiquetasTFDI();?>
						</select> Tono Flexor Dorsal Izquierdo<br><br>
						con grado <input type="range" name="TFDIG" min="0.0" max="1.0" step="0.1" onchange="updateTextInput1(this.value);"><input type="text" name="textInput1" id="textInput1" value=""><br><br>
					<select name="TFDDE"> 
						<option value="">Seleccione...</option>
						<?php buscarEtiquetasTFDD();?>
						</select> Tono Flexor Dorsal Derecho<br><br>
						con grado <input type="range" name="TFDDG" min="0.0" max="1.0" step="0.1" onchange="updateTextInput2(this.value);"><input type="text" name="textInput2" id="textInput2" value=""><br><br>
						<BR>
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="footer1">
		<div class="row">
			<div class="12u">
				<section id="fbox1">
					<p style="text-align:right;"><input class="button-style1" type="submit" value="Ingresar Examen"/></p>	
				</section>
			</div>
		</div>
	</div>
	</form>
</div>

<div class="5grid-layout" id="copyright">
	<div class="row">
		<div class="12u">
			<section>
				<p>&copy; Laboratorio de Marcha | Hospital J.M de los Ríos &nbsp;&nbsp;&nbsp;&nbsp;
			</section>
		</div>
	</div>
</div>
</body>
</html>