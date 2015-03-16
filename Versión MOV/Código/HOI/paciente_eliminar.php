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
        <?php session_start(); ?>
    <body>

        <?php
        
            include_once ("fachadaBD.php");
            include_once ("Paciente.php");


            function test_input($data) {
               $data = trim($data);
               $data = stripslashes($data);
               $data = htmlspecialchars($data);
               return $data;
            }
            function verificar_campos(){
                $valido = true;
                if((trim($_POST["ci"])) == "" ){
                    $valido = false;
                }
                return $valido;
            }

            $check = true;
            $verificarCampos = true;
            $noEsta = true;
            $valido = true;

            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $verificarCampos = verificar_campos();

                if ($verificarCampos){
                    $fbd = fachadaBD::getInstance();
                    $valido = $fbd->validar_paciente($_POST["ci"]);
                    if (($row = oci_fetch_array($valido, OCI_ASSOC))) {
                        if (count($row)>0){
                            $fbd->eliminarPacienteBD($_POST["ci"]);
                            header('Location: paciente_eliminar.php');
                        }
                    }
                    
                }
            }
        
        ?>
    	<div class="container-fluid" style="height: 100%;">
    		<!-- TOPBAR -->
    		<div class="row topbar">
    			<div class="col-xs-12">
    				<!-- LOGO -->
    				<div class="col-xs-4 logo ">
    					<img src="./imagenes/logo.jpg" class="img-responsive" alt="Logo">
    				</div>
    				<!-- USER PROFILE INFORMATION -->
    				<div class="col-xs-3 pull-right user-session">    				
    					<div class="row user-info">
    						<!-- USER PHOTO -->
    						<div class="col-xs-3">
    							<img src="./imagenes/user.png" class="img-responsive" alt="Foto usuario">	
    						</div>
    						<!-- USERNAME -->
    						<div class="col-xs-9">
    							<h4><?php echo $_SESSION['NOMBRE'], " ", $_SESSION['APELLIDO'] ?></h4>
    						</div>
    					</div>
    					<!-- USER CONTEXT -->
						<div class="row">
							<div class="col-xs-12 user-context">
							</div>
						</div>
    				</div>					
    			</div>
    		</div>
    		<!-- MAIN -->
    		<div class="row main" style="height: 80%;">    			
    			<div class="row-same-height" style="height: 100%;">
    				<!-- MAIN MENU -->
	    			<div class="col-xs-2 col-xs-height col-top main-menu" >
						<ul class="list-unstyled main-menu">
							<li><a href="<?php echo "cuenta_informacion.php" ?>">Mi cuenta</a></li>
							<li class="active"><a href="<?php echo "paciente_consulta.php" ?>">Pacientes</a></li>
							<li><a href="<?php echo "efa_consulta.php" ?>">Examen Físico Articular</a></li>
							<li><a href="<?php echo "iniciar_sesion.php" ?>">Salir</a></li>
						</ul>
	    			</div>
	    			<!-- MAIN CONTENT -->
	    			<div class="col-xs-10 col-xs-height col-top main-content">
	    				<!-- SUBMENU -->
	    				<div class="row">
	    					<div class="col-xs-12 sub-menu">
								<ul class="list-inline ">
									<li><a href="<?php echo "paciente_consulta.php" ?>">Consultar</a></li>
									<li><a href="<?php echo "paciente_nuevo.php" ?>">Agregar</a></li>
                                    <li class="active"><a href="<?php echo "paciente_eliminar.php" ?>">Eliminar</a></li>
								</ul>
	    					</div>
	    				</div>
	    				<!-- CONTENT -->
	    				<div class="row">
	    					<div class="col-xs-12 content">
                                <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                    <!-- DATOS DEL PACIENTE -->
                                    <h3 class="title">Eliminar Registro de Paciente</h3>
                                    <div class="form-group">
                                        <label class="col-xs-2 control-label">Cédula</label>
                                        <div class="col-xs-10">
                                            <input type="text" class="form-control" placeholder="Cédula del paciente" name="ci">
                                        </div>
                                    </div>
                                    <?php if (!$verificarCampos): ?>
                                        <div class="alert alert-danger error" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">Error:</span>
                                            <?php echo "DEBE escribir la cédula del paciente que desea eliminar";?>
                                        </div>                            
                                    <?php endif; ?>
                                    <?php if (!$noEsta): ?>
                                        <div class="alert alert-danger error" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">Error:</span>
                                            <?php echo "Este paciente no se encuentra registrado. Intente de nuevo";?>
                                        </div>                            
                                    <?php endif; ?>
                                    <div style="text-align: center; margin-top: 30px;">
                                        <button type="submit" class="btn btn-primary">Eliminar</button>
                                        <button type="button" class="btn btn-default" onClick="document.location.href='<?php echo "paciente_nuevo.php" ?>'">Cancelar</button>
                                        </div>
                                    </div>
                                </form>  
                            </div>
	    				</div>
	    			</div>
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
