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
									<li class="active"><a href="<?php echo "paciente_nuevo.php" ?>">Agregar</a></li>
                                    <li><a href="<?php echo "paciente_eliminar.php" ?>">Eliminar</a></li>
								</ul>
	    					</div>
	    				</div>
	    				<!-- CONTENT -->
	    				<div class="row">
	    					<div class="col-xs-12 content">
	    						<h3 class="title">Datos del paciente</h3>							
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
