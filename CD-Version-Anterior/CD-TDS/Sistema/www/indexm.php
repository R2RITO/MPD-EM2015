<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta name="viewport" content="width=device-width, content="text/html; charset=UTF-8", minimum-scale=1, maximum-scale=1">
<title>Laboratorio Marcha</title>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<script src="css/5grid/jquery.js"></script>
<script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none"></script>
	<script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.js">
</script>
<script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.flot.js"></script>
</head>

<style type="text/css">
	
	table td{
		padding:7px;
		border:1px solid #CCC
	}
	table th{
		background-color:#58ACFA;
		font-weight:bold;
		padding:7px;
		border:1px solid #CCC
	}
</style>

<?php session_start(); 


include_once ('FachadaBD.php');
include_once ("EFA_tab.php");

function obtenerPeso(){
    $fbd = FachadaBD::getInstance();
    $peso = $fbd->consultarPesoBD();
	$d_grafica;
	$eti;
	
	
    while(($row1 = oci_fetch_array($peso, OCI_BOTH))){
		
        echo $row1[0] . "\n";
        echo $row1[1] . "\n";
        echo $row1[2] . "\n";
        echo $row1[3] . "\n";
        echo $row1[4] . "<br><br>";
		$eti[]= $row1[0];
		for($i=1;$i<=4;$i++){
		$d_grafica[]=$row1[$i];
		}; 
		
		
	}
	
	//echo "<script language='JavaScript'> dibuja_grafico('".$eti[0]."','".$eti[1]."','".$eti[2]."',".$d_grafica[0].",".$d_grafica[1].",".$d_grafica[2].",".$d_grafica[3].",".$d_grafica[4].",".$d_grafica[5].",".$d_grafica[6].",".$d_grafica[7].",".$d_grafica[8].",".$d_grafica[9].",".$d_grafica[10].",".$d_grafica[11].");</script>";
	//echo '<div id="placeholder" style="width:400px;height:200px;"></div> <br><br>';
		
	//print_r($d_grafica)."<BR>";
	//echo "".$d_grafica[0].",".$d_grafica[1].",".$d_grafica[2].",".$d_grafica[3].",".$d_grafica[4].",".$d_grafica[5].",".$d_grafica[6].",".$d_grafica[7].
	//",".$d_grafica[8].",".$d_grafica[9].",".$d_grafica[10].",".$d_grafica[11]."";
	
}

function obtenerTM(){
    $fbd = FachadaBD::getInstance();
    $tono = $fbd->consultarTNBD();

	$table = "<table  border='1'>";
	
	$table .= "<tr><th>etiqueta</th><th>dominio</th><th>grado</th><tr>";
	
    while(($row1 = oci_fetch_array($tono, OCI_BOTH))){
		$table .= "<tr>";
		
		$table .= "<td>";
		$table .=$row1[0];
		$table .= "</td>";
		
		$table .= "<td>";
		$table .=$row1[1];
		$table .= "</td>";
		
		$table .= "<td>";
		$table .=$row1[2];
		$table .= "</td>";
		   
		$table .= "</tr>";
    }
	
	$table .= "</table>";							
	echo $table;
}

function obtenerCM(){
    $fbd = FachadaBD::getInstance();
    $marcha = $fbd->consultarCMBD();
	
	$table = "<table  border='1'>";
	
	$table .= "<tr><th>característica 1</th><th>característica 2</th><th>grado</th><tr>";

    while(($row1 = oci_fetch_array($marcha, OCI_BOTH))){
        $table .= "<tr>";
		
		$table .= "<td>";
		$table .=$row1[0];
		$table .= "</td>";
		
		$table .= "<td>";
		$table .=$row1[1];
		$table .= "</td>";
		
		$table .= "<td>";
		$table .=$row1[2];
		$table .= "</td>";
		   
		$table .= "</tr>";

    }
	
	$table .= "</table>";							
	echo $table;
}

function tipo_medico(){
if ($_SESSION['esfisio'] == 1){ echo "Fisioterapeuta";
}else{ echo "Interpretador";};
}

?>
 
<body> 
<div data-role="page"  data-theme="b"  style="background-image:url(themes/images/img01.png)">
   <div data-role="header" data-theme="d" data-position="fixed">
   <a href="indexm.php" data-role="button" data-icon="home" data-iconpos="notext">home</a>
      <h1>BIENVENIDO DR. <?php echo $_SESSION['apellido'] ?></h1>
   <a href="logout.php" data-role="button" data-icon="info" data-iconpos="notext">cerrar sesión</a>
   </div><!-- /header -->
   <br/>
   <div data-role="content">
   
		<div data-role="partes" style="background-image:url(themes/images/fb1.png); background-repeat: no-repeat; background-position: 50% 50%;">
		<br/>
		  <p align="center">
			  <font face="Arial" size="2" color="#515756">
				<img src="images/doctorP.jpg"  width="160" height="160"  alt=""> </br>
				<strong>Nombre completo: </strong><?php echo $_SESSION['nombre'] .' '.$_SESSION['apellido'] ?> </br> 
				<strong>Usuario: </strong><?php echo $_SESSION['user'] ?></br>  
				<strong>Profesión: </strong><?php tipo_medico(); ?></br> 
			   </font>
		   </p>
			<p align = "center"><script src="http://www.clocklink.com/embed.js"></script><script type="text/javascript" language="JavaScript">obj=new Object;obj.clockfile="5002-blue.swf";obj.TimeZone="GMT-0430";obj.width=240;obj.height=20;obj.Place="";obj.DateFormat="DD-mm-YY";obj.wmode="transparent";showClock(obj);</script>
					</p>
					<br/>
		</div>
		
				
		<br/>
		
		<div data-role="partes" style="background-image:url(themes/images/fb1.png); background-repeat: no-repeat; background-position: 50% 50%;">
		<br/>
		  <p align="center">
			  <font face="Arial" size="3" color="#515756">
				<strong>MIS PARÁMETROS</strong> 
				<br><br>
			   </font>
		  
			 <strong>PESO</strong><br><br>
			 							
				Las etiquetas de peso establecidas son: <br> <br>
				<?php obtenerPeso(); ?>

			<br><br>

				<strong>TONO FLEXOR DORSAL</strong> <br><br>
			 							
				
				<?php obtenerTM(); ?>

			<br><br>

				<strong>CARACTERÍSTICAS DE MARCHA</strong> <br><br>
			 	
			 	 <br> <br>
				<?php obtenerCM();?>
			
		   </p>
		   
		    <br/>
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