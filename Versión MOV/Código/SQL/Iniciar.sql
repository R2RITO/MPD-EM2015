-- USUARIOS

INSERT INTO UsuarioCtx_TAB VALUES ('DEFAULT');
INSERT INTO UsuarioCtx_TAB VALUES ('JUAN');
INSERT INTO UsuarioCtx_TAB VALUES ('CICCIOBELLO');
-- DOMINIOS DIFUSOS
INSERT INTO DominioDifuso_TAB VALUES ('PESO');
INSERT INTO DominioDifuso_TAB VALUES ('FLEXCADERA');
-- DIMENSIONES

BEGIN
	agregarDimensionCtx('USER');
	agregarDimensionCtx('TASK');
	agregarDimensionCtx('ROL');
END;
/
-- DEPENDENCIAS
BEGIN
	agregarDependenciaCtx('PESO','USER');
	agregarDependenciaCtx('PESO','ROL');
	agregarDependenciaCtx('FLEXCADERA','USER');
	agregarDependenciaCtx('FLEXCADERA','ROL');
	agregarDependenciaCtx('FLEXCADERA','TASK');
END;
/

-- DOMINIO DE DIMENSIONES
BEGIN
	agregarDomDimensionCtx('DEFAULT','USER','DEFAULT');
	agregarDomDimensionCtx('DEFAULT','TASK','DEFAULT');
	agregarDomDimensionCtx('DEFAULT','ROL','DEFAULT');
	agregarDomDimensionCtx('JUAN','TASK','OPERACION');
	agregarDomDimensionCtx('JUAN','ROL','MEDICO');
	agregarDomDimensionCtx('JUAN','USER','JUAN');
END;
/

/*
DECLARE 
	A  ListaDomDimensionCtx_TYP;
BEGIN
	A := ListaDomDimensionCtx_TYP(
													DomDimensionCtx_TYP('OPERATORIO',DimensionCtx_TYP('TASK')),
													DomDimensionCtx_TYP('MEDICO',DimensionCtx_TYP('ROL')),
													DomDimensionCtx_TYP('JUAN',DimensionCtx_TYP('USER'))
													);
	definirEtiqueta('PESO','GORDO',7,8,9,10,A,'JUAN',0);
END;
/
*/
--CatalogoEtiqueta(Usuario IN VARCHAR2, Dominio IN VARCHAR2, Etiqueta IN VARCHAR2, Ctxs IN ListaDomDimensionCtx_TYP)

DECLARE
	T Trapezoide_TYP;
	A  ListaDomDimensionCtx_TYP;
BEGIN
	A := ListaDomDimensionCtx_TYP(
													DomDimensionCtx_TYP('OPERATORIO',DimensionCtx_TYP('TASK')),
													DomDimensionCtx_TYP('MEDICO',DimensionCtx_TYP('ROL')),
													DomDimensionCtx_TYP('JUAN',DimensionCtx_TYP('USER'))
													);
	T := CatalogoEtiqueta('SYSTEM', 'PESO', 'OBESO',A );
END;
/