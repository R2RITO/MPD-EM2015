<!--/> 
    Arturo Voltattorni 10-10774
    Ramon Marquez      10-10849
    Esteban Oliveros   10-11252
    
    Archivo que contiene la barra superior de la pagina
<!-->

<div class="row topbar">
	<div class="col-xs-12">
		<!-- LOGO -->
		<div class="col-xs-4 logo ">
			<img src="./estilo/imagenes/logo.jpg" class="img-responsive" alt="Logo">
		</div>
		<!-- USER PROFILE INFORMATION -->
		<div class="col-xs-3 pull-right user-session">    				
			<div class="row user-info">
				<!-- USER PHOTO -->
				<div class="col-xs-3">
					<img src="./estilo/imagenes/user.png" class="img-responsive" alt="Foto usuario">	
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
