/*
	CASS_Implementacion
	
	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni
*/

CREATE OR REPLACE PROCEDURE agregarDependenciaCtx(Dominio IN VARCHAR2, Dimension IN VARCHAR2) AS
	BEGIN
		INSERT INTO DependenciaCtx_TAB VALUES (DominioDifuso_TYP(Dominio), DimensionCtx_TYP(Dimension));
		COMMIT;
	END;
/

CREATE OR REPLACE PROCEDURE agregarDomDimensionCtx(Usuario IN VARCHAR2, Dimension IN VARCHAR2, DomDimension IN VARCHAR2) AS
	BEGIN
		INSERT INTO DomDimensionCtx_TAB	VALUES (UsuarioCtx_TYP(Usuario), DomDimensionCtx_TYP(Dimension, DomDimension));
		COMMIT;
	END;
/

CREATE OR REPLACE PROCEDURE agregarDimensionCtx(Dimension IN VARCHAR2) AS
	BEGIN
		INSERT INTO DimensionCtx_TAB VALUES (Dimension);
		COMMIT;
	END;
/