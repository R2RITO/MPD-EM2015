<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo donde se recogen los datos de peso para ser insertados en la base de datos.
	Los datos son validados por las funciones definidas y se ingresan en la base de datos. 
<!-->

<?php 

include_once ("FachadaBD.php");
include_once ("EFA_tab.php");
include_once ("D_Peso.php");

session_start();

/*	Funcion que verifica que los valores del trapecio del peso
	para la etiqueta "ligero" esten dentro de los parametros
	para ser insertados en la base de datos.
*/

function verificarVdelgado(){
	
	if((trim($_POST["l1"]) == "") | (trim($_POST["l2"]) == "") | (trim($_POST["l3"]) == "") | (trim($_POST["l4"]) == "")){
		return 1;
	} elseif (!((trim($_POST["l1"]) <= trim($_POST["l2"])) && (trim($_POST["l2"]) <= trim($_POST["l3"])) && (trim($_POST["l3"]) <= trim($_POST["l4"])))) {
		return 2;
	} elseif (!(preg_match("/^[[:digit:]]+$/", $_POST['l1']) && preg_match("/^[[:digit:]]+$/", $_POST['l2']) && preg_match("/^[[:digit:]]+$/", $_POST['l3']) && preg_match("/^[[:digit:]]+$/", $_POST['l4']))){
		return 3;
	}

	return 0;
}

/*	Funcion que verifica que los valores del trapecio del peso
	para la etiqueta "normal" esten dentro de los parametros
	para ser insertados en la base de datos.
*/
function verificarVnormal(){

	if((trim($_POST["n1"]) == "") | (trim($_POST["n2"]) == "") | (trim($_POST["n3"]) == "") | (trim($_POST["n4"]) == "")){
		return 1;
	} elseif (!((trim($_POST["n1"]) <= trim($_POST["n2"])) && (trim($_POST["n2"]) <= trim($_POST["n3"])) && (trim($_POST["n3"]) <= trim($_POST["n4"])))) {
		return 2;
	} elseif (!(preg_match("/^[[:digit:]]+$/", $_POST['n1']) && preg_match("/^[[:digit:]]+$/", $_POST['n2']) && preg_match("/^[[:digit:]]+$/", $_POST['n3']) && preg_match("/^[[:digit:]]+$/", $_POST['n4']))){
		return 3;
	}

	return 0;
}

/*	Funcion que verifica que los valores del trapecio del peso
	para la etiqueta "obeso" esten dentro de los parametros
	para ser insertados en la base de datos.
*/
function verificarVobeso(){

	if((trim($_POST["o1"]) == "") | (trim($_POST["o2"]) == "") | (trim($_POST["o3"]) == "") | (trim($_POST["o4"]) == "")){
		return 1;
	} elseif (!((trim($_POST["o1"]) <= trim($_POST["o2"])) && (trim($_POST["o2"]) <= trim($_POST["o3"])) && (trim($_POST["o3"]) <= trim($_POST["o4"])))) {
		return 2;
	} elseif (!(preg_match("/^[[:digit:]]+$/", $_POST['o1']) && preg_match("/^[[:digit:]]+$/", $_POST['o2']) && preg_match("/^[[:digit:]]+$/", $_POST['o3']) && preg_match("/^[[:digit:]]+$/", $_POST['o4']))){
		return 3;
	}

	return 0;
}

/*	Agrega en la base de datos los valores del trapecio para
	la etiqueta "Ligero"
*/
function agregarDelgado(){

	$fbd = FachadaBD::getInstance();
	$valido = verificarVdelgado();
	if ($valido == 1) {
		echo "** Los cuatro campos deben contener información";
	} elseif ($valido == 2) {
		echo "** Los números deben estar de menor a mayor";
	} elseif ($valido == 3) {
		echo "** Los campos deben contener sólo números";
	} else {
		$peso = NEW D_Peso();
		$peso-> setLabel('Delgado');
		$peso-> setN1($_POST["l1"]);
		$peso-> setN2($_POST["l2"]);
		$peso-> setN3($_POST["l3"]);
		$peso-> setN4($_POST["l4"]);
		$fbd->agregarPesoBD($peso);
	}
}

