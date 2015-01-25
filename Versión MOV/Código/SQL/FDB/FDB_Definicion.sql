/*
	FDB_Definicion
	
	Definición de estructuras para dominios difusos.
	
	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni

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


-- Segun original, esto corresponde a los dominios discretos

CREATE OR REPLACE TYPE dominio_t AS OBJECT(
   codigo NUMBER(4)
) NOT INSTANTIABLE NOT FINAL;
/

CREATE OR REPLACE TYPE dominio_fijo_t UNDER dominio_t(
   valor NUMBER(4,2),
   CONSTRUCTOR FUNCTION dominio_fijo_t (dom IN VARCHAR2, et IN VARCHAR2, val IN NUMBER, grado IN NUMBER) RETURN SELF AS RESULT,
   CONSTRUCTOR FUNCTION dominio_fijo_t (val IN NUMBER) RETURN SELF AS RESULT,
   MEMBER FUNCTION FEQ (et in NUMBER) return real,
   MEMBER FUNCTION FEQ (dom in VARCHAR2, et in VARCHAR2) return real
);
/

CREATE OR REPLACE TYPE etiqueta_t UNDER dominio_t(
   etiq VARCHAR2(50),
   CONSTRUCTOR FUNCTION etiqueta_t (dom IN VARCHAR2, et1 IN VARCHAR2, et2 IN VARCHAR2, grado IN NUMBER) RETURN SELF AS RESULT,
   CONSTRUCTOR FUNCTION etiqueta_t (et IN VARCHAR2) RETURN SELF AS RESULT,
   MEMBER FUNCTION FEQ (dom in VARCHAR2, et in VARCHAR2) return real
);
/

-- Según original no se indica a que corresponde. Sospecho que a los dominios categoricos
CREATE OR REPLACE TYPE semejanza_fijo_etiqueta_t AS OBJECT(
   usuario VARCHAR2(50),
   dom_name VARCHAR2(50),
   etiqueta VARCHAR(50),
   dominio NUMBER(4,2),
   grado NUMBER(4,2)
);
/

CREATE OR REPLACE TYPE dispositivos_usados_t AS OBJECT(
   paciente NUMBER(10),
   ID_Historial NUMBER(10),
   dispositivo VARCHAR2(50),
   grado NUMBER(4,2)
);
/


CREATE OR REPLACE TYPE semejanza_etiquetas_t AS OBJECT(
   usuario VARCHAR2(50),
   dom_name VARCHAR2(50),
   etiqueta_1 VARCHAR2(50),
   etiqueta_2 VARCHAR2(50),
   grado NUMBER(4,2)
);
/

