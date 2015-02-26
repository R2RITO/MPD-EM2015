<!DOCTYPE html>
<html lang="es">
    <?php include("./plantilla/header.php")?>
    <body>

        <?php
            include_once ("fachadaBD.php");

            function test_input($data) {
               $data = trim($data);
               $data = stripslashes($data);
               $data = htmlspecialchars($data);
               return $data;
            }

        ?>        
    	<div class="container-fluid" style="height: 100%;">
    		<!-- TOPBAR -->
    		<div class="row">
    			<div class="col-xs-4 col-xs-push-4">
                    <img src="./estilo/imagenes/logo.jpg" class="img-responsive" alt="Logo">
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
                                <input type="text" class="form-control" placeholder="Nombres del usuario" name="nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Apellidos</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" placeholder="Apellidos del usuario" name="apellido">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">CI</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" placeholder="Cédula de identidad del usuario" name="ci">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Login</label>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" placeholder="Login de usuario" name="login">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Contraseña</label>
                            <div class="col-xs-10">
                                <input type="password" class="form-control" placeholder="Ingresar contraseña" name="clave">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Repetir contraseña</label>
                            <div class="col-xs-10">
                                <input type="password" class="form-control" placeholder="Repetir contraseña" name="clave2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-2 control-label">Tipo de usuario</label>
                            <div class="col-xs-10">
                                <div class="radio-inline">
                                    <label>
                                    <input type="radio" name="tipo" value=1>
                                        Fisioterapeura
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                    <input type="radio" name="tipo" value=2>
                                        Interpretador
                                    </label>
                                </div>
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
            <?php include("./plantilla/footer.php")?>       
    	</div>
    </body>
</html>
