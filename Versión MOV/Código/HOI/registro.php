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
			include_once ("medico.php");

            function test_input($data) {
               $data = trim($data);
               $data = stripslashes($data);
               $data = htmlspecialchars($data);
               return $data;
            }
			
			$nombreErr = $apellidoErr = $claveErr = $clave2Err = "";
			$ciErr = $loginErr = $tipoErr = "";
			$coincideErr = $coincide = "";
            $usuario = $clave = $clave2 = "";
			$nombreUsu = $apellidoUsu= "";
			$ciUsu = $loginUsu = $tipoUsu = "";
			
            $check = true;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["nombre"])) {
                    $nombreErr = "Ingrese su(s) nombre(s)";
                    $check = false;
                } else {
                    $nombreUsu = test_input($_POST["nombre"]);
                }   

				if (empty($_POST["apellido"])) {
                    $apellidoErr = "Ingrese su(s) apellido(s)";
                    $check = false;
                } else {
                    $apellidoUsu = test_input($_POST["apellido"]);
                }		

				if (empty($_POST["ci"])) {
                    $ciErr = "Ingrese su cédula de identidad";
                    $check = false;
                } else {
                    $ciUsu = test_input($_POST["ci"]);
                }
				
				if (empty($_POST["login"])) {
                    $loginErr = "Ingrese un nombre de usuario";
                    $check = false;
                } else {
                    $loginUsu = test_input($_POST["login"]);
                }

                if (empty($_POST["clave"])) {
                    $claveErr = "Ingrese la contraseña";
                    $check = false;
                } else {
                    $clave = test_input($_POST["clave"]);
                }  

				if (empty($_POST["clave2"])) {
                    $clave2Err = "Repita la contraseña";
                    $check = false;
                } else {
                    $clave2 = test_input($_POST["clave2"]);
                }   
				
				if (empty($_POST["tipo"])) {
                    $tipoErr = "Indique un tipo de usuario";
                    $check = false;
                } else {
                    $tipoUsu = test_input($_POST["tipo"]);
                }  
				
				if ($_POST["clave"]!=$_POST["clave2"]){
					$coincideErr = "Las contraseñas no coinciden";
					$check = false;
				}
				
				if ($check){
					$fbd = fachadaBD::getInstance();
					$medico = NEW Medico();
					$medico-> setCI($_POST["ci"]);
					$medico-> setNombres($_POST["nombre"]);
					$medico-> setApellidos($_POST["apellido"]);
					$medico-> setUsuario($_POST["login"]);
					$medico-> setContrasena($_POST["clave"]);
					$medico-> setFisio($_POST["tipo"]);
					$fbd -> agregarUsuarioBD($medico);
	
					//iniciar sesion
					$usuarioDB = strtoupper(htmlentities($loginUsu, ENT_QUOTES));
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
					}

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
    		<div class="row main" style="height: 90%;">    			
                <div class="col-xs-6 col-xs-push-3 registro">

                    <h3 class="title" style="text-align: center;">Registro</h3>
                    <!-- REGISTRARSE -->
                    <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Nombres</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" placeholder="Nombres del usuario" name="nombre" value="<?php echo $nombreUsu;?>" autofocus>
								<?php if (!empty($nombreErr)): ?>
									<div class="alert alert-danger error" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">Error:</span>
										<?php echo $nombreErr;?>
									</div>                            
								<?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Apellidos</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" placeholder="Apellidos del usuario" name="apellido" value="<?php echo $apellidoUsu;?>" autofocus>
								<?php if (!empty($apellidoErr)): ?>
									<div class="alert alert-danger error" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">Error:</span>
										<?php echo $apellidoErr;?>
									</div>                            
								<?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">CI</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" placeholder="Cédula de identidad del usuario" name="ci" value="<?php echo $ciUsu;?>" autofocus>
								<?php if (!empty($ciErr)): ?>
									<div class="alert alert-danger error" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">Error:</span>
										<?php echo $ciErr;?>
									</div>                            
								<?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Login</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" placeholder="Login de usuario" name="login" value="<?php echo $loginUsu;?>" autofocus>
								<?php if (!empty($loginErr)): ?>
									<div class="alert alert-danger error" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">Error:</span>
										<?php echo $loginErr;?>
									</div>                            
								<?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Contraseña</label>
                            <div class="col-xs-10">
                                <input type="password" class="form-control" placeholder="Ingresar contraseña" name="clave" value="<?php echo $clave;?>" autofocus>
								<?php if (!empty($claveErr)): ?>
									<div class="alert alert-danger error" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">Error:</span>
										<?php echo $claveErr;?>
									</div>                            
								<?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Repetir contraseña</label>
                            <div class="col-xs-10">
                                <input type="password" class="form-control" placeholder="Repetir contraseña" name="clave2" value="<?php echo $clave2;?>" autofocus>
								<?php if (!empty($clave2Err)): ?>
									<div class="alert alert-danger error" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">Error:</span>
										<?php echo $clave2Err;?>
									</div>                            
								<?php endif; ?>
								
								<?php if (!empty($coincideErr)): ?>
									<div class="alert alert-danger error" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">Error:</span>
										<?php echo $coincideErr;?>
									</div>                            
								<?php endif; ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Tipo de usuario</label>
                            <div class="col-xs-10">
                                <div class="radio-inline">
                                    <label>
                                    <input type="radio" name="tipo" value=1>
                                        Fisioterapeuta
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                    <input type="radio" name="tipo" value=2>
                                        Interpretador
                                    </label>
                                </div>
								<?php if (!empty($tipoErr)): ?>
									<div class="alert alert-danger error" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<span class="sr-only">Error:</span>
										<?php echo $tipoErr;?>
									</div>                            
								<?php endif; ?>
                            </div>
                        </div>
                        <div style="text-align: center; margin-top: 30px;">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <button type="button" class="btn btn-default" onClick="document.location.href='<?php echo "iniciar_sesion.php" ?>'">Cancelar</button>
                            </div>
                        </div>
                    </form>                    
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
