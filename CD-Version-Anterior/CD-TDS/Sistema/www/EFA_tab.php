<?php

include_once ("FachadaBD.php");

/*
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
    Clase para representar un examen fisico articular en la base de datos. 
    Contiene get y set para sus atributos y la funcion agregarEFA que
    agrega un examen fisico articular en la base de datos.
*/


class EFA_tab{

    private $ID_Persona;
    private $ID_Historial;
    private $Fecha_Examen;
    private $Medico_Int;
    private $Medico_Fisio;
    private $Peso;
    private $Tono_Flex_Dor_Izq;
    private $Tono_Flex_Dor_Der;
    private $Carac_Marcha;
    
    function EFA_tab() {
        $this->ID_Persona = null;
        $this->ID_Historial = null;
        $this->Fecha_Examen = null;
        $this->Medico_Int = null;
        $this->Medico_Fisio = null;
        $this->Peso = null;
        $this->Tono_Flex_Dor_Izq = null;
        $this->Tono_Flex_Dor_Der = null;
        $this->Carac_Marcha = null;
    }

    public function setIDPersona($ID_Persona){
        $this->ID_Persona = $ID_Persona;
    }

    public function getIDPersona(){
        return $this->ID_Persona;
    }
    
    public function setIDHistorial($ID_Historial){
        $this->ID_Historial = $ID_Historial;
    }

    public function getIDHistorial(){
        return $this->ID_Historial;
    } 
    
    public function setFechaExamen($Fecha_Examen){
        $this->Fecha_Examen = $Fecha_Examen;
    }

    public function getFechaExamen(){
        return $this->Fecha_Examen;
    }     
        
    public function setMedicoInt($Medico_Int){
        $this->Medico_Int = $Medico_Int;
    }

    public function getMedicoInt(){
        return $this->Medico_Int;
    }

    public function setMedicoFisio($Medico_Fisio){
        $this->Medico_Fisio = $Medico_Fisio;
    }

    public function getMedicoFisio(){
        return $this->Medico_Fisio;
    }

    public function setPeso($Peso){
        $this->Peso = $Peso;
    }

    public function getPeso(){
        return $this->Peso;
    }

    public function setTonoFlexDorIzq($Tono_Flex_Dor_Izq){
        $this->Tono_Flex_Dor_Izq = $Tono_Flex_Dor_Izq;
    }

    public function getTonoFlexDorIzq(){
        return $this->Tono_Flex_Dor_Izq;
    }

    public function setTonoFlexDorDer($Tono_Flex_Dor_Der){
        $this->Tono_Flex_Dor_Der = $Tono_Flex_Dor_Der;
    }

    public function getTonoFlexDorDer(){
        return $this->Tono_Flex_Dor_Der;
    }


    public function setCaracMarcha($Carac_Marcha){
        $this->Carac_Marcha = $Carac_Marcha;
    }

    public function getCaracMarcha(){
        return $this->Carac_Marcha;
    }

    public function agregarHistoria() {
        $fbd = FachadaBD::getInstance();
        return $fbd->agregarHistoriaBD($this);
    }

}

?>