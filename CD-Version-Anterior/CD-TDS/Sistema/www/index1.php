<?php
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
if ($iphone || $android || $palmpre || $ipod || $berry == true)
{
header('Location:http://localhost/html5/movil/index.html'); //URL de la interfaz para m?vil
echo "<script>window.location='http://localhost/html5/movil/index.html'</script>"; //URL de la interfaz para m?vil
}
else
{
header('Location: http://localhost/html5/index.html'); //URL original
echo "<script>window.location='http://localhost/html5/index.html'</script>"; //URL original
}
?>