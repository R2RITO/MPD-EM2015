<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta name="viewport" content="width=device-width, content="text/html; charset=UTF-8", minimum-scale=1, maximum-scale=1">

<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra la interfaz de la consulta de los pacientes en el area movil.
<!-->


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
   <a href="logoutm.php" data-role="button" data-icon="info" data-iconpos="notext">cerrar sesi�n</a>
   </div><!-- /header -->
   <br/>
   <div data-role="content">
   
		<div data-role="partes" style="background-image:url(themes/images/fb1.png); background-repeat: no-repeat; background-position: 50% 50%;">
		<br/>
		<p align="center">
			  <font face="Arial" size="3" color="#515756">
				<strong>CONSULTAR PACIENTE</strong> 
			   </font>
		   </p>
		   
		  <form action="validar_pacientem.php" method="post"> 
		  <p align="center">
			  <font face="Arial" size="2" color="#515756">
			    </br>
				Ingrese el n�mero de c�dula de identidad del paciente:<br>
					<input type="text" name="cedula" style="width: 400px">
				 </br>
				 <p style="text-align:center;"><input class="button-style1" type="submit" value="Consultar"/></p>
				 </br>
			   </font>
		   </p>
		   </form>
		   
		</div>
		
		<div data-role="partes" style="background-image:url(themes/images/fb1.png); background-repeat: no-repeat; background-position: 50% 50%;">
		<br/>
		<p align="center">
			  <font face="Arial" size="3" color="#515756">
				<strong>CONSULTAS GENERALES</strong> <br> <br>
				
			   </font>
		   </p>
		   
		  <p align="center" >
			  <font face="Arial" size="2" color="#515756">
			    Selecciones las condiciones de la b�squeda:<br><br>
		   
				
				
			
			</font>
		   </p>	 
		   
		<div data-role="fieldcontain" align="center">
		<form action="resultadosconsulta2m.php" method="post">
				<fieldset data-role="controlgroup">
					<input TYPE="checkbox" NAME="parametro1" ID="parametro1" VALUE="Y" />
					<label for="parametro1" >parametro1</label>
				</fieldset>
			<br>
				<select name="peso" data-native-menu="false" data-theme="c">
					<option value="">Seleccione...</option>
							<?php buscarEtiquetasPeso();?>
				</select>
			
			
			</br><br><br>
			
			
				<fieldset data-role="controlgroup">
					<input TYPE="checkbox" NAME="parametro2" VALUE="Y" id="parametro2" class="custom" />
					<label for="parametro2">Tono Flexor Dorsal Izquierdo</label>
				</fieldset>
			<br>
				<select name="tonoflexdorizq" data-native-menu="false" data-theme="c">
							<option value="">Seleccione...</option>
							<?php buscarEtiquetasTFDI();?>
				</select>			
			
						
				<select name="dominioTFDI" data-native-menu="false" data-theme="c">
						<option value=""> (Dominio Fijo)Seleccione...</option>
						<?php buscarDominioTFDI();?>
				</select>
				
			
			</br><br><br>
			
			
				<fieldset data-role="controlgroup">
					<input TYPE="checkbox" NAME="parametro3" VALUE="Y" id="parametro3" class="custom" />
					<label for="parametro3">Tono Flexor Dorsal Derecho</label>
				</fieldset>
			
			<br>
			
			<select name="tonoflexdorder" data-native-menu="false" data-theme="c">
							<option value="">Seleccione...</option>
							<?php buscarEtiquetasTFDD();?>
				</select>
		
				<select name="dominioTFDD" data-native-menu="false" data-theme="c">
							<option value="">(Dominio Fijo)Seleccione...</option>
							<?php buscarDominioTFDD();?>
							</select>
		
		
			
			</br><br><br>
			
			
				<fieldset data-role="controlgroup">
					<input type="checkbox" name="ra" id="ra" class="custom" />
					<label for="ra" >Caracter�sticas de Marcha</label>
				</fieldset>
			
			<br>
			
				<select name="caracmarcha" data-native-menu="false" data-theme="c">
					<option value="">Seleccione...</option>
					<?php buscarEtiquetasCaracMarcha();?>
				</select>
			
			
			</br><br>
			<p style="text-align:center;"><input class="button-style1" type="submit" value="Consultar"/></p>		
			</br>
		</form>
			
		</div>
					
		</div>
		
		</br>
		
		<div data-role="partes" style="background-image:url(themes/images/fb1.png); background-repeat: no-repeat; background-position: 50% 50%;">
		
		<br/>
		<p align="center">
			  <font face="Arial" size="3" color="#515756">
				<strong>COMPARAR PACIENTES</strong> 
			   </font>
		   </p>
		  <form action="validar_paciente3m.php" method="post"> 
		  <p align="center">
			  <font face="Arial" size="2" color="#515756">
			    </br>
				
				Ingrese la c�dula de identidad del paciente a comparar:<br>
					<input type="text" name="id" style="width: 400px">
				 </br>
				 <p style="text-align:center;"><input class="button-style1" type="submit" value="Consultar"/></p>
				 </form>
				 </br>
			   </font>
		   </p>
		</div>
		
		
				
   </div><!-- /content -->
   
   <div data-role="footer" data-id="foo1" data-position="fixed" data-theme="b">
	<div data-role="navbar">
		<ul>
			
			<li><a href="consultarm.php" data-icon="search">CONSULTAR</a></li>
		</ul>
	</div><!-- /navbar -->
</div><!-- /footer -->
   <!-- /header -->
   </div><!-- /page -->
</body>
</html>