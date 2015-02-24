<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Plantilla</title>
        <meta name="description" content="Plantilla para Hospital Ortopédico Infantil">
        <meta name="author" content="MOV">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">

        <!-- JQUERY -->
		<script type="text/javascript" src="./jquery/jquery-2.1.3.min.js"></script>

		<!-- BOOTSTRAP -->
        <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css"/>
        <script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>

        <!-- STYLE -->
        <link rel="stylesheet" type="text/css" href="./css/basico.css"/>    </head>
    <body>

        <?php
            include_once ("fachadaBD.php");

            function test_input($data) {
               $data = trim($data);
               $data = stripslashes($data);
               $data = htmlspecialchars($data);
               return $data;
            }

            $usuarioErr = $claveErr = "";
            $usuario = $clave = "";
            $check = true;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["usuario"])) {
                    $usuarioErr = "Ingrese el nombre de usuario";
                    $check = false;
                } else {
                    $usuario = test_input($_POST["usuario"]);
                }                

                if (empty($_POST["clave"])) {
                    $claveErr = "Ingrese la contraseña";
                    $check = false;
                } else {
                    $clave = test_input($_POST["clave"]);
                }                
            }
            
            // Si se ingresaron datos en ambos campos chequeamos que el usuario exista
            if ($check and ($usuario != "")){
                $fbd = fachadaBD::getInstance();
                $usuarioDB = strtoupper(htmlentities($usuario, ENT_QUOTES));
                $valido = $fbd->validar_usuario($usuarioDB);
                if (($row = oci_fetch_array($valido, OCI_ASSOC))) {
                    if($row['CLAVE'] == $clave){
                        $_SESSION['USERNAME'] = $row['LOGIN'];
                        $_SESSION['NOMBRE'] = $row['NOMBRE'];
                        $_SESSION['APELLIDO'] = $row['APELLIDO'];
                        $_SESSION['CI'] = $row['CI'];
                        $_SESSION['FISIO'] = $row['FISIO'];
                        header('Location: home.php');                        
                        exit;
                    } else {
                        $claveErr = "Contraseña incorrecta";
                    }
                } else{
                    $usuarioErr = "Este usuario no existe";
                }                    
            }
        ?>        
    	<div class="container-fluid" style="height: 100%;">
    		<!-- TOPBAR -->
    		<div class="row">
    			<div class="col-xs-4 col-xs-push-4">
                    <img src="./imagenes/logo.jpg" class="img-responsive" alt="Logo">
                </div>
    		</div>            
    		<!-- MAIN -->
    		<div class="row main" style="height: 80%;">    			
                <div class="col-xs-4 col-xs-push-4 iniciar-sesion">

                    <h3 class="title">Inicio de sesión</h3>
                    <!-- INICIAR SESION -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="form-group">
                            <label >Usuario</label>
                            <input type="text" class="form-control" placeholder="Nombre de usuario" name="usuario" value="<?php echo $usuario;?>" autofocus>
                            <?php if (!empty($usuarioErr)): ?>
                                <div class="alert alert-danger error" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span>
                                    <?php echo $usuarioErr;?>
                                </div>                            
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label >Contraseña</label>
                            <input type="password" class="form-control" placeholder="Clave de usuario" name="clave" >
                            <?php if (!empty($claveErr)): ?>
                                <div class="alert alert-danger error" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span>
                                    <?php echo $claveErr;?>
                                </div>                            
                            <?php endif; ?>
                        </div>                        
                        <button type="submit" class="btn btn-primary" name="submit">Iniciar sesión</button>
                    </form>                    
                    <button type="button" class="btn btn-default" style="margin-top: 50px;">Registrarse</button>
                </div>
			</div>
    		<!-- FOOTER -->
    		<div class="row footer">
    			<div class="col-xs-12 " style="">
                    <p>© Laboratorio de Marcha | Hospital Ortopédico Infantil </p>
                </div>
    		</div>
    	</div>
    </body>
</html>
