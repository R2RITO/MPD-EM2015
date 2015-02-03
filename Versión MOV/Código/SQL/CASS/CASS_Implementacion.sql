/*
	CASS_Implementacion
	
	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni
*/

CREATE OR REPLACE PROCEDURE agregarDependenciaCtx(Dominio IN VARCHAR2, Dimension IN VARCHAR2) AS
	BEGIN
		INSERT INTO DependenciaCtx_TAB VALUES (
																					DominioDifuso_TYP(Dominio), 
																					DimensionCtx_TYP(Dimension)
																					);
		COMMIT;
	END;
/

CREATE OR REPLACE PROCEDURE agregarDomDimensionCtx(Usuario IN VARCHAR2, Dimension IN VARCHAR2, DomDimension IN VARCHAR2) AS
	BEGIN
		INSERT INTO DomDimensionCtx_TAB VALUES (
																						UsuarioCtx_TYP(Usuario), 
																						DomDimensionCtx_TYP(
																							DomDimension,
																							DimensionCtx_TYP(Dimension)
																							)
																						);
		COMMIT;
	END;
/

CREATE OR REPLACE PROCEDURE agregarDimensionCtx(Dimension IN VARCHAR2) AS
	BEGIN
		INSERT INTO DimensionCtx_TAB VALUES (Dimension);
		COMMIT;
	END;
/


CREATE OR REPLACE PROCEDURE  definirEtiqueta(Dominio_V IN VARCHAR2, Etiqueta IN VARCHAR2, 
																		A IN NUMBER, B IN NUMBER, C IN NUMBER, D IN NUMBER,  -- Trapezoide
																		Ctxs IN ListaDomDimensionCtx_TYP, -- Contextos
																		Usuario IN VARCHAR2, -- Usuario que define la etiqueta
																		ALWAYS IN NUMBER) AS
	-- Permite filtrar los contextos que necesitamos
	-- NOTA: asumir que en Ctxs se pasan todos los contextos actuales del usuario y por ello hay que filtrarlos
	CURSOR domCtx IS
		SELECT  C.dominio dom, C.dimension.nombre dim
		FROM 	TABLE(Ctxs) C, DependenciaCtx_TAB D
		WHERE D.dominio.nombre = Dominio_V 
			AND D.dimension.nombre = C.dimension.nombre;
	--CURSOR depCtx IS
	--	SELECT D.dimension.nombre
	--	FROM DependenciaCtx_TAB D
	--	WHERE D.dominio.nombre = Dominio_V;
	
	ctx_id 	NUMBER;
	BEGIN
			--FOR i IN domCtx LOOP
			--	dbms_output.put_line('El dominio '  || Dominio_V || ' depende de '  || i.dom || ' -->' || i.dim);
			--END LOOP;
			dbms_output.put_line('FUNCIONA');
			FOR I IN domCtx LOOP
				INSERT INTO CatalogoCtx_TAB VALUES 	(	
																			UsuarioCtx_TYP(Usuario), 
																			DomDimensionCtx_TYP(i.dom, DimensionCtx_TYP(i.dim)), 
																			DominioDifuso_TYP(Dominio_V),
																			Etiqueta,
																			Trapezoide_TYP(A,B,C,D)
																			);
				dbms_output.put_line('El dominio '  || Dominio_V || ' depende de '  || i.dom || ' -->' || i.dim);
			END LOOP;		
		
	END;
/
