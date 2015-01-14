<?php session_start();
/**
 * Archivo que termina una sesión e informa al usuario.
 * @method session_destroy():
 * @author: Veronica, Andreina ,Daniela & Ruben
 * @version: 1.0
 * @ignore: Favor documentar de esta manera.
 */
 
 /*
  * Método que destruye la sesión de un ususario
  * @author: Veronica, Andreina.
  */
session_destroy();

echo 'Ha terminado la sesion <p><a href="index.php">index</a></p>';
?>

<SCRIPT LANGUAGE="javascript">
	location.href = "index.php";
</SCRIPT>