/*	Agrega en la base de datos los valores del trapecio para
	la etiqueta "Normal"
*/
function agregarNormal(){

	$fbd = FachadaBD::getInstance();
	$valido = verificarVnormal();
	if ($valido == 1) {
		echo "** Los cuatro campos deben contener información";
	} elseif ($valido == 2) {
		echo "** Los números deben estar de menor a mayor";
	} elseif ($valido == 3) {
		echo "** Los campos deben contener sólo números";
	} else {
		$fbd1 = FachadaBD::getInstance();
		$peso1 = NEW D_Peso();
		$peso1-> setLabel('Normal');
		$peso1-> setN1($_POST["n1"]);
		$peso1-> setN2($_POST["n2"]);
		$peso1-> setN3($_POST["n3"]);
		$peso1-> setN4($_POST["n4"]);
		$fbd1->agregarPesoBD($peso1);
	}
}

/*	Agrega en la base de datos los valores del trapecio para
	la etiqueta "Obeso"
*/
function agregarObeso(){

	$fbd = FachadaBD::getInstance();
	$valido = verificarVobeso();
	if ($valido == 1) {
		echo "** Los cuatro campos deben contener información";
	} elseif ($valido == 2) {
		echo "** Los números deben estar de menor a mayor";
	} elseif ($valido == 3) {
		echo "** Los campos deben contener sólo números";
	} else {
		$fbd2 = FachadaBD::getInstance();
		$peso2 = NEW D_Peso();
		$peso2-> setLabel('Obeso');
		$peso2-> setN1($_POST["o1"]);
		$peso2-> setN2($_POST["o2"]);
		$peso2-> setN3($_POST["o3"]);
		$peso2-> setN4($_POST["o4"]);
		$fbd2->agregarPesoBD($peso2);
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
<script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.js">
</script>
<script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.flot.js"></script>
<script language="javascript" type="text/javascript">
function dibuja_grafico(x,y,v,w,x1,y1,v1,w1,x2,y2,v2,w2) {
	var datos = [
    [0,1],
	[v.value, 1],
	[w.value, 0],
	[300, 0],];
	
	var datos1 = [
	[0,0],
    [x1.value,0], 
	[y1.value, 1],
	[v1.value, 1],
	[w1.value, 0],
	[300,0],];
	
	var datos2 = [
	[0,0],
    [x2.value, 0],
    [y2.value,1],
	[v2.value, 1],
	[300,1],];
	
	var opciones = { xaxis: { min: 0, max: 300} , yaxis: { min: 0, max: 1} };
	$.plot($("#placeholder"), [datos, datos1, datos2], opciones);
	}
</script>

<!--[if IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->

</head><body>
<div id="header-wrapper">
	<header id="header" class="5grid-layout">
		<div id="row">
			<div id="12u">
				<div id="logo">
					<h1><a href="#" class="mobileUI-site-name">Registro de Pacientes</a></h1>
					<p>Hospital J.M. de los Ríos</p>
				</div>
			</div>
		</div>
	</header>
</div>
<div id="wrapper">
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="12u">
				<section class="content">
					<h2>Datos del Peso de los Pacientes</h2>
					<form action="indexP.php" method="post">
					LIGERO:
					 <input type="text" id="l1" name="l1"  style="width: 50px">
					 <input type="text" id="l2" name="l2" style="width: 50px">
					 <input type="text" id="l3" name="l3" style="width: 50px">
					 <input type="text" id="l4" name="l4" style="width: 50px">
					 <?php agregarDelgado();?>
					 
					<br>
					 
					  NORMAL:
					 <input type="text" id="n1" name="n1" style="width: 50px">
					 <input type="text" id="n2" name="n2" style="width: 50px">
					 <input type="text" id="n3" name="n3" style="width: 50px">
					 <input type="text" id="n4" name="n4" style="width: 50px">
					 <?php agregarNormal();?>

					<br>
					 
					  OBESO:
					 <input type="text" id="o1" name="o1" style="width: 50px">
					 <input type="text" id="o2" name="o2" style="width: 50px">
					 <input type="text" id="o3" name="o3" style="width: 50px">
					 <input type="text" id="o4" name="o4" style="width: 50px">
					 <?php agregarObeso();?>
					 
					<br><br>
					 
					  <input type="button" value="Generar Grafico" onclick="dibuja_grafico(l1,l2,l3,l4,n1,n2,n3,n4,o1,o2,o3,o4);" style="width: 100px">
					 <div id="placeholder" style="width:600px;height:300px;"></div>
					 
					 
					 <input class="button-style1" type="submit" value="Cargar datos" />
					 
					 </form>
					
					<p align="right"><a  href="index.php" class="button-style1">Ir a mi perfil</a></p>
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