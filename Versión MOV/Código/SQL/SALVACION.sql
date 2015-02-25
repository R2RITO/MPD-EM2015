-- MINIPROYECTO ESTEBAN STYLE 
set serveroutput on
/* ******************* DOMINIO DIFUSO ******************* */

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

/* ******************* USUARIO ******************* */

CREATE TABLE UsuarioCtx_TAB(
	nombre	VARCHAR2(50),
	CONSTRAINT PK_UsuarioCtx PRIMARY KEY (nombre)
)
/

/* DATOS DEL MEDICO */

CREATE OR REPLACE TABLE Medico(
   ci NUMBER(10),
   nombre VARCHAR2(50),
   apellido VARCHAR2(50),
   login VARCHAR2(50),
   clave VARCHAR2(50),
   fisio NUMBER(1),
   CONSTRAINT PK_Medico PRIMARY KEY (login)

);
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

CREATE OR REPLACE TYPE BODY Contexto_TYP AS 
	MEMBER FUNCTION esIgual(ctx IN ListaDomDimensionCtx_TYP) RETURN BOOLEAN IS
		CURSOR contextosA IS
			SELECT *
			FROM TABLE(ctx);
		CURSOR contextosB IS
			SELECT *
			FROM TABLE(SELF.dimensiones);		
		coincide	BOOLEAN; 
		existe 		BOOLEAN;			
		BEGIN
			coincide := TRUE;			
			existe := FALSE;
			
			FOR a IN contextosA LOOP
				existe := FALSE;
				FOR b IN contextosB LOOP
					existe := existe OR ((a.dominio = b.dominio) AND (a.dimension = b.dimension));
				END LOOP;
				coincide := coincide AND existe;
			END LOOP;

			FOR b IN contextosB LOOP
				existe := FALSE;
				FOR a IN contextosA LOOP
					existe := existe OR ((a.dominio = b.dominio) AND (a.dimension = b.dimension));
				END LOOP;
				coincide := coincide AND existe;
			END LOOP;
			
			RETURN coincide;
		END;
	MEMBER FUNCTION show RETURN VARCHAR2 IS
		CURSOR contextos IS
			SELECT *
			FROM TABLE(SELF.dimensiones);		
		BEGIN
			FOR a IN contextos LOOP
				DBMS_OUTPUT.PUT_LINE('------->' || a.dominio || ' ' || a.dimension);
			END LOOP;
			RETURN NULL;
		END;
END;
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

/* ******************* PROCESOS ******************* */

/* ******************* CAS ******************* */

CREATE OR REPLACE PROCEDURE agregarDimensionCtx(Dimension IN VARCHAR2) AS
	BEGIN
		INSERT INTO DimensionCtx_TAB VALUES (Dimension);
		COMMIT;
	END;
/

CREATE OR REPLACE PROCEDURE agregarDependenciaCtx(Dominio IN VARCHAR2, Dimension IN VARCHAR2) AS
	BEGIN
		INSERT INTO DependenciaCtx_TAB VALUES ( Dominio, Dimension );
		COMMIT;
	END;
/

CREATE OR REPLACE PROCEDURE agregarDomDimensionCtx(Usuario IN VARCHAR2, Dimension IN VARCHAR2, DomDimension IN VARCHAR2) AS
	BEGIN
		INSERT INTO DomDimensionCtx_TAB VALUES ( Usuario, DomDimensionCtx_TYP(DomDimension, Dimension));
		COMMIT;
	END;
/

CREATE OR REPLACE PROCEDURE  definirEtiqueta(var_dominio IN VARCHAR2, etiqueta IN VARCHAR2, 
																		A IN NUMBER, B IN NUMBER, C IN NUMBER, D IN NUMBER,  -- Trapezoide
																		ctxs IN ListaDomDimensionCtx_TYP, -- Contextos
																		usuario IN VARCHAR2, -- Usuario que define la etiqueta
																		ALWAYS IN NUMBER) AS
	-- Permite filtrar los que necesitamos
	-- NOTA: asumir que en Ctxs se pasan todos los contextos actuales del usuario y por ello hay que filtrarlos, no completarlos
	CURSOR domCtx IS
		SELECT  ctx.dominio dom, ctx.dimension dim
		FROM 	TABLE(ctxs) ctx, DependenciaCtx_TAB dep
		WHERE dep.domDifuso = var_dominio 
			AND dep.dimension = ctx.dimension;
	CURSOR grpCtx IS
		SELECT ctx.dimensiones dims
		FROM Contexto_TAB ctx, CatalogoCtx_TAB cat
		WHERE ctx.id = cat.contexto
			AND cat.dominio = var_dominio
			AND cat.usuario = usuario
			AND cat.etiqueta = etiqueta;
	CURSOR grpCtx_def IS
		SELECT ctx.dimensiones dims
		FROM Contexto_TAB ctx, CatalogoCtx_TAB cat
		WHERE ctx.id = cat.contexto
			AND cat.dominio = var_dominio
			AND cat.usuario = 'DEFAULT'
			AND cat.etiqueta = etiqueta;
		
	list ListaDomDimensionCtx_TYP;
	k NUMBER;
	x Contexto_TYP;
	y Contexto_TYP;
	existe BOOLEAN;
	aux VARCHAR2(30000);
	BEGIN
			existe := FALSE;
			k := 1;
			list := ListaDomDimensionCtx_TYP();
		IF (ALWAYS = 0) THEN
			-- Importa para este contexto
			FOR i IN domCtx LOOP
				list.EXTEND;
				list(k) := DomDimensionCtx_TYP(i.dom, i.dim);
				k := k + 1;
			END LOOP;
			x := Contexto_TYP(1,list);
			FOR i IN grpCtx LOOP
				existe := existe OR x.esIgual(i.dims);
			END LOOP;
			
			IF (existe) THEN
				DBMS_OUTPUT.PUT_LINE('ESTA REPETIDO!!!'); -- Podriamos realizar una sustitucion del trapezoide
			ELSE
				k := CTX_ID.NEXTVAL;
				INSERT INTO Contexto_TAB VALUES (k, list);
				INSERT INTO CatalogoCtx_TAB VALUES (usuario, var_dominio, etiqueta, k, 0, Trapezoide_TYP(A,B,C,D));
			END IF;
			
		ELSIF (ALWAYS = 1) THEN
			-- Importa para el contexto por defecto del usuario
			FOR i IN domCtx LOOP
				list.EXTEND;
				list(k) := DomDimensionCtx_TYP('DEFAULT', i.dim);
				k := k + 1;
			END LOOP;		
			k := CTX_ID.NEXTVAL;
			INSERT INTO Contexto_TAB VALUES (k, list);
			INSERT INTO CatalogoCtx_TAB VALUES (usuario, var_dominio, etiqueta, k, 1, Trapezoide_TYP(A,B,C,D));

		ELSIF (ALWAYS = 2) THEN
			-- Importa para el contexto por defecto de cualquier usuario
			FOR i IN domCtx LOOP
				list.EXTEND;
				list(k) := DomDimensionCtx_TYP('DEFAULT', i.dim);
				k := k + 1;
			END LOOP;

			x := Contexto_TYP(1,list);
			FOR i IN grpCtx_def LOOP
				existe := existe OR x.esIgual(i.dims);
			END LOOP;
			
			IF (existe) THEN
				DBMS_OUTPUT.PUT_LINE('ESTA REPETIDO!!!'); -- Podriamos realizar una sustitucion del trapezoide
			ELSE
				k := CTX_ID.NEXTVAL;
				INSERT INTO Contexto_TAB VALUES (k, list);
				INSERT INTO CatalogoCtx_TAB VALUES ('DEFAULT', var_dominio, etiqueta, k, 2, Trapezoide_TYP(A,B,C,D));
			END IF;		
			RETURN;
		END IF;
		

	END;
/
