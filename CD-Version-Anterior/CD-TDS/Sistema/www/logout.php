<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que cierra la sesion de un usuario y redirecciona al inicio de sesion.
<!-->

<?php session_start();
// Borramos toda la sesion
session_destroy();
echo 'Ha terminado la session <p><a href="index.php">index</a></p>';
?>
<SCRIPT LANGUAGE="javascript">
location.href = "iniciosesion.php";
</SCRIPT>