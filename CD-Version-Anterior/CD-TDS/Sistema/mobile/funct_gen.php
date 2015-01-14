<?php

/**
 *
 * Contiene varias funciones dedicadas a buscar Tonos Flexores Dorsales.
 * @method buscarEtiquetasTFDI(): funciona para  buscar las etiquetas del tono flexor dorsal izquierdo. 
 * @method buscarDominioTFDI(): funciona para  busca los dominios del tono flexor dorsal izquierdo. 
 * @author: Veronica, Andreina ,Daniela & Ruben
 * @version: 1.0
 * @ignore: Favor documentar de esta manera.
 */
 
include_once ("FachadaBD.php");

/**
 * Función que busca las etiquetas del tono flexor dorsal izquierdo
 * almacenadas en la base de datos para presentarlas al 
 * usuario para su seleccion para la busqueda.
 *
 * @author: Andreina & Veronica.
 */
function buscarEtiquetasTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		
    echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Función que busca los dominios del tono flexor dorsal izquierdo
 * almacenados en la base de datos para presentarlos al 
 * usuario para su seleccion para la busqueda.
 * 
 * @author: Andreina & Veronica.
 */
function buscarDominioTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

$op = $_GET["code"];

if ($op->code == '1'){
   buscarEtiquetasTFDI();
}else{
   buscarDominioTFDI();   
}

?>