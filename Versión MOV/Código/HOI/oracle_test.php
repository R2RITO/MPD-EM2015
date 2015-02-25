<? php
?>

<html>
<head>
<title>Writing PHP Function</title>
</head>
<body>

<?php

$conn = oci_connect('system', 'ejof', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, 'SELECT * FROM MEDICO');
oci_execute($stid);


while ( oci_fetch($stid) ) {
    // Usar nombres de columna en mayúsculas para los índices del array asociativo
   $name = oci_result($stid, "LOGIN");
   echo $name, "</br>";
}
oci_free_statement($stid);
oci_close($conn);

?>
</body>
</html>