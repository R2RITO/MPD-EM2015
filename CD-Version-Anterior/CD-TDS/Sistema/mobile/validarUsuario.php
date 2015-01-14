<?php session_start();
 

include_once ("FachadaBD.php");
 

/**
 * Quita los caracteres no permitidos.
 */
function quitar($mensaje)
{
    $nopermitidos = array("'",'\\','<','>',"\"");
    $mensaje = str_replace($nopermitidos, "", $mensaje);
    return $mensaje;
}

/**
 * Revisa si el usuario es distinto a vacio.
 */
function verificar_usuario(){
    if(trim($_POST["usuario"]) == ""){
        echo "**debe introducir un valor para el campo Usuario";
    }
}
/**
 * Revisa si la contraseña es distinto a vacio.
 */
function verificar_contrasena(){
    if(trim($_POST["password"]) == ""){
        echo "**debe introducir un valor para la contrasena";
    }
}

/**  
 * Funcion que verifica los campos ingresados en el formulario del ingreso del nuevo usuario.
 * @author: Veronica, Andreina.
 */
function usuario_unico(){
    $fbd = FachadaBD::getInstance();
    $usuario = strtoupper(htmlentities($_POST["usuario"], ENT_QUOTES));
    $password = $_POST["password"];

    if(trim($_POST["usuario"]) != ""){
        $valido = $fbd->validarUsuarioBD($usuario);

        if (($row = oci_fetch_array($valido, OCI_BOTH))) {
            if($row[0] == $password){
                $_SESSION['user'] = $row[1];
                $_SESSION['pass'] = $row[0];
                $_SESSION['nombre'] = $row[2];
                $_SESSION['apellido'] = $row[3];
                $_SESSION['esfisio'] = $row[4];
                   
                header('Location: perfil.php');
                exit;
            } else {
                echo 'Password incorrecto';
            }
        } else{
           // header('Location: iniciosesion.php');
            echo 'El usuario no existe';
        }    
    }   
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Laboratorio</title>
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
	
	<div class="encabezado">
		<img width="60" height="65" src="./img/h.png" />
		<a id="reg" href="registrarse.php">Registrarse</a>
	</div>
        <div>
		<p class="titulo">Hospital Ortopédico Infantil</p>
	</div>
	
	<!-- solumns ================================================== -->
<div class="row">
  <div class="col-xs-12 col-md-7 trans">	
	  
	  <form role="form" action="validarUsuario.php" method="post">
		  <div class="form-group">
			<label for="exampleInputEmail1">Usuario</label>
			<input type="usuario" class="form-control" id="usuario"  name="usuario" placeholder="Usuario">
			<?php verificar_usuario(); ?>
		  </div>
		  <div class="form-group">
			<label for="exampleInputPassword1">Contraseña</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" size="16" maxlength="16" >
			<?php verificar_contrasena(); ?>
		  </div>
		  <?php usuario_unico(); ?>
		  <button type="submit" class="btn btn-warning btn-block" id="login" class="boton">Ingresar</button>
	  </form>
	  

  </div>

</div>
<!-- END Colums ================================================== -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-1.10.2.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
