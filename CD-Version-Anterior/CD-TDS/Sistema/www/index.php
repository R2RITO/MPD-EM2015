<!DOCTYPE HTML>



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
<script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.js">
</script>
<script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.flot.js"></script>

<script>
function cambiar(contenido)
{
	vista=document.getElementById(contenido).style.display;
	if (vista=='none')
		vista='block';
	else
		vista='none';

	document.getElementById(contenido).style.display = vista;
}

function dibuja_grafico(e1,e2,e3,x,y,v,w,x1,y1,v1,w1,x2,y2,v2,w2) {
var data = [
		{
		label: e1,
		data:[
		[y,1], 
		[v, 1],
		[w, 0],
		[300, 0]]},
		
		{
		label: e2,
		data:[
		[0, 0],
		[x1,0], 
		[y1, 1],
		[v1, 1],
		[w1, 0],
		[300, 0]]},
		
		{
		label: e3,
		data:[
		[0, 0],
		[x2, 0],
		[y2,1],
		[v2, 1],
		[300, 1]]},
	
	];
	
	var opciones = { xaxis: { min: 0, max: 300} , yaxis: { min: 0, max: 1}, series:{lines: { show: true }, points: { show: true },}, legend: {
            show: true, position: 'se'},};
	$.plot($("#placeholder"), data , opciones);
	}
</script>

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
	
	echo "<script language='JavaScript'> dibuja_grafico('".$eti[0]."','".$eti[1]."','".$eti[2]."',".$d_grafica[0].",".$d_grafica[1].",".$d_grafica[2].",".$d_grafica[3].",".$d_grafica[4].",".$d_grafica[5].",".$d_grafica[6].",".$d_grafica[7].",".$d_grafica[8].",".$d_grafica[9].",".$d_grafica[10].",".$d_grafica[11].");</script>";
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


function obtenerTM2I(){
    $fbd = FachadaBD::getInstance();
    $tono = $fbd->consultarTNBD_etiqueta_I();
	$etiquetaT;
	$dominioT;
	$long_e =0;
	$long_d =0;
	$gradoT;
	
	while(($row1 = oci_fetch_array($tono, OCI_BOTH))){
        
		$etiquetaT[] =$row1[0];
		$long_e = $long_e +1;
		

    };
	
	
	$fbd1 = FachadaBD::getInstance();
    $tono1 = $fbd1->consultarTNBD_dominio_I();
	
	while(($row2 = oci_fetch_array($tono1, OCI_BOTH))){
        
		$dominioT[] =$row2[0];
		$long_d = $long_d +1;
		

    };

	$table = "<table  border='1'>";
	$table .= "<tr><th></th>";
	
	for($v=0; $v<$long_d; $v++){
	
		$table .= "<th>";
		$table .=$dominioT[$v];
		$table .= "</th>";
	
	};
	$table .= "</tr>";
	
	for($i=0; $i<$long_e; $i++){
	
		$table .= "<tr>";
		$table .= "<th>";
		$table .=$etiquetaT[$i];
		$table .= "</th>";
	
		for($j=0; $j<$long_d; $j++){
		
		$fbd2 = FachadaBD::getInstance();
		$tono2 = $fbd2->consultarTNBD_grado_I($dominioT[$j], $etiquetaT[$i]);
		$row3 = oci_fetch_array($tono2, OCI_BOTH);
		$gradoT[] = $row3[0];
		
		$table .= "<td>";
		$table .=$row3[0];
		$table .= "</td>";		
		
		};
		
		$table .= "</tr>";
	
	};
	
	

	$table .= "</table>";							
	echo $table;	
	
}


function obtenerTM2D(){
    $fbd = FachadaBD::getInstance();
    $tono = $fbd->consultarTNBD_etiqueta_D();
	$etiquetaT;
	$dominioT;
	$long_e =0;
	$long_d =0;
	$gradoT;
	
	while(($row1 = oci_fetch_array($tono, OCI_BOTH))){
        
		$etiquetaT[] =$row1[0];
		$long_e = $long_e +1;
		

    };
	
	
	$fbd1 = FachadaBD::getInstance();
    $tono1 = $fbd1->consultarTNBD_dominio_D();
	
	while(($row2 = oci_fetch_array($tono1, OCI_BOTH))){
        
		$dominioT[] =$row2[0];
		$long_d = $long_d +1;
		

    };

	$table = "<table  border='1'>";
	$table .= "<tr><th></th>";
	
	for($v=0; $v<$long_d; $v++){
	
		$table .= "<th>";
		$table .=$dominioT[$v];
		$table .= "</th>";
	
	};
	$table .= "</tr>";
	
	for($i=0; $i<$long_e; $i++){
	
		$table .= "<tr>";
		$table .= "<th>";
		$table .=$etiquetaT[$i];
		$table .= "</th>";
	
		for($j=0; $j<$long_d; $j++){
		
		$fbd2 = FachadaBD::getInstance();
		$tono2 = $fbd2->consultarTNBD_grado_D($dominioT[$j], $etiquetaT[$i]);
		$row3 = oci_fetch_array($tono2, OCI_BOTH);
		$gradoT[] = $row3[0];
		
		$table .= "<td>";
		$table .=$row3[0];
		$table .= "</td>";		
		
		};
		
		$table .= "</tr>";
	
	};
	
	

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

function obtenerCM2(){
    $fbd = FachadaBD::getInstance();
    $marcha = $fbd->consultarCM_etiquetas();
	$etiqueta1;
	$etiqueta2;
	$longitud=0;
	$grados;
	
	
		
		

    while(($row1 = oci_fetch_array($marcha, OCI_BOTH))){
        
		$etiqueta1[] =$row1[0];		
		$etiqueta2[] =$row1[0];
		$longitud = $longitud +1;
		

    };
	
	$table = "<table  border='1'>";
	$table .= "<tr><th></th>";
	
	for($v=0; $v<$longitud; $v++){
	
		$table .= "<th>";
		$table .=$etiqueta2[$v];
		$table .= "</th>";
	
	};
	$table .= "</tr>";
	
	$fbd1 = FachadaBD::getInstance();
	
	for($i=0; $i<$longitud; $i++){
	
		$table .= "<tr>";
		$table .= "<th>";
		$table .=$etiqueta1[$i];
		$table .= "</th>";
	
		for($j=0; $j<$longitud; $j++){
		
			$gr = $fbd1->consultarCM_grado($etiqueta1[$i], $etiqueta2[$j]);
			$row2 = oci_fetch_array($gr, OCI_BOTH);
			$grados[] = $row2[0];
			$table .= "<td>";
			$table .=$row2[0];
			$table .= "</td>";
		
		};
		
		$table .= "</tr>";
		
	};
	
	//ECHO "esto es etiqueta1 ".print_r($etiqueta1)."<br>";
	//ECHO "esto es etiqueta2 ".print_r($etiqueta2)."<br>";
	//ECHO "estos son los grados ".print_r($grados)."<br>";
	$table .= "</table> <br><br>";							
	echo $table;
	
	
}

function tipo_medico(){
if ($_SESSION['esfisio'] == 1){ echo "Fisioterapeuta";
}else{ echo "Interpretador";};
}

?>
</head><body>
<div id="header-wrapper">
	<header id="header" class="5grid-layout">
		<div id="row">
			<div id="12u">
				<div id="logo">
					<h1><a href="#" class="mobileUI-site-name">Bienvenido Dr <?php echo $_SESSION['apellido'] ?> </a></h1>
					
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
							<li class="current_page_item"><a href="index.php">Home</a></li>
							<li><a href="nuevopaciente.php"> Nuevo Paciente</a></li>
							<li><a href="nuevoEFA.php">Nuevo EFA</a></li>
							<li><a href="consultarpaciente.php"> Consultar Paciente</a></li>
							<li><a href="eliminarpaciente.php">Eliminar Paciente</a></li>
								<?php
							}else{ 
								?>
							<li class="current_page_item"><a href="index.php">Home</a></li>
							<li><a href="consultarpaciente.php"> Consultar Paciente</a></li>
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
	<div class="5grid-layout" id="page-wrapper">
		<div class="row">
			<div class="3u">
				<section id="pbox1">
					<p><a href="#"><img src="images/doctorP.jpg" alt=""></a></p> 
				</section>
			</div>
			<div class="6u">
				<section id="pbox2">
				<h2>Mis parámetros</h2>
					<ul class="style5">
						<li class="first">
						<a href="#" onclick="cambiar('placeholder'); return false;">Peso</a>	
						</li>
						<div id="placeholder" style="display: none; width:600px;height:300px;">						
							Las etiquetas de peso establecidas son: <br> <br>
							<?php obtenerPeso(); ?>
						</div>
						<br><br>
						<li><a href="#" onclick="cambiar('show_tono_muscular'); return false;">Tono Flexor Dorsal</a></li>
								<div id="show_tono_muscular" style="display: none;align=center;">
								
								Las etiquetas de tono flexor dorsal IZQUIERDO establecidas son: <br> <br>
								<p align="center"><?php obtenerTM2I(); ?></p><br><br>
								
								Las etiquetas de tono flexor dorsal DERECHO establecidas son: <br> <br>
								<p align="center"><?php obtenerTM2D(); ?></p><br><br>
								</div>
						<li><a href="#" onclick="cambiar('show_caract_marcha'); return false;">Características de la Marcha</a></li>
							<div id="show_caract_marcha" style="display: none;">						
								Las etiquetas de las características de la marcha establecidas son: <br> <br>
								<?php obtenerCM2(); ?>
							</div>
						<li></li>
						
					</ul>
					<p align = "right"><script src="http://www.clocklink.com/embed.js"></script><script type="text/javascript" language="JavaScript">obj=new Object;obj.clockfile="5002-blue.swf";obj.TimeZone="GMT-0430";obj.width=240;obj.height=20;obj.Place="";obj.DateFormat="DD-mm-YY";obj.wmode="transparent";showClock(obj);</script>
					</p>
				</section>
			</div>
			<div class="3u">
				<section id="pbox3">
				<h2>Datos personales</h2>
					<p><strong>Nombre completo: </strong> <?php echo $_SESSION['nombre'] .' '.$_SESSION['apellido'] ?> </br> 
						<strong>Usuario: </strong><?php echo $_SESSION['user'] ?></br>  
						<strong>Profesión: </strong><?php tipo_medico(); ?></br></br> </br> 			
					</p>
				</section>
			</div>
		</div>
	</div>
</div>

			<section align="right" style="margin-right: 62px;">
				<p>&copy; Laboratorio de Marcha | Hospital J.M de los Ríos &nbsp;&nbsp;&nbsp;&nbsp;              
			<a href="logout.php" class="button-style1" >Cerrar sesión</a></p>
			</section>
	
</div>
</body>
</html>