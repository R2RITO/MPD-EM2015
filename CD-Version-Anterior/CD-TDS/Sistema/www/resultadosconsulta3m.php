<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra los resultados del tercer tipo de consulta de pacientes
	en la interfaz movil.
<!-->
<html>
<head>
<meta name="viewport" content="width=device-width, content="text/html; charset=UTF-8", minimum-scale=1, maximum-scale=1">
<?php

session_start();
include_once ("FachadaBD.php");

/*	Funcion que se realiza a la base de datos para buscar los pacientes 
	semejantes en cuanto a dispositivos.
*/
function realizarBusqueda(){

	$cedula = $_GET['cedula'];
	

	$fbd = FachadaBD::getInstance();
	$results = $fbd->compararDispositivosIgualesBD($cedula, 1, 10);

	echo "<h2>Resultados</h2>";
	echo '<table border="1">';
	echo "<tr>";
	echo "<th>Nombres</th>";
	echo "<th>Apellidos</th>";
	echo "<th>Cedula</th>";
	echo "<th>Id Historial</th>";
	echo "<th>Semejanza</th>";
	echo "<th>Promedio de Semejanza</th>";
	echo "</tr>";
	
	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo "<tr>";

		for ($i=0; $i <= 5; $i++) {
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