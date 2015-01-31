/*
	CASS_Definicion

	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni

*/

/*
	VERSION ESTEBAN
*/

CREATE TABLE UsuarioCtx_TAB (
	nombre 		VARCHAR2(50),
	CONSTRAINT PK_UsuarioCtx PRIMARY KEY (nombre)
);

CREATE TABLE DimensionCtx_TAB (
	nombre		VARCHAR2(50), -- Tipo de dimensión Ej: Usuario, Tarea, Rol
	CONSTRAINT PK_DimensionCtx PRIMARY KEY (nombre)
);

CREATE TABLE DependenciaCtx_TAB (
	dominio		VARCHAR2(50), -- Dominio difuso
	dimension 	VARCHAR2(50), -- Dimension Ej: Rol, Tareas, Lugar
	CONSTRAINT PK_DependenciaCtx PRIMARY KEY (dominio,dimension),
	CONSTRAINT FK_Dep_Dominio FOREIGN KEY (dominio) REFERENCES DimensionCtx_TAB,
	CONSTRAINT FK_Dep_Dimension FOREIGN KEY (dimension) REFERENCES DimensionCtx_TAB,
);

CREATE TABLE DomDimensionCtx_TAB (
	usuario		VARCHAR2(50),
	dimension	VARCHAR2(50),
	dominio		VARCHAR2(50), -- Dominio Dimension Contextual Ej: Post-Operatorio
	CONSTRAINT PK_DomDimensionCtx PRIMARY KEY (usuario,dimension,dominio),
	CONSTRAINT FK_DomCtx_Usuario FOREIGN KEY (usuario) REFERENCES UsuarioCtx_TAB,
	CONSTRAINT FK_DomCtx_Dimension FOREIGN KEY (dimension) REFERENCES DimensionCtx_TAB,
);

-- Para primeras pruebas solo con dominios difusos. Hacer transformación con cualquier dominio difuso
CREATE TABLE CatalogoCtx_TAB (
	usuario			VARCHAR2(50),
	dimension 		VARCHAR2(50),
	domDimension	VARCHAR2(50),
	dominio 		VARCHAR2(50), -- Dominio difuso Ej: Peso
	etiqueta 		VARCHAR2(50),
	trapezoide		Trapezoide_TYP,	 
	CONSTRAINT PK_CatalogoCtx PRIMARY KEY (usuario, dimension, domDimension, dominio),
	CONSTRAINT FK_Cat_DomDimension FOREIGN KEY (usuario,dimension,domDimension) REFERENCES DomDimensionCtx_TAB,
	CONSTRAINT FK_Cat_Dominio FOREIGN KEY (dominio) REFERENCES DominioDifuso_TAB,
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