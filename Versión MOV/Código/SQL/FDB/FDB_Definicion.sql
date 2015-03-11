/*
	FDB_Definicion
	
	Definición de estructuras para dominios difusos.
	
	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni
*/
CREATE TABLE DominioDifuso_TAB (
	nombre VARCHAR2(50),
	CONSTRAINT PK_DominioDifuso PRIMARY KEY (nombre)  
)
/

/* ******************* ATÓMICOS CONTINUOS ******************* */

CREATE OR REPLACE TYPE Trapezoide_TYP AS OBJECT (
	A NUMBER(12,3),
	B NUMBER(12,3),
	C NUMBER(12,3),
	D NUMBER(12,3),
	MEMBER FUNCTION FEQT (T1 IN Trapezoide_TYP) RETURN REAL,
	MEMBER FUNCTION FEQ (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2) RETURN REAL,
	MEMBER FUNCTION LSHOW(Dominio IN VARCHAR2) RETURN VARCHAR2,
	MEMBER FUNCTION SHOW RETURN VARCHAR2
)
/


CREATE OR REPLACE TYPE Continuo_TYP UNDER DominioDifuso_TYP (
	etiqueta 	VARCHAR2(50),
	trapezoide 	Trapezoide_TYP,
	MEMBER FUNCTION LSHOW (Dominio IN VARCHAR2) RETURN VARCHAR2,
	MEMBER FUNCTION SHOW RETURN VARCHAR2,
	MEMBER FUNCTION FEQ (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2) RETURN REAL
) NOT FINAL
/


/*  ATÓMICOS DISCRETOS */

/*
CREATE OR REPLACE TYPE Discreto_TYP UNDER DominioDifuso_TYP (
   valor NUMBER(4,2),
   CONSTRUCTOR FUNCTION dominio_fijo_t (dom IN VARCHAR2, et IN VARCHAR2, val IN NUMBER, grado IN NUMBER) RETURN SELF AS RESULT,
   CONSTRUCTOR FUNCTION dominio_fijo_t (val IN NUMBER) RETURN SELF AS RESULT,
   MEMBER FUNCTION FEQ (et in NUMBER) return real,
   MEMBER FUNCTION FEQ (dom in VARCHAR2, et in VARCHAR2) return real

	
)
/
*/

/* ATÓMICOS CATEGÓRICOS */

/*
CREATE OR REPLACE TYPE Categorico_TYP UNDER DominioDifuso_TYP (
   etiq VARCHAR2(50),
   CONSTRUCTOR FUNCTION etiqueta_t (dom IN VARCHAR2, et1 IN VARCHAR2, et2 IN VARCHAR2, grado IN NUMBER) RETURN SELF AS RESULT,
   CONSTRUCTOR FUNCTION etiqueta_t (et IN VARCHAR2) RETURN SELF AS RESULT,
   MEMBER FUNCTION FEQ (dom in VARCHAR2, et in VARCHAR2) return real
)
/
*/