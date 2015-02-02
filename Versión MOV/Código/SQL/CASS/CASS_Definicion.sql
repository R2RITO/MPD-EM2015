/*
	CASS_Definicion

	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni

*/

/* ******************* USUARIO ******************* */

CREATE OR REPLACE TYPE UsuarioCtx_TYP AS OBJECT(
	nombre	VARCHAR2(50)
)
/

CREATE TABLE UsuarioCtx_TAB OF UsuarioCtx_TYP(
	CONSTRAINT PK_UsuarioCtx PRIMARY KEY (nombre)
)
/

/* ******************* DIMENSION ******************* */

CREATE OR REPLACE TYPE DimensionCtx_TYP AS OBJECT(
	nombre	VARCHAR2(50) -- Tipo de dimensión Ej: Usuario, Tarea, Rol
)
/

CREATE TABLE DimensionCtx_TAB OF DimensionCtx_TYP(
	CONSTRAINT PK_DimensionCtx PRIMARY KEY (nombre)
)
/

CREATE TABLE DependenciaCtx_TAB (
	dominio		DominioDifuso_TYP, -- Dominio difuso
	dimension 	DimensionCtx_TYP, -- Dimension Ej: Rol, Tareas, Lugar
	CONSTRAINT PK_DependenciaCtx PRIMARY KEY (dominio.nombre,dimension.nombre),
	CONSTRAINT FK_Dep_Dominio FOREIGN KEY (dominio.nombre) REFERENCES DominioDifuso_TAB,
	CONSTRAINT FK_Dep_Dimension FOREIGN KEY (dimension.nombre) REFERENCES DimensionCtx_TAB
)
/

CREATE OR REPLACE TYPE DomDimensionCtx_TYP AS OBJECT (
	dominio		VARCHAR2(50), -- Dominio: Medico, Operatorio
	dimension 	DimensionCtx_TYP -- Dimension Ej: Rol, Tareas, Lugar
)
/

CREATE OR REPLACE TYPE ListaDomDimensionCtx_TYP AS TABLE OF DomDimensionCtx_TYP;
/


CREATE TABLE DomDimensionCtx_TAB (
	usuario			UsuarioCtx_TYP,
	dimension 		DomDimensionCtx_TYP,
	CONSTRAINT PK_DomDimensionCtx PRIMARY KEY (usuario.nombre, dimension.dimension.nombre, dimension.dominio),
	CONSTRAINT FK_DomDimCtx_Usuario FOREIGN KEY (usuario.nombre) REFERENCES UsuarioCtx_TAB,
	CONSTRAINT FK_DomDimCtx_Dimension FOREIGN KEY (dimension.dimension.nombre) REFERENCES DimensionCtx_TAB
)
/

/* ******************* CATÁLOGO ******************* */

CREATE TABLE CatalogoCtx_TAB (
	usuario			UsuarioCtx_TYP,
	--dimensiones		ListaDomDimensionCtx_TYP,
	dimension 		DomDimensionCtx_TYP,
	dominio 		DominioDifuso_TYP,
	etiqueta 		VARCHAR2(50),
	trapezoide		Trapezoide_TYP,
	CONSTRAINT PK_CatalogoCtx PRIMARY KEY (usuario.nombre, dimension.dimension.nombre, dimension.dominio, dominio.nombre, etiqueta),
	CONSTRAINT FK_Cat_DefDomDim FOREIGN KEY (usuario.nombre, dimension.dimension.nombre, dimension.dominio) REFERENCES DomDimensionCtx_TAB,
	CONSTRAINT FK_Cat_Usuario FOREIGN KEY (usuario.nombre) REFERENCES UsuarioCtx_TAB,
	CONSTRAINT FK_Cat_Dep FOREIGN KEY (dominio.nombre, dimension.dimension.nombre) REFERENCES DependenciaCtx_TAB
) 	--NESTED TABLE dimensiones STORE AS DimensionesCtx_TAB;
/
	
/*
CREATE TABLE DomDimensionCtx_TAB OF DomDimensionCtx_TYP(
	CONSTRAINT PK_DomDimensionCtx PRIMARY KEY (usuario,dimension,dominio),
	CONSTRAINT FK_DomCtx_Usuario FOREIGN KEY (usuario) REFERENCES UsuarioCtx_TAB,
	CONSTRAINT FK_DomCtx_Dimension FOREIGN KEY (dimension) REFERENCES DimensionCtx_TAB,
)
/

-- Para primeras pruebas solo con dominios difusos. Hacer transformación con cualquier dominio difuso


CREATE TABLE UDLinLab_tab (
  Label       VARCHAR2(50),
  User_name   VARCHAR2(50),
  Dom_name    VARCHAR2(50),
  Trapezoid   Trapezoid_objtyp,
  CONSTRAINT  PK_LL PRIMARY KEY (Label, User_name, Dom_name),
  CONSTRAINT  FK_LL_Dom FOREIGN KEY (Dom_name) REFERENCES Domain_tab
)
/
*/