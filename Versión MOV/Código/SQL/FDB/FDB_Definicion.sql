/*
	FDB_Definicion
	
	Definición de estructuras para dominios difusos.
	
	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni
	
	Cambios respecto a versión anterior:
	
	- Renombrar
		Fuzzy_objtyp 		---> DominioDifuso_TYP
		Trapezoid_objtyp 	---> Trapezoide_TYP 
			T_a		---> A
			T_b		---> B
			T_c		---> C
			T_d		---> D
		DT_objtyp			---> Continuo_TYP
		
	- Eliminar
		* Funciones de DominioDifuso_TYP:
			Las razones se encuentran en la implementación, ya que
			solo retornan NULL. 
			
			
	NOTA: 	Para lo indicado con * chequear que sea 
			factible la modificación
*/

CREATE OR REPLACE TYPE  DominioDifuso_TYP AS OBJECT (
   nombre 	VARCHAR2(50)
)
NOT FINAL;
/

CREATE OR REPLACE TYPE Trapezoide_TYP AS OBJECT (
	-- Se conforma de cuatro puntos
	-- A y D forman la base del trapezoide
	-- B y C forman el núcleo del trapezoide
   	A		NUMBER(12,3),
   	B		NUMBER(12,3),
   	C		NUMBER(12,3),
   	D		NUMBER(12,3),
	CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2) RETURN SELF AS RESULT,
	CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Nodo IN NUMBER) RETURN SELF AS RESULT,
	CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2, NodoA IN NUMBER, NodoB IN NUMBER, NodoC IN NUMBER, NodoD IN NUMBER) RETURN SELF AS RESULT,
	MEMBER FUNCTION FEQT (T1 IN Trapezoide_TYP) RETURN REAL,
	MEMBER FUNCTION FEQ (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2) RETURN REAL,
	MEMBER FUNCTION LSHOW(Dominio IN VARCHAR2) RETURN VARCHAR2,
	MEMBER FUNCTION SHOW RETURN VARCHAR2
);
/

CREATE OR REPLACE TYPE Continuo_TYP UNDER DominioDifuso_TYP (
   etiqueta 	VARCHAR2(50),
   trapezoide 	Trapezoide_TYP,
   CONSTRUCTOR FUNCTION Continuo_TYP (Dominio IN VARCHAR2, Lab IN VARCHAR2, NodoA IN NUMBER, NodoB IN NUMBER, NodoC IN NUMBER, NodoD IN NUMBER) RETURN SELF AS RESULT,
   CONSTRUCTOR FUNCTION Continuo_TYP (Dominio IN VARCHAR2, Lab IN VARCHAR2) RETURN SELF AS RESULT,
   CONSTRUCTOR FUNCTION Continuo_TYP (Dominio IN VARCHAR2, Num IN NUMBER) RETURN SELF AS RESULT,
   OVERRIDING MEMBER FUNCTION LSHOW (Dominio IN VARCHAR2) RETURN VARCHAR2,
   OVERRIDING MEMBER FUNCTION SHOW RETURN VARCHAR2,
   OVERRIDING MEMBER FUNCTION FEQ (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2) RETURN REAL
)
NOT FINAL;
/
