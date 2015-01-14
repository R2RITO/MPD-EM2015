<?php

include_once ("FachadaBD.php");

/*
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
    Clase para representar el tipo de dato D_Peso en la base de datos. 
    Contiene get y set para sus atributos y la funcion agregarPeso que
    agrega una preferencia de peso en la base de datos.
*/

class D_Peso {
    
    private $valor;
    private $Label;
    private $N1;
    private $N2;
    private $N3;
    private $N4;

    function D_Peso() {
        $this->valor = null;
        $this->Label = null;
        $this->N1 = -1;
        $this->N2 = null;
        $this->N3 = null;
        $this->N4 = null;
    }

    public function setValor($valor){
        $this->valor = $valor;
    }

    public function getValor(){
        return $this->valor;
    }
    
    public function setLabel($Label){
        $this->Label = $Label;
    }

    public function getLabel(){
        return $this->Label;
    } 
    
    public function setN1($N1){
        $this->N1 = $N1;
    }

    public function getN1(){
        return $this->N1;
    }

    public function setN2($N2){
        $this->N2 = $N2;
    }

    public function getN2(){
        return $this->N2;
    }

    public function setN3($N3){
        $this->N3 = $N3;
    }

    public function getN3(){
        return $this->N3;
    }

    public function setN4($N4){
        $this->N4 = $N4;
    }

    public function getN4(){
        return $this->N4;
    }

    public function agregarPeso() {
        $fbd = FachadaBD::getInstance();
        return $fbd->agregarPesoBD($this);
    }

}

?>