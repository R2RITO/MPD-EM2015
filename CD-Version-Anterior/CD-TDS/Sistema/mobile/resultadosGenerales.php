<?php
/**
 * En esta vista se muestran los resultados de la consulta general.
 *
 * @author: Daniela & Ruben.
 */
session_start();
include_once ("FachadaBD.php");

/**	
 * Funcion de verificacion de la seleccion de la busqueda en cuanto al peso.
 *
 * Se observa si selecciono peso y parametro para luego enviarlo.
 * @return 'a': Retorna el caracter 'a' si no consiguio parametros.
 * @return $_POST['peso']: Etiqueta de peso seleccionada para realizar la consulta.
 * @author: Veronica, Andrea, Daniela & Ruben.
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

/**	
 * Funcion de verificacion de la seleccion de la busqueda en cuanto al tono flexor dorsal izquierdo.
 *
 * Se observa si selecciono tono flexor dorsal izquierdo y parametro para luego enviarlo.
 * @return 'a': Retorna el caracter 'a' si no consiguio parametros.
 * @return $_POST['tonoflexdorizq']: Etiqueta de TFDI seleccionada para realizar la consulta,
 * @return $_POST['dominioTFDI']: Dominio del TFDI deseado para realizar la consulta.
 * @author: Veronica, Andrea, Daniela & Ruben.
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

/**	
 * Funcion de verificacion de la seleccion de la busqueda en cuanto al tono flexor dorsal derecho.
 *
 * Se observa si selecciono tono flexor dorsal derecho y parametro para luego enviarlo.
 * @return 'a': Retorna el caracter 'a' si no consiguio parametros.
 * @return $_POST['tonoflexdorder']: Etiqueta de TFDI seleccionada para realizar la consulta,
 * @return $_POST['dominioTFDD']: Dominio del TFDD deseado para realizar la consulta.
 * @author: Veronica, Andrea, Daniela & Ruben.
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

/**	
 * Funcion de verificacion de la seleccion de la busqueda en cuanto a las caracteristicas de marcha.
 *
 * Se observa si selecciono peso y parametro para luego enviarlo.
 * @return 'a': Retorna el caracter 'a' si no consiguio parametros.
 * @return $_POST['caracmarcha']: Etiqueta de caracteristica de marcha seleccionada para realizar la consulta.
 * @author: Veronica, Andrea, Daniela & Ruben.
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

/**
 * Funcion que realiza la busqueda en la base de datos dependiendo de las selecciones del usuario y muestra la tabla de resultados.
 *
 * Esta funcion obtiene todos los parametros elegidos por el usuario y compara los distintos atributos para poder realizar
 * una tabla responsive para dispositivos moviles.
 *
 * @author: Veronica, Andrea, Daniela & Ruben
 */
function realizarBusqueda(){

	$etiquetaP = parametro1();
	$etiquetaTFDI = parametro2();
	$etiquetaTFDD = parametro3();
	$etiquetaCM = parametro4();
  
	$fbd = FachadaBD::getInstance();
	$results = $fbd->compararAtributosBD2($etiquetaP, $etiquetaTFDI, $etiquetaTFDD, $etiquetaCM, 1, 10);
 

        echo '<div class="table-responsive">';
	echo '<table class="table">';
	echo '<tr class="tablita">';
	echo "<th>Nombres</th>";
	echo "<th>Apellidos</th>";
	echo "<th>Cedula</th>";
	echo "<th>Fecha Examen</th>";
	$j = 3;

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
                $link = '"resultadoConsultaCedula.php?cedula='.$row[2].'"';
		echo '<a href = "$link"><tr class="tablita">';
		for ($i=0; $i <= $j; $i++) {
			if ($i >= 0 && $i < 3 ){
				echo "<td><a href=$link>".$row[$i]."</a></td>";
			} else{
				echo "<td>".$row[$i]."</td>";
			}
		}
		echo "</tr>";
	}
    echo "</div>";
    echo "</table>";	
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Datos del Paciente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/mystyle.css" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>
  
<body>  
 <!-- Barra Principal de Opciones -->
 <nav class="navbar navbar-default navFondo" role="navigation">
  <div class="navbar-header">
    <!-- Tiene parametros definidos -->

    <!-- Es Medico o Interpretado -->
    <?php if ($_SESSION['esfisio'] == 1){ ?>
      <a class ="icon" href="perfil.php"><span class="glyphicon glyphicon-home"></span></a>
      <a class ="icon" href="nuevoPaciente.php"><span class="glyphicon glyphicon-plus-sign"></span></a>
      <a class ="icon" href="nuevoEFA.php"><span class="glyphicon glyphicon-folder-open"></span></a>
      <a class ="icon selected" href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
				<ul class="dropdown-menu">
					<li><a href="paciente.php">Paciente</a></li>
					<li><a href="generales.php">Generales</a></li>
                                        <li><a href="comparaciones.php">Comparaciones</a></li>
				</ul>
       <a class ="icon" href="consultaBorrarPaciente.php"><span class="glyphicon glyphicon-minus-sign"></span></a></li>	
       <a class ="icon" href="cerrarSesion.php"><span class="glyphicon glyphicon-log-out"></span></a>    
    <?php }else{ ?>
       <a class ="icon selected" href="perfil.php"><span class="glyphicon glyphicon-home"></span></a>
       <a class ="icon" href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
				<ul class="dropdown-menu">
					<li><a href="paciente.php">Paciente</a></li>
					<li><a href="generales.php">Generales</a></li>
                                        <li><a href="comparaciones.php">Comparaciones</a></li>
				</ul>
       <a class ="icon" href="cerrarSesion.php"><span class="glyphicon glyphicon-log-out"></span></a>   
    <?php } ?>
 </div>
 </nav>
 <b><?php if ($_SESSION['esfisio'] == 1){ echo "Fisioterapeuta: "; } else { echo "Interpretador: "; } ?></b>
 <b><?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ; ?></b>

 <!-- ================================================== -->
 <!-- Consultar Paciente-->
 
  <div>
     <p class="titulo">Resultados</p>
 </div>
 
 <?php realizarBusqueda();?>
 
 <!--
 <div class="row">
   <div class="col-xs-12 col-md-7 trans ">	
	  <div class="col-xs-12 col-md-5 trans2">	
		  <p>Nombre: </p>
                  <p>Cedula: </p>
                  <p>Id Historial: </p>
                  <p>Fecha del examen: </p>
                  <p>Peso: </p>
                  <p>Tono Flexor Dorsal Derecho: </p>
                  <p>Tono Flexor Dorsal Izquierdo: </p>
                  <p>Caracteristicas de marcha: </p>
	  </div>
  </div>
 </div>
 -->
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
