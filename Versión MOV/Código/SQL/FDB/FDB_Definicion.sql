/*
	FDB_Definicion
	
	Definición de estructuras para dominios difusos.
	
	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni

*/

CREATE OR REPLACE TYPE DominioDifuso_TYP AS OBJECT (
	nombre VARCHAR2(50)
	-- ¿ Deberían existir los procesos
	--MEMBER FUNCTION LSHOW (Dom IN VARCHAR2) RETURN VARCHAR2,
	--MEMBER FUNCTION SHOW RETURN VARCHAR2,
	--MEMBER FUNCTION FEQ (D1 IN VARCHAR2, L1 IN VARCHAR2) RETURN REAL
	-- ?
); --? misma razon que antes

CREATE TABLE DominioDifuso_TAB OF DominioDifuso_TYP(
  CONSTRAINT PK_DominioDifuso PRIMARY KEY (nombre)  
);

/******************** ATÓMICOS CONTINUOS ********************/

CREATE OR REPLACE TYPE Trapezoide_TYP AS OBJECT (
	A NUMBER(12,3),
	B NUMBER(12,3),
	C NUMBER(12,3),
	D NUMBER(12,3),
	-- Usamos el constructor por defecto Trapezoide_TYP(A,B,C,D)
	-- ¿
	CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2) RETURN SELF AS RESULT,
	CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Valor IN NUMBER) RETURN SELF AS RESULT,
	CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2, NodoA IN NUMBER, NodoB IN NUMBER, NodoC IN NUMBER, NodoD IN NUMBER) RETURN SELF AS RESULT,
	MEMBER FUNCTION FEQT (T1 IN Trapezoide_TYP) RETURN REAL,
	-- ?
	MEMBER FUNCTION FEQ (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2) RETURN REAL,
	MEMBER FUNCTION LSHOW(Dominio IN VARCHAR2) RETURN VARCHAR2,
	MEMBER FUNCTION SHOW RETURN VARCHAR2
);

CREATE OR REPLACE TYPE Continuo_TYP UNDER DominioDifuso_TYP (
	etiqueta 	VARCHAR2(50),
	trapezoide 	Trapezoide_TYP,
	-- rangoMin
	-- rangoMax
	-- unidad
	CONSTRUCTOR FUNCTION Continuo_TYP (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2, NodoA IN NUMBER, NodoB IN NUMBER, NodoC IN NUMBER, NodoD IN NUMBER) RETURN SELF AS RESULT,
	CONSTRUCTOR FUNCTION Continuo_TYP (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2) RETURN SELF AS RESULT,
	CONSTRUCTOR FUNCTION Continuo_TYP (Dominio IN VARCHAR2, Valor IN NUMBER) RETURN SELF AS RESULT,
	-- ¿
	MEMBER FUNCTION LSHOW (Dominio IN VARCHAR2) RETURN VARCHAR2,
	MEMBER FUNCTION SHOW RETURN VARCHAR2,
	MEMBER FUNCTION FEQ (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2) RETURN REAL
	-- ?
);

-- Para primeras pruebas
-- CREATE OR REPLACE TYPE ListaContinuo_TYP IS TABLE OF Continuo_TYP;

/******************** ATÓMICOS DISCRETOS ********************/

CREATE OR REPLACE TYPE Discreto_TYP UNDER DominioDifuso_TYP (
   --valor NUMBER(4,2),
   --CONSTRUCTOR FUNCTION dominio_fijo_t (dom IN VARCHAR2, et IN VARCHAR2, val IN NUMBER, grado IN NUMBER) RETURN SELF AS RESULT,
   --CONSTRUCTOR FUNCTION dominio_fijo_t (val IN NUMBER) RETURN SELF AS RESULT,
   --MEMBER FUNCTION FEQ (et in NUMBER) return real,
   --MEMBER FUNCTION FEQ (dom in VARCHAR2, et in VARCHAR2) return real

	
);

/******************** ATÓMICOS CATEGÓRICOS ********************/

CREATE OR REPLACE TYPE Categorico_TYP UNDER DominioDifuso_TYP (
   --etiq VARCHAR2(50),
   --CONSTRUCTOR FUNCTION etiqueta_t (dom IN VARCHAR2, et1 IN VARCHAR2, et2 IN VARCHAR2, grado IN NUMBER) RETURN SELF AS RESULT,
   --CONSTRUCTOR FUNCTION etiqueta_t (et IN VARCHAR2) RETURN SELF AS RESULT,
   --MEMBER FUNCTION FEQ (dom in VARCHAR2, et in VARCHAR2) return real
);




/*
	ESTILO ANTIGUO CODIGO
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

*/

------------------------------------ TABLAS -----------------------------------------


/*
CREATE SEQUENCE Id_Dominio
    MINVALUE 1
    START WITH 1
    INCREMENT BY 1
    CACHE 20;

CREATE TABLE Domain_tab OF Fuzzy_objtyp (
  CONSTRAINT PK_Domain PRIMARY KEY (dom_name)  
);


CREATE TABLE UDLinLab_tab (
  Label       VARCHAR2(50),
  User_name   VARCHAR2(50),
  Dom_name    VARCHAR2(50),
  Trapezoid   Trapezoid_objtyp,
  CONSTRAINT  PK_LL PRIMARY KEY (Label, User_name, Dom_name),
  CONSTRAINT  FK_LL_Dom FOREIGN KEY (Dom_name) REFERENCES Domain_tab
);

-- Revisar aqui. Estas tablas no estan dando con respecto a lo que hace FachadaBD.
CREATE TABLE semejanza_fijo_etiqueta OF semejanza_fijo_etiqueta_t(
  CONSTRAINT PK_SEM_FIJO_ETIQ PRIMARY KEY (etiqueta, dominio, usuario, dom_name),
  CONSTRAINT FK_DOM_TONO FOREIGN KEY (dominio) REFERENCES D_Tono_Muscular(valor),
  CONSTRAINT FK_ETIQ_TONO FOREIGN KEY (etiqueta) REFERENCES etiqueta_Tono_Muscular(etiq),
  CONSTRAINT FK_DOMINIO_VAR FOREIGN KEY (dom_name) REFERENCES Domain_tab(dom_name),
  CONSTRAINT FK_USER FOREIGN KEY (usuario) REFERENCES Usuarios(NickName),
  CHECK (grado BETWEEN 0.00 and 1.00)
);

CREATE TABLE semejanza_etiquetas OF semejanza_etiquetas_t (
  CONSTRAINT PK_SEM_ETIQ PRIMARY KEY (etiqueta_1, etiqueta_2, usuario, dom_name),
  CONSTRAINT FK_ETIQ_1 FOREIGN KEY (etiqueta_1) REFERENCES etiqueta_carac_marcha(etiq),
  CONSTRAINT FK_ETIQ_2 FOREIGN KEY (etiqueta_2) REFERENCES etiqueta_carac_marcha(etiq),
  CONSTRAINT FK_DOMINIO_ETIQ FOREIGN KEY (dom_name) REFERENCES Domain_tab(dom_name),
  CONSTRAINT FK_USER_ETIQ FOREIGN KEY (usuario) REFERENCES Usuarios(NickName)
);

CREATE OR REPLACE PROCEDURE sem_fijo_etiq (dom_name1 VARCHAR2, usuario1 VARCHAR2, etiqueta1 VARCHAR2, dominio1 NUMBER, grado1 NUMBER)
is
	gradoviejo NUMBER;
BEGIN
	INSERT INTO semejanza_fijo_etiqueta VALUES (usuario1, dom_name1, etiqueta1, dominio1, grado1);
	EXCEPTION
	WHEN DUP_VAL_ON_INDEX THEN
		UPDATE semejanza_fijo_etiqueta SET grado = grado1 WHERE dom_name = dom_name1 AND usuario = usuario1 AND etiqueta = etiqueta1 AND dominio = dominio1;
END;
/

CREATE OR REPLACE PROCEDURE sem_etiquetas (dom_name1 VARCHAR2, usuario1 VARCHAR2, etiqueta1 VARCHAR2, etiqueta2 VARCHAR2, grado1 NUMBER)
is
	gradoviejo NUMBER;
BEGIN
	INSERT INTO semejanza_etiquetas VALUES (usuario1, dom_name1, etiqueta1, etiqueta2, grado1);
EXCEPTION
WHEN DUP_VAL_ON_INDEX THEN
	UPDATE semejanza_etiquetas SET grado = grado1 WHERE dom_name = dom_name1 AND usuario = usuario1 AND etiqueta_1 = etiqueta1 AND etiqueta_2 = etiqueta2;
END;
/
*/