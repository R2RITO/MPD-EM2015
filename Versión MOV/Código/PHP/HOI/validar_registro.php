<!DOCTYPE HTML>
<!--/> 
	Arturo Voltattorni 10-10774
	Ramon Marquez	   10-10849
	Esteban Oliveros   10-11252
	
	Archivo que realiza las validaciones del registro de usuario.
<!-->

<?php 

include_once ("FachadaBD.php");
#include_once ("EFA_tab.php");

include_once ("medico.php");

if($_POST["medico"] == 1){ echo "es fisioterapeuta";
						}else{
							echo "es otro"; 
						};

function verificar_nombre(){
	$valido = true;
	if(trim($_POST["firstname"]) == ""){	
		echo "<font color='red'> **debe introducir un valor para el campo de Nombres </font>";
		$valido = false;
	}
	return $valido;
}

function verificar_apellido(){
	$valido = true;
	if(trim($_POST["lastname"]) == ""){
		echo "<font color='red'>**debe introducir un valor para el campo de Apellidos</font>";
		$valido = false;
	}
	return $valido;
}

function verificar_usuario(){
	$valido = true;
	if(trim($_POST["username"]) == ""){
		echo "<font color='red'>**debe introducir un valor para el campo Usuario</font>";
		$valido = false;
	}
	return $valido;
}

function verificar_contrasena(){
	$valido = true;
	if((trim($_POST["pwd1"]) == "") && (trim($_POST["pwd2"]) == "") ){
		echo "<font color='red'>**debe introducir un valor para la contraseña</font>";
		$valido = false;
	}
	return $valido;
}

function contrasenas_iguales(){
	$valido = true;
	if($_POST["pwd1"] != $_POST["pwd2"]){
		echo "<font color='red'>/ las contraseñas no coinciden</font>";
		$valido = false;
	}
	return $valido;
	
}


function longitud_pwd(){
	$valido = true;
	if(strlen($_POST['pwd1'])< 6){
		echo "<font color='red'>/ la contraseña debe tener una longitud mayor a 6 caracteres</font>";
		$valido = false;
	}
	return $valido;
}

function selec_medico(){
	$valido = true;
	if($_POST["medico"] == NULL){
		echo "<font color='red'>**debe seleccionar un tipo de medico</font>";
		$valido = false;
	}
	return $valido;
}


function unic_user(){
		
		$fbd = FachadaBD::getInstance();
		$valido = true;
		$user = strtoupper(htmlentities($_POST["username"], ENT_QUOTES));
        $query = "SELECT COUNT(USUARIO) FROM MEDICO WHERE USUARIO ='".$user."' ";
		
        
        $conexion = $fbd->conectar("ADMIN","1234");
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
	<?php include("encabezado.php")?>
</head>
<body>
	<div id="header-wrapper">
		<header id="header" class="5grid-layout">
			<div id="row">
				<div id="12u">
					<div id="logo">
						<h1><a href="#" class="mobileUI-site-name">Registro de Usuarios</a></h1>
						<p>Hospital Ortopédico Infantil</p>
					</div>
				</div>
			</div>
		</header>
	</div>
	<div id="wrapper">
		<form action="validar_registro.php" method="post">
		<div class="5grid-layout" id="welcome">
			<div class="row">
				<div class="12u">
					<section class="content">
						<h2 align="center">Datos Personales del Médico</h2>
							<table >
								<tr>
									<td> Nombresss:</td>
									<td> <input type="text" id="firstname" name="firstname"><br>
										 <?php verificar_nombre();?></td>
									<td>
								</tr>
								<tr>
									<td> Apellidos:</td>
									<td> <input type="text" id="lastname" name="lastname"><br>
										 <?php verificar_apellido();?></td>
								</tr>
								<tr>
									<td> Cédula de Identidad:</td>
									<td> <input type="text" id="cedula" name="cedula"></td>
								</tr>
								<tr>
									<td> Usuario:</td>
									<td> <input type="text" id="username" name="username"><br>
										 <?php verificar_usuario(); unic_user()?></td>
								</tr>
								<tr>
									<td> Contraseña:</td>
									<td> <input type="password" id="pwd1" name="pwd1"><br>
										 <?php verificar_contrasena(); longitud_pwd()?></td>
								</tr>
								<tr>
									<td> Repetir Contraseña:</td>
									<td> <input type="password" id="pwd2" name="pwd2"><br>
										 <?php verificar_contrasena(); contrasenas_iguales()?></td>
								</tr>
								<tr>
									<td> Tipo de Usuario:<?php selec_medico();?></td>
									<td> 
										<input type="radio" name="medico" id="medico" value=1>Fisioterapeuta<br>
										<input type="radio" name="medico" id="medico" value=2>Interpretador
										
									</td>
								</tr>
							</table>
					</section>
				</div>
			</div>
		</div>
		<div class="5grid-layout" id="footer1">
			<div class="row">
				<div class="12u">
					<section id="fbox1">
						<p style="text-align:right;"><input class="button-style1" type="submit" value="Continuar"/></p></p>	
					</section>
				</div>
			</div>
		</div>
		</form>

	</div>
	<?php include("footer.php")?>
</body>
</html>