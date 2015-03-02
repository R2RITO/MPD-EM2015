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
				if((trim($_POST["nombre"])) == "" | (trim($_POST["apellido"]) == "") | 
					(trim($_POST["ci"]) == "") | (trim($_POST["profesion"]) == "") | 
					(trim($_POST["residencia"]) == "") | (trim($_POST["nacimiento"]) == "") | 
					(trim($_POST["diagnostico"]) == "") | (trim($_POST["operaciones"]) == "") |
					(trim($_POST["historial"]) == "")){
					$valido = false;
				}
				return $valido;
			}

            $check = true;
			$valido = true;

			
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$valido = verificar_campos();
				if ($valido){
					$fbd = fachadaBD::getInstance();
					$paciente = new Paciente();
					$paciente->setNombres($_POST["nombre"]);
					$paciente->setApellidos($_POST["apellido"]);
					$paciente->setCI($_POST["ci"]);
					$paciente->setProfesion($_POST["profesion"]);
					$paciente->setLugarRes($_POST["residencia"]);
					$paciente->setFechaNac($_POST["nacimiento"]);
					$paciente->setDiagnostico($_POST["diagnostico"]);
					$paciente->setInterQuir($_POST["operaciones"]);
					$paciente->setID_Historial($_POST["historial"]);

					$fbd->agregarPacienteBD($paciente);
	
					header('Location: paciente_nuevo.php');

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
									<li class="active"><a href="<?php echo "paciente_nuevo.php" ?>">Agregar</a></li>
                                    <li><a href="<?php echo "paciente_eliminar.php" ?>">Eliminar</a></li>
								</ul>
	    					</div>
	    				</div>
	    				<!-- CONTENT -->
	    				<div class="row">
	    					<div class="col-xs-12 content">
								<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
									<!-- DATOS DEL PACIENTE -->
									<h3 class="title">Datos del Paciente</h3>
									<div class="form-group">
										<label class="col-xs-2 control-label">Nombres</label>
										<div class="col-xs-10">
											<input type="text" class="form-control" placeholder="Nombres del usuario" name="nombre">
										</div>
									</div>
									<div class="form-group">
										<label class="col-xs-2 control-label">Apellidos</label>
										<div class="col-xs-10">
											<input type="text" class="form-control" placeholder="Apellidos del usuario" name="apellido" >
										</div>
									</div>
									<div class="form-group">
										<label class="col-xs-2 control-label">CI</label>
										<div class="col-xs-10">
											<input type="text" class="form-control" placeholder="Cédula de identidad del paciente" name="ci" >
										</div>
									</div>
									
									<!-- DATOS PROFESIONALES Y DE RESIDENCIA -->
									<h3 class="title">Datos de Profesión y Residencia</h3>
									<div class="form-group">
										<label class="col-xs-2 control-label">Profesión</label>
										<div class="col-xs-10">
											<input type="text" class="form-control" placeholder="Profesión actual del paciente" name="profesion">
										</div>
									</div>
									<div class="form-group">
										<label class="col-xs-2 control-label">Lugar de Residencia</label>
										<div class="col-xs-10">
											<input type="text" class="form-control" placeholder="Lugar de residencia del paciente" name="residencia">
										</div>
									</div>
									<div class="form-group">
										<label class="col-xs-2 control-label">Fecha de Nacimiento</label>
										<div class="col-xs-10">
											<input type="text" class="form-control" placeholder="Fecha de nacimiento del paciente (AAAA-MM-DD)" name="nacimiento">
										</div>
									</div>
									
									<!-- DATOS DEL HISTORIAL -->
									<h3 class="title">Datos del historial del Paciente</h3>
									<div class="form-group">
										<label class="col-xs-2 control-label">ID Historial</label>
										<div class="col-xs-10">
											<input type="text" class="form-control" placeholder="ID del historial del paciente" name="historial">
										</div>
									</div>
									<div class="form-group">
										<label class="col-xs-2 control-label">Diagnóstico inicial</label>
										<div class="col-xs-10">
											<input type="text" class="form-control" placeholder="Diagnóstico inicial del paciente" name="diagnostico">
										</div>
									</div>
									<div class="form-group">
										<label class="col-xs-2 control-label">Intervenciones quirúrgicas</label>
										<div class="col-xs-10">
											<input type="text" class="form-control" placeholder="Intervenciones quirúrgicas del paciente" name="operaciones">
										</div>
									</div>
									<?php if (!$valido): ?>
										<div class="alert alert-danger error" role="alert">
											<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
											<span class="sr-only">Error:</span>
											<?php echo "TODOS los campos son obligatorios";?>
										</div>                            
									<?php endif; ?>
									<div style="text-align: center; margin-top: 30px;">
										<button type="submit" class="btn btn-primary">Agregar</button>
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
