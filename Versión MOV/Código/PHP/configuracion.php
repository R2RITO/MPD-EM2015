<!--/> 
	Arturo Voltattorni 10-10774
	Ramon Marquez	   10-10849
	Esteban Oliveros   10-11252
	
	Archivo que mediante variables permite cambiar la ubicación de los archivos
	de manera rápida y sencilla.
<!-->

<?php
	
	/* DIRECCIÓN DE TRABAJO (ABSOLUTA) */
	$wd = str_replace('\\', '/', getcwd());

	/* REFERENCIAS DE INTERFAZ DE LA PÁGINA */
	$estilo =  $wd . "/estilo";
	$bootstrap = $estilo . "/bootstrap";
	$jquery = $estilo . "/jquery";
	$imagenes = $estilo . "/imagenes";
	$css = $estilo . "/css";
	$js = $estilo . "/js";

	/* REFERENCIAS DE PLANTILLAS */
	$plantilla = $wd . "/plantilla";
	$header = $plantilla . "/header.php"; // Header debe hacer referencia a configuracion.php para ser incluido en todas las páginas
	$footer = $plantilla . "/footer.php";
	$main_menu = $plantilla . "/main_menu.php";
	$topbar = $plantilla . "/topbar.php";
	$vars = $plantilla . "/variables.php";

	/* REFERENCIA DE VISTAS */
	$views = $wd . "";
	$cuenta = $views . "/cuenta.php";
	$paciente = $views . "/paciente.php";
	$efa = $views . "/efa.php";
	$init_sesion = $views . "/iniciar_sesion.php";
	$registro = $views . "/registro.php";

?>