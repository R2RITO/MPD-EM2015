/*
	CASS_Definicion

	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni

*/

/* ******************* USUARIO ******************* */

/* ******************* USUARIO ******************* */

CREATE TABLE UsuarioCtx_TAB(
	nombre	VARCHAR2(50),
	CONSTRAINT PK_UsuarioCtx PRIMARY KEY (nombre)
)
/

/* DATOS DEL MEDICO */

CREATE TABLE Medico(
   ci NUMBER(10),
   nombre VARCHAR2(50),
   apellido VARCHAR2(50),
   login VARCHAR2(50),
   clave VARCHAR2(50),
   fisio NUMBER(1),
   CONSTRAINT PK_Medico PRIMARY KEY (login)
)
/

/* ******************** PACIENTE ******************* */
CREATE TABLE Paciente(
   CI NUMBER(10),
   Nombres VARCHAR2(50),
   Apellidos VARCHAR2(50),
   Profesion VARCHAR2(50),
   Lugar_Residencia VARCHAR2(50),
   Fecha_Nacimiento DATE,
   ID_Historial NUMBER(6),
   Diagnostico VARCHAR2(200),
   Intervenciones_Quir VARCHAR2(150),
   CONSTRAINT PK_PACIENTE PRIMARY KEY (CI, ID_Historial)
)
/

/* ******************* DIMENSION ******************* */

-- USER TASK ROL
CREATE TABLE DimensionCtx_TAB(
	nombre	VARCHAR2(50),
	CONSTRAINT PK_DimensionCtx PRIMARY KEY (nombre)
)
/

CREATE TABLE DependenciaCtx_TAB (
	domDifuso		VARCHAR2(50), -- Dominio difuso
	dimension 	VARCHAR2(50), -- Dimension Ej: Rol, Tareas, Lugar
	CONSTRAINT PK_DependenciaCtx PRIMARY KEY (domDifuso,dimension),
	CONSTRAINT FK_Dep_DomDifuso FOREIGN KEY (domDifuso) REFERENCES DominioDifuso_TAB,
	CONSTRAINT FK_Dep_Dimension FOREIGN KEY (dimension) REFERENCES DimensionCtx_TAB
)
/

CREATE OR REPLACE TYPE DomDimensionCtx_TYP AS OBJECT (
	dominio		VARCHAR2(50), -- Dominio: Medico, Operatorio
	dimension 	VARCHAR2(50) -- Dimension Ej: Rol, Tareas, Lugar
)
/

CREATE OR REPLACE TYPE ListaDomDimensionCtx_TYP AS TABLE OF DomDimensionCtx_TYP;
/

CREATE TABLE DomDimensionCtx_TAB (
	usuario			VARCHAR2(50),
	dimension 		DomDimensionCtx_TYP,
	CONSTRAINT PK_DomDimensionCtx PRIMARY KEY (usuario, dimension.dimension, dimension.dominio),
	CONSTRAINT FK_DomDimCtx_Usuario FOREIGN KEY (usuario) REFERENCES UsuarioCtx_TAB,
	CONSTRAINT FK_DomDimCtx_Dimension FOREIGN KEY (dimension.dimension) REFERENCES DimensionCtx_TAB
)
/

CREATE SEQUENCE CTX_ID
	MINVALUE 1
	START WITH 1
	INCREMENT BY 1
	CACHE 20;

-- Combinacion de dominios de dimensiones contextuales
CREATE OR REPLACE TYPE Contexto_TYP AS OBJECT (
	id			NUMBER(35),
	dimensiones	ListaDomDimensionCtx_TYP,
	MEMBER FUNCTION esIgual(ctx IN ListaDomDimensionCtx_TYP) RETURN BOOLEAN,
	MEMBER FUNCTION show RETURN VARCHAR2
)
/

CREATE TABLE Contexto_TAB OF Contexto_TYP (
	CONSTRAINT PK_Contexto PRIMARY KEY (id)
) NESTED TABLE dimensiones STORE AS ContextoDim_TAB;
/

/* ******************* CATÁLOGO ******************* */

CREATE TABLE CatalogoCtx_TAB (
	usuario			VARCHAR2(50),
	dominio 		VARCHAR2(50),
	etiqueta		VARCHAR2(50),
	contexto 		NUMBER(35),
	always   		NUMBER(35),
	trapezoide		Trapezoide_TYP,
	CONSTRAINT PK_CatalogoCtx PRIMARY KEY (usuario,dominio,etiqueta,contexto),
	CONSTRAINT FK_Cat_Usuario FOREIGN KEY (usuario) REFERENCES UsuarioCtx_TAB,
	CONSTRAINT FK_Cat_Dominio FOREIGN KEY (dominio) REFERENCES DominioDifuso_TAB,
	CONSTRAINT FK_Cat_Contexto FOREIGN KEY (contexto) REFERENCES Contexto_TAB
) 	
/

/* ******************* TIPOS APLICACIÓN ******************* */

CREATE OR REPLACE TYPE DomPeso AS OBJECT(
	trapezoide Trapezoide_TYP,
	CONSTRUCTOR FUNCTION DomPeso (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT,
	CONSTRUCTOR FUNCTION DomPeso (Lab IN VARCHAR2) RETURN SELF AS RESULT,
	CONSTRUCTOR FUNCTION DomPeso (Num IN NUMBER) RETURN SELF AS RESULT
)
/

/* ******************* TABLAS APLICACIÓN ******************* */

CREATE TABLE JPE_TAB (
	id  			NUMBER(10),
	nombre			VARCHAR(50), 
	altura        	NUMBER(6),
	peso 			DomPeso,
	profesion 		VARCHAR(50), 
	marcha			VARCHAR(50),
	CONSTRAINT PK_JPE PRIMARY KEY (id)
);
/