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

CREATE OR REPLACE PROCEDURE  definirEtiqueta(Dominio IN VARCHAR2, Etiqueta IN VARCHAR2, 
																					A IN NUMBER, B IN NUMBER, C IN NUMBER, D IN NUMBER,  -- Trapezoide
																					Ctxs IN ListaDomDimensionCtx_TYP, -- Contextos
																					Usuario IN VARCHAR2, -- Usuario que define la etiqueta
																					ALWAYS IN NUMBER) AS
	CURSOR domCtx IS
		SELECT 	*
		FROM 	TABLE(Ctxs);	
	BEGIN
			FOR ctx IN domCtx LOOP
				INSERT INTO CatalogoCtx_TAB VALUES 	(	
																			UsuarioCtx_TYP(Usuario), 
																			DomDimensionCtx_TYP(ctx.dominio, ctx.dimension), 
																			DominioDifuso_TYP(Dominio),
																			Etiqueta,
																			Trapezoide_TYP(A,B,C,D)
																			);
				dbms_output.put_line(ctx.dimension.nombre || ' --> ' || ctx.dominio);
			END LOOP;		
	END;
/