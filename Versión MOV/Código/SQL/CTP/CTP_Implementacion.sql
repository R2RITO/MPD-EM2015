/*
	CTP_Implementacion

	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni
*/
set serveroutput on
/* ******************* PROCESOS ******************* */

/* ******************* CAS ******************* */

CREATE OR REPLACE PROCEDURE agregarDimensionCtx(Dimension IN VARCHAR2) AS
	BEGIN
		INSERT INTO DimensionCtx_TAB VALUES (Dimension);
		COMMIT;
	END;
/

CREATE OR REPLACE PROCEDURE agregarDomDifuso(Dominio IN VARCHAR2) AS
	BEGIN
		INSERT INTO DominioDifuso_TAB VALUES (Dominio);
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

CREATE OR REPLACE PACKAGE trap AS

	TYPE ArrCtx IS TABLE OF VARCHAR(20) INDEX BY BINARY_INTEGER;

	FUNCTION crearListaDomDimCtx(listaDomCtx IN ArrCtx, listaDimCtx IN ArrCtx) RETURN ListaDomDimensionCtx_TYP;
	PROCEDURE  agregarTrapezoide(dom IN VARCHAR2, etq IN VARCHAR2,
												listaDomCtx IN ArrCtx, listaDimCtx IN ArrCtx, -- Contexto
                                                A IN NUMBER, B IN NUMBER, C IN NUMBER, D IN NUMBER,  -- Trapezoide
                                                usr IN VARCHAR2, -- Usuario que define la etiqueta
                                                alw IN NUMBER
                                               );



END trap;
/

CREATE OR REPLACE PACKAGE BODY trap AS


	FUNCTION crearListaDomDimCtx(listaDomCtx IN ArrCtx, listaDimCtx IN ArrCtx) RETURN ListaDomDimensionCtx_TYP IS
		listaContextos ListaDomDimensionCtx_TYP;
		tmp DomDimensionCtx_TYP;
		domActual VARCHAR2(20);
		dimActual VARCHAR2(20);
		i NUMBER;
	BEGIN
		listaContextos := ListaDomDimensionCtx_TYP();
		listaContextos.EXTEND(listaDomCtx.COUNT);

		i := 1;

		-- Iterar sobre ambas listas para crear el DomDimensionCtx_TYP
		-- que se tiene que agregar a listaContextos

		FOR actual in listaDomCtx.first .. listaDomCtx.last LOOP

			IF listaDomCtx(actual) IS NOT NULL THEN
				tmp := DomDimensionCtx_TYP(listaDomCtx(actual),listaDimCtx(actual));

				listaContextos(i) := tmp;
				i := i + 1;
			END IF;
		END LOOP;

		RETURN listaContextos;
	END crearListaDomDimCtx;

	PROCEDURE  agregarTrapezoide(dom IN VARCHAR2, etq IN VARCHAR2,
												listaDomCtx IN ArrCtx, listaDimCtx IN ArrCtx, -- Contexto
                                                A IN NUMBER, B IN NUMBER, C IN NUMBER, D IN NUMBER,  -- Trapezoide
                                                usr IN VARCHAR2, -- Usuario que define la etiqueta
                                                alw IN NUMBER
                                               ) IS

		listaContextos ListaDomDimensionCtx_TYP;
	BEGIN

		listaContextos := crearListaDomDimCtx(listaDomCtx, listaDimCtx);
		definirEtiqueta(dom, etq, A, B, C, D, listaContextos, usr, alw);

	END agregarTrapezoide;



END trap;
/

/* ******************* CAR ******************* */ 

CREATE OR REPLACE FUNCTION CatalogoEtiqueta(Usuario IN VARCHAR2, Dominio IN VARCHAR2, Etiqueta IN VARCHAR2, Ctxs IN ListaDomDimensionCtx_TYP) RETURN Trapezoide_TYP IS
	coincide	BOOLEAN; -- Chequeamos que la lista de contextos coincidan
	existe BOOLEAN;
	listaDomTrap ListaDomDimensionCtx_TYP;
	domContextual VARCHAR2(50);
	dimDomContextual VARCHAR2(50);
	no_etiqueta EXCEPTION;

	-- Cursor que tiene la lista de dominios de dimensiones contextuales del
	-- trapezoide a buscar
	CURSOR domCtx IS
	SELECT *
		FROM TABLE(Ctxs);

	-- Cursor con todos los trapezoides definidos por el usuario con parámetro
	-- ALWAYS en 0 con la etiqueta solicitada.
	CURSOR catCtx0 IS
	SELECT  *
		FROM    CatalogoCtx_TAB
		WHERE   usuario=Usuario AND etiqueta=Etiqueta AND dominio=Dominio AND always=0;

	-- Cursor con todos los trapezoides definidos por el usuario cuyo
	-- parámetro ALWAYS es 1 con la etiqueta solicitada.
	CURSOR catCtx1 IS
	SELECT  *
		FROM    CatalogoCtx_TAB
		WHERE   usuario=Usuario AND etiqueta=Etiqueta AND dominio=Dominio AND always=1;

	-- Cursor con todos los trapezoides definidos por el usuario por defecto,
	-- (es decir, parámetro ALWAYS en 2) con la etiqueta solicitada.
	CURSOR catCtxDefault IS
	SELECT  *
		FROM    CatalogoCtx_TAB
		WHERE   usuario='DEFAULT' AND etiqueta=Etiqueta AND dominio=Dominio AND always=2;

	CURSOR listaDomDimCtxTrap IS
	SELECT *
		FROM TABLE(listaDomTrap);



	BEGIN

	-- Buscar si algun trapezoide coincide completamente con parámetro ALWAYS en 0.
	coincide := TRUE;
	existe := FALSE;

	FOR cat IN catCtx0 LOOP

		-- Iterar sobre la lista de dominios de las dimensiones contextuales
		-- asociados al trapezoide.

		SELECT dimensiones into listaDomTrap
			FROM Contexto_TAB
			WHERE id=cat.contexto;
		
		OPEN listaDomDimCtxTrap;
		LOOP
			FETCH listaDomDimCtxTrap INTO domContextual, dimDomContextual;
			EXIT WHEN listaDomDimCtxTrap%NOTFOUND;
			FOR dom IN domCtx LOOP
				existe := existe OR (
				(dom.dimension LIKE domContextual) AND
				(dom.dominio LIKE dimDomContextual)
				);
			END LOOP;
			coincide := coincide AND existe;
			
		END LOOP;

		CLOSE listaDomDimCtxTrap;

		-- Si "coincide" es TRUE, quiere decir que es el trapezoide correcto.
		IF coincide THEN
			return cat.trapezoide;
		END IF;
		

	END LOOP;
	
	-- Buscar si hay trapezoides que coincidan con parámetro ALWAYS en 1.
	FOR cat IN catCtx1 LOOP
		return cat.trapezoide;
	END LOOP;

	-- Buscar si hay trapezoides que coincidan definidos por el usuario por defecto.
	FOR cat IN catCtxDefault LOOP
		return cat.trapezoide;
	END LOOP;

	

	DBMS_OUTPUT.PUT_LINE('return null');
	RETURN NULL;
	EXCEPTION
	WHEN no_etiqueta THEN
		raise_application_error(-20001,'*** El usuario no ha definido la etiqueta para el dominio indicado ***');

	---------------------------------------------------------------
		--SELECT  * INTO tupla
		--FROM    CatalogoCtx_TAB
		--WHERE   usuario.nombre=user AND etiqueta=Etiqueta AND dominio.nombre=Dominio;
	---------------------------------------------------------------
		--RETURN tupla.trapezoide;
		--EXCEPTION WHEN NO_DATA_FOUND THEN
	--RETURN NULL;--CA_UserDefault(D1, L1); -- Cambiar por un procedimiento que obtenga los valores por defecto
END;
/
