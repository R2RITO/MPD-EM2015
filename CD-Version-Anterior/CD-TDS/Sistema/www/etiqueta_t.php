<?php

include_once ("FachadaBD.php");

/*
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
    Clase para representar el tipo de dato CaracMarcha en la base de datos. 
    Contiene get y set para sus atributos y la funcion agregarCaracMarcha que
    agrega una preferencia de caracteristica de marcha en la base de datos.
*/

class etiqueta_t{
    
    private $dom;
    private $et1;
    private $et2;
    private $grado;

    function etiqueta_t() {
        $this->dom = null;
        $this->et1 = null;
        $this->et2 = null;
        $this->grado = null;
    }

    public function setDom($dom){
        $this->dom = $dom;
    }

    public function getDom(){
        return $this->dom;
    }
    
    public function setEt1($et1){
        $this->et1 = $et1;
    }

    public function getEt1(){
        return $this->et1;
    } 
    
    public function setEt2($et2){
        $this->et2 = $et2;
    }

    public function getEt2(){
        return $this->et2;
    }

    public function setGrado($grado){
        $this->grado = $grado;
    }

    public function getGrado(){
        return $this->grado;
    }

    public function agregarCaracMarcha() {
        $fbd = FachadaBD::getInstance();
        return $fbd->agregarCaracMarchaBD($this);
    }

}

?>