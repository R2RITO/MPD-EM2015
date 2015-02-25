<!DOCTYPE HTML>
<!--/> 
	Arturo Voltattorni 10-10774
	Ramon Marquez	   10-10849
	Esteban Oliveros   10-11252
	
	Archivo que realiza las validaciones de usuario y contraseña. Además que sea
	usuario único.
<!-->

<?php 
 

include_once ("FachadaBD.php");
 
function quitar($mensaje)
{
    $nopermitidos = array("'",'\\','<','>',"\"");
    $mensaje = str_replace($nopermitidos, "", $mensaje);
    return $mensaje;
}

function verificar_usuario(){
    if(trim($_POST["usuario"]) == ""){
        echo "<font color='red'>**debe introducir un valor para el campo Usuario </font>";
    }
}

function verificar_contrasena(){
    if(trim($_POST["password"]) == ""){
        echo "<font color='red'>**debe introducir un valor para la contraseña </font>";
    }
}

/*  Funcion que verifica los campos ingresados en el formulario del
    ingreso del nuevo usuario.
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
                   
                header('Location: index.php');
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
						<h1><a href="#" class="mobileUI-site-name">Inicio de Sesi&oacute;n</a></h1>
						<p>Hospital Ortop&eacute;dico Infantil</p>
					</div>
				</div>
			</div>
		</header>
	</div>
	<div id="wrapper">
		<div class="5grid-layout" id="page-wrapper">
			<div class="row">
				<div class="12u">
					<section id="pbox1">
					
						<h2>Inicio de Sesi&oacute;n</h2>
						<div class="row">
							<div class="col-md-3 col-sm-6 col-md-push-4">
								<form style="text-align:center;" class="s" action="validar_usuario.php" method="post">
									Usuario: <input type="text" id="usuario" name="usuario" size="20" maxlength="20" class="form-control"/><br>
											 <?php verificar_usuario(); ?><br>
									Contrase&ntilde;a: <input type="password" id="password" name="password" size="10" maxlength="10" class="form-control" /><br>
											 <?php verificar_contrasena(); ?><br>
									<input class="button-style1" type="submit" value="Iniciar Sesion" />
								</form>
							</div>
						</div>
						
						<a href="registro.php" class="button-style1">Registrarse</a></p>
						
					</section>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php") ?>
</body>
</html>