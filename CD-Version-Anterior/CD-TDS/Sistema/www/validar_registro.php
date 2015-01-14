<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que valida el formulario para el ingreso de un nuevo usuario en la
	base de datos.
<!-->

<?php 

include_once ("FachadaBD.php");
include_once ("EFA_tab.php");
include_once ("Medico.php");

if($_POST["medico"] == 1){ echo "es fisioterapeuta";
						}else{
							echo "es otro"; 
						};

function verificar_nombre(){
	$valido = true;
	if(trim($_POST["firstname"]) == ""){
		echo "**debe introducir un valor para el campo de Nombres";
		$valido = false;
	}
	return $valido;
}

function verificar_apellido(){
	$valido = true;
	if(trim($_POST["lastname"]) == ""){
		echo "**debe introducir un valor para el campo de Apellidos";
		$valido = false;
	}
	return $valido;
}

function verificar_usuario(){
	$valido = true;
	if(trim($_POST["username"]) == ""){
		echo "**debe introducir un valor para el campo Usuario";
		$valido = false;
	}
	return $valido;
}

function verificar_contrasena(){
	$valido = true;
	if((trim($_POST["pwd1"]) == "") && (trim($_POST["pwd2"]) == "") ){
		echo "**debe introducir un valor para la contraseña";
		$valido = false;
	}
	return $valido;
}

function contrasenas_iguales(){
	$valido = true;
	if($_POST["pwd1"] != $_POST["pwd2"]){
		echo "/ las contraseñas no coinciden";
		$valido = false;
	}
	return $valido;
	
}


function longitud_pwd(){
	$valido = true;
	if(strlen($_POST['pwd1'])< 6){
		echo "/ la contraseña debe tener una longitud mayor a 6 caracteres";
		$valido = false;
	}
	return $valido;
}

function selec_medico(){
	$valido = true;
	if($_POST['medico'] == NULL){
		echo "**debe seleccionar un tipo de medico";
		$valido = false;
	}
	return $valido;
}


function unic_user(){
		
		$fbd = FachadaBD::getInstance();
		$valido = true;
		$user = strtoupper(htmlentities($_POST["username"], ENT_QUOTES));
        $query = "SELECT COUNT(USUARIO) FROM MEDICO WHERE USUARIO ='".$user."' ";
		
        
        $conexion = $fbd->conectar("USERDEF","1234");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
		$row = oci_fetch_array($results,OCI_BOTH);
		if ($row[0]>0){ 
			echo "nombre de usuario ya existe, escriba uno diferente";
			$valido = false;
		}
		
        $fbd->desconectar($conexion);
		
		return $valido;		
	}
	


$valido = unic_user() && selec_medico() && longitud_pwd() && verificar_nombre() &&  verificar_apellido();
$valido = $valido && verificar_usuario() && verificar_contrasena() && contrasenas_iguales();

if($valido){
	$fbd = FachadaBD::getInstance();
	$medico = NEW Medico();
	$medico-> setCI($_POST["cedula"]);
	$medico-> setNombres($_POST["firstname"]);
	$medico-> setApellidos($_POST["lastname"]);
	$medico-> setUsuario($_POST["username"]);
	$medico-> setContrasena($_POST["pwd1"]);
	$medico-> setFisio($_POST["medico"]);
	$fbd -> agregarUsuarioBD($medico);
	
	//iniciar sesion
	
	            session_start();
				$_SESSION['user'] = $_POST["username"];
                $_SESSION['pass'] = $_POST["pwd1"];
                $_SESSION['nombre'] = $_POST["firstname"];
                $_SESSION['apellido'] = $_POST["lastname"];
                $_SESSION['esfisio'] = $_POST["medico"];
	
	header ("Location: f_indexE2.php");
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
					
					<h2>Datos Personales del Médico</h2>
						<form action="validar_registro.php" method="post">
							Nombres: <input type="text" id="firstname" name="firstname"> <?php verificar_nombre();?><br> 
							Apellidos: <input type="text" id="lastname" name="lastname"><?php verificar_apellido();?><br>
							Cédula de Identidad: <input type="text" id="cedula" name="cedula"><br>
							Usuario: <input type="text"  id="username" name="username"><?php verificar_usuario();  unic_user()?><br>
							Contraseña: <input type="password" id="pwd1" name="pwd1"><?php verificar_contrasena(); longitud_pwd()?><br>
							Repetir Contraseña: <input type="password" id="pwd2" name="pwd2"><?php verificar_contrasena(); contrasenas_iguales()?><br>
							Tipo de Usuario: <?php selec_medico()?><br><br>
							<input type="radio" name="medico" id="medico" value="1" >Fisioterapeuta<br>
							<input type="radio" name="medico" id="medico" value="2">Otro
							<br><br>
							<input type="submit" value="Continuar" />
						</form>
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="footer1">
		<div class="row">
			<div class="12u">
				<section id="fbox1">	
				</section>
			</div>
		</div>
	</div>

</div>
<div class="5grid-layout" id="copyright">
	<div class="row">
		<div class="12u">
			<section align="right" style="margin-right: 62px;">
				<p>&copy; Laboratorio de Marcha | Hospital J.M de los Ríos &nbsp;&nbsp;&nbsp;&nbsp;              
			</section>
		</div>
	</div>
</div>
</body>
</html>