<?php 
/**
 * Archivo para la verificaci�n de registro de usuarios.
 *
 * @global $error: Variable String en donde se guardan todos los errores.
 * @global $valido: Variable String en donde se guardan los errores. En el caso de no tener errores entonces es valido el registro.
 * @author: Veronica, Andreina, Daniela & Ruben.
 */
 
include_once ("FachadaBD.php");
include_once ("Medico.php");
$error = "";

//var_dump ($_GET["usuario"]);

//if($_POST["medico"] == 1){ 
//   echo "es fisioterapeuta";
//}else{
//	echo "es otro"; 
//};


/**
 * Funci�n que verifica si el nombre que introdujo el usuario es valido.
 *
 * Esta funci�n verifica si el nombre que introdujo el usuario es distinto
 * de vacio ("").
 * @author: Veronica & Andreina.
 */
function verificar_nombre(){
	$valido = "";
	if(trim($_GET["nombre"]) == ""){
		$error = "Debe introducir un valor para el campo de Nombre.";
		$valido = $error;
	}
	return $valido;
}
/**
 * Funci�n que verifica si el apellido que introdujo el usuario es valido.
 *
 * Esta funci�n verifica si el apellido que introdujo el usuario es distinto
 * de vacio ("").
 * @author: Veronica & Andreina.
 */
function verificar_apellido(){
	$valido = "";
	if(trim($_GET["apellido"]) == ""){
		$error = "Debe introducir un valor para el campo de Apellido.";
		$valido = $error;
	}
	return $valido;
}
/**
 * Funci�n que verifica si el login que introdujo el usuario es valido.
 *
 * Esta funci�n verifica si el login que introdujo el usuario es distinto
 * de vacio ("").
 * @author: Veronica & Andreina.
 */
function verificar_usuario(){
	$valido = "";
	if(trim($_GET["usuario"]) == ""){
		$error = "Debe introducir un valor para el campo Usuario.";
		$valido = $error;
	}
	return $valido;
}

/**
 * Funci�n que verifica si las contrase�as que introdujo el usuario es valido.
 *
 * Esta funci�n verifica si las contrase�as que introdujo el usuario son distintas
 * de vacio ("").
 * @author: Veronica & Andreina.
 */
function verificar_contrasena(){
	$valido = "";
	if((trim($_GET["contrasena"]) == "") && (trim($_GET["contrasena_conf"]) == "") ){
	  $error = "Debe introducir un valor para la contrase�a.";
    $error = "Debe introducir un valor para la contrase�a.";
		$valido = $error;
	}
	return $valido;
}

/**
 * Funci�n que verifica si las contrase�as que coloco el usuario son iguales.
 *
 * Esta funci�n verifica si las contrase�as que coloco el usuario son iguales,
 * si las contrase�as no coinciden imprime un mensaje de error.
 * @author: Veronica & Andreina.
 */
function contrasenas_iguales(){
	$valido = "";
	if($_GET["contrasena"] != $_GET["contrasena_conf"]){
		$error = "Las contrase�as no coinciden.";
		$valido = $error;
	}
	return $valido;
	
}


/**
 * Funci�n que verifica si la contrase�as que coloco el usuario es de un tama�o aceptable.
 *
 * Esta funci�n verifica si la contrase�a que coloco el usuario tiene
 * una longitud mayor a 6 caracteres.
 * @author: Veronica & Andreina.
 */
function longitud_pwd(){
	$valido = "";
	if(strlen($_GET['contrasena'])< 6){
		$error = "La contrase�a debe tener una longitud mayor a 6 caracteres.";
		$valido = $error;
	}
	return $valido;
}
/**
 * Funci�n que verifica si el usuario selecciono un tipo de medico.
 *
 * Esta funci�n verifica si el usuario selecciono un tipo de medico.
 * @author: Veronica & Andreina.
 */
function selec_medico(){
	$valido = "";
	if($_GET["medico"] == NULL){
		$error ="Debe seleccionar un tipo de medico.";
		$valido = $error;
	}
	return $valido;
}

/**
 * Funci�n que verifica si el login del usuario es unico.
 *
 * Esta funci�n busca si existe en la BD un usuario con
 * el mismo nombre de login escrito por el usuario que se
 * quiere registrar.
 * @author: Veronica & Andreina.
 */
function unic_user(){
		
    $fbd = FachadaBD::getInstance();
    $valido = "";
    $user = strtoupper(htmlentities($_GET["usuario"], ENT_QUOTES));
    $query = "SELECT COUNT(USUARIO) FROM MEDICO WHERE USUARIO ='".$user."' ";
		    
    $conexion = $fbd->conectar("miniproyecto","m1n1pr0y3ct0");
    $results = oci_parse($conexion, $query);
    oci_execute($results);
		$row = oci_fetch_array($results,OCI_BOTH);
		if ($row[0]>0){ 
			$error = "El nombre de usuario ya existe, escriba uno diferente.";
			$valido = $error;
		}
    $fbd->desconectar($conexion);
		
		return $valido;		
}

$valido = unic_user() . selec_medico() . longitud_pwd() . verificar_nombre() .  verificar_apellido();
$valido = $valido . verificar_usuario() . verificar_contrasena() . contrasenas_iguales();

if(strcmp($valido,"")==0){
    $fbd = FachadaBD::getInstance();
    $medico = NEW Medico();
    $medico-> setCI($_GET["cedula"]);
    $medico-> setNombre($_GET["nombre"]);
    $medico-> setApellido($_GET["apellido"]);
    $medico-> setUsuario($_GET["usuario"]);
    $medico-> setContrasena($_GET["contrasena"]);
    $medico-> setFisio($_GET["medico"]);
    $fbd -> agregarUsuarioBD($medico);
	
    //iniciar sesion
    session_start();
    $_SESSION['user'] = $_GET["usuario"];
    $_SESSION['pass'] = $_GET["contrasena"];
    $_SESSION['nombre'] = $_GET["nombre"];
    $_SESSION['apellido'] = $_GET["apellido"];
    $_SESSION['esfisio'] = $_GET["medico"];
	
    header ("Location: completarRegistro.php");
} else{
    session_start();
    $n = verificar_nombre(); 
    $a = verificar_apellido();
    $c = verificar_contrasena();
    $c2 = contrasenas_iguales();
    $u = unic_user();
    $l = longitud_pwd();
    //$_SESSION['error'] = $error;
    header ("Location: registrarse.php?error1=$n&error2=$a&error3=$c&error4=$c2&error5=$u&error6=$l");
}

?>