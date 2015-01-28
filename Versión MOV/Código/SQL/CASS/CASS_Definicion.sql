-- Pasamos UDLinLab_tab aquí, cambiandole el nombre a CatalogoCtx_TAB
-- tambien conocido como Tabla Magica. En la primera redistribucion
-- se almaceno en FDB_Tablas

CREATE OR REPLACE TYPE DimensionCtx AS OBJECT


CREATE TABLE CatalogoCtx_TAB (
	usuario Usuario_TYP,
	contexto Contexto_TYP,
	-- dominio: engloba a todos los posibles conjuntos difusos
	-- y si es continuo ya tiene etiqueta y trapezoide.
	dominio DominioDifuso_TYP,
	CONSTRAINT PK_CatCtx PRIMARY KEY (usuario,dominio,contexto)
);

/*
CREATE TABLE UDLinLab_tab (
  Label       VARCHAR2(50),
  User_name   VARCHAR2(50),
  Dom_name    VARCHAR2(50),
  Trapezoid   Trapezoid_objtyp,
  CONSTRAINT  PK_LL PRIMARY KEY (Label, User_name, Dom_name),
  CONSTRAINT  FK_LL_Dom FOREIGN KEY (Dom_name) REFERENCES Domain_tab
);
*/