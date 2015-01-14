<?php

include_once ("FachadaBD.php");

/*
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
    Clase para representar el tipo de dato de tipo Tono Flexor Dorsal en la base de datos. 
    Contiene get y set para sus atributos y la funcion agregarTonoFlexDor que
    agrega una preferencia de algun tipo de Tono Flexor Dorsal en la base de datos.
*/

class dominio_fijo_t{
    
    private $dom;
    private $et;
    private $val;
    private $grado;

    function dominio_fijo_t() {
        $this->dom = null;
        $this->et = null;
        $this->val = null;
        $this->grado = null;
    }

    public function setDom($dom){
        $this->dom = $dom;
    }

    public function getDom(){
        return $this->dom;
    }
    
    public function setEt($et){
        $this->et = $et;
    }

    public function getEt(){
        return $this->et;
    } 
    
    public function setVal($val){
        $this->val = $val;
    }

    public function getVal(){
        return $this->val;
    }

    public function setGrado($grado){
        $this->grado = $grado;
    }

    public function getGrado(){
        return $this->grado;
    }

    public function agregarTonoFlexDor() {
        $fbd = FachadaBD::getInstance();
        return $fbd->agregarTonoFlexDorBD($this);
    }

}

?>