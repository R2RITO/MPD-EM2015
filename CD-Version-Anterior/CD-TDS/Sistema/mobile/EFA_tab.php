<?php
/**
 * Clase para representar un examen fisico articular en la base de datos. 
 * Contiene get y set para sus atributos y la funcion agregarEFA que
 * agrega un examen fisico articular en la base de datos.
 * @property  $ID_Persona: identificador de la persona.
 * @property $ID_Historial: identificador del historial.
 * @property $Fecha_Examen: fecha enque se realizó el examen.
 * @property $Medico_Int:: medico interpretador.
 * @property $Medico_Fisio: medico fisioterapeuta.
 * @property $Peso: peso del paciente.
 * @property $Tono_Flex_Dor_Izq: tono flexor dorsal izquierdo.
 * @property $Tono_Flex_Dor_Der: tono flexor dorsal derecho.
 * @property $Carac_Marcha: tipo de marcha.
 * @method EFA_tab(): inicializa las propiedades de la clase EFA_tab.
 * @method setIDPersona($ID_Persona): asigna el valor del ID de la persona.
 * @method getIDPersona(): retorna el valor del ID de la persona.
 * @method setIDHistorial($ID_Historial): asigna el valor del ID del historial.
 * @method getIDHistorial(): retorna el valor del ID del historial.
 * @method setFechaExamen($Fecha_Examen): asigna el valor de la fecha del examen.
 * @method getFechaExamen(): retorna la fecha del examen.
 * @method setMedicoInt($Medico_Int): asigna el valor del Medico Interpretador.
 * @method getMedicoInt(): retorna el valor del Medico Interpretador.
 * @method setMedicoFisio($Medico_Fisio): asigna el valor del Medico Fisioterapeuta.
 * @method getMedicoFisio(): retorna el valor del Medico Fisioterapeuta.
 * @method setPeso($Peso): asigna el valor del peso.
 * @method getPeso(): retorna el valor del peso.
 * @method setTonoFlexDorIzq($Tono_Flex_Dor_Izq): asigna el valor del Tono Flexor Dorsal Izquierdo.
 * @method getTonoFlexDorIzq(): retorna el valor del Tono Flexor Dorsal Izquierdo.
 * @method  setTonoFlexDorDer($Tono_Flex_Dor_Der): asgina el valor del Tono Flexor Dorsal Derecho.
 * @method  getTonoFlexDorDer(): retorna el valor del Tono Flexor Dorsal Derecho.
 * @method  setCaracMarcha($Carac_Marcha): asigna el valor del tipo de marcha.
 * @method  getCaracMarcha(): retorna el valor del tipo de marcha.
 * @method  agregarHistoria(): se guarda el paciente en la tabla.
 * @author: Veronica, Andreina ,Daniela & Ruben
 * @version: 1.0
 * @ignore: Favor documentar de esta manera.
 */


include_once ("FachadaBD.php");

class EFA_tab{

	/** @property $ID_Persona: identificador de la persona.*/
    private $ID_Persona;
	/**  @property $ID_Historial: identificador del historial. */
    private $ID_Historial;	 
	/** @property $Fecha_Examen: fecha enque se realizó el examen. */
    private $Fecha_Examen;
    /** @property $Medico_Int:: medico interpretador. */
	private $Medico_Int;
    /** @property $Medico_Fisio: medico fisioterapeuta. */
	private $Medico_Fisio;
    /** @property $Peso: peso del paciente. */
	private $Peso;
    /** @property $Tono_Flex_Dor_Izq: tono flexor dorsal izquierdo. */
	private $Tono_Flex_Dor_Izq;
	/** @property $Tono_Flex_Dor_Der: tono flexor dorsal derecho. */
	private $Tono_Flex_Dor_Der;
    /** @property $Carac_Marcha: tipo de marcha. */
	private $Carac_Marcha;
   
    /**
     * Metodo que inicializa las propiedades de la clase EFA_tab.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   
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

    /**
     * Metodo que asigna el valor del ID de la persona.
	 * @param $ID_Persona: identificador de la persona. 
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   	
    public function setIDPersona($ID_Persona){
        $this->ID_Persona = $ID_Persona;
    }
    /**
     * Metodo que retorna el valor del ID de la persona.
	 * @return $this->ID_Persona: identificador de la persona. 
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   	
    public function getIDPersona(){
        return $this->ID_Persona;
    }
    /**
     * Metodo que asigna el valor del ID del historial.
	 * @param $ID_Historial: identificador del historial. 
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   	    
    public function setIDHistorial($ID_Historial){
        $this->ID_Historial = $ID_Historial;
    }
    /**
     * Metodo que retorna el valor del ID del historial.
	 * @return $this->ID_Historial: identificador del historial.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   	
    public function getIDHistorial(){
        return $this->ID_Historial;
    } 
    /**
     * Metodo que asigna el valor de la fecha del examen.
	 * @param $Fecha_Examen: fecha en que se realizo el examen.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   	      
    public function setFechaExamen($Fecha_Examen){
        $this->Fecha_Examen = $Fecha_Examen;
    }
    /**
     * Metodo que retorna el valor  de la fecha del examen.
	 * @return $this->Fecha_Examen:  fecha en que se realizo el examen.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */  
    public function getFechaExamen(){
        return $this->Fecha_Examen;
    }     
    /**
     * Metodo que asigna el valor del Medico Interpretador.
	 * @param $Medico_Int: asigna el valor del medico.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   	              
    public function setMedicoInt($Medico_Int){
        $this->Medico_Int = $Medico_Int;
    }
    /**
     * Metodo que retorna el valor  del Medico Interpretador.
	 * @return $this->Medico_Int:  retorna el valor del medico.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */  
    public function getMedicoInt(){
        return $this->Medico_Int;
    }
    /**
     * Metodo que asigna el valor del Medico Fisioterapeuta.
	 * @param $Medico_Fisio: asigna el valor del medico.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   	
    public function setMedicoFisio($Medico_Fisio){
        $this->Medico_Fisio = $Medico_Fisio;
    }
    /**
     * Metodo que retorna el valor  del Medico Fisioterapeuta.
	 * @return $this->Medico_Fisio:  retorna el valor del medico.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */  
    public function getMedicoFisio(){
        return $this->Medico_Fisio;
    }
    /**
     * Metodo que asigna el valor del Peso.
	 * @param $Peso: asigna el valor del peso.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   	
    public function setPeso($Peso){
        $this->Peso = $Peso;
    }
    /**
     * Metodo que retorna el valor  del Peso.
	 * @return $this->Peso:  retorna el valor del peso.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */  
    public function getPeso(){
        return $this->Peso;
    }
    /**
     * Metodo que asigna el valor del Tono Flexor Dorsal Izquierdo.
	 * @param $Tono_Flex_Dor_Izq: asigna el valor del Tono Flexor Dorsal Izquierdo.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   
    public function setTonoFlexDorIzq($Tono_Flex_Dor_Izq){
        $this->Tono_Flex_Dor_Izq = $Tono_Flex_Dor_Izq;
    }
    /**
     * Metodo que retorna el valor  del Tono Flexor Dorsal Izquierdo.
	 * @return $this->Tono_Flex_Dor_Izq:  retorna el valor del Tono Flexor Dorsal Izquierdo.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */  
    public function getTonoFlexDorIzq(){
        return $this->Tono_Flex_Dor_Izq;
    }
    /**
     * Metodo que asigna el valor del Tono Flexor Dorsal Derecho.
	 * @param $Tono_Flex_Dor_Der: asigna el valor del Tono Flexor Dorsal Derecho.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   
    public function setTonoFlexDorDer($Tono_Flex_Dor_Der){
        $this->Tono_Flex_Dor_Der = $Tono_Flex_Dor_Der;
    }
    /**
     * Metodo que retorna el valor  del Tono Flexor Dorsal Derecho.
	 * @return $this->Tono_Flex_Dor_Der:  retorna el valor del Tono Flexor Dorsal Derecho.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */  
    public function getTonoFlexDorDer(){
        return $this->Tono_Flex_Dor_Der;
    }
    /**
     * Metodo que asigna el valor del Tipo de Marcha.
	 * @param $Carac_Marcha: asigna el valor del Tipo de Marcha
     * @author: Veronica, Andreina, Daniela & Ruben.
     */   
    public function setCaracMarcha($Carac_Marcha){
        $this->Carac_Marcha = $Carac_Marcha;
    }
    /**
     * Metodo que retorna el valor  del Tipo de Marcha.
	 * @return $this->Carac_Marcha:  retorna el valor del Tipo de Marcha.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */  
    public function getCaracMarcha(){
        return $this->Carac_Marcha;
    }
    /**
     * Metodo que agrega un paciente a la Base de Datos
	 * @return$fbd->agregarHistoriaBD($this): success si se guardo con exito.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */  
    public function agregarHistoria() {
        $fbd = FachadaBD::getInstance();
        return $fbd->agregarHistoriaBD($this);
    }

}

?>