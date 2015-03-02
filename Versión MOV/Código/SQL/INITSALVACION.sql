set serveroutput on
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
	agregarDomDimensionCtx('JUAN','TASK','DEFAULT');
	agregarDomDimensionCtx('JUAN','TASK','EXAMEN');
	agregarDomDimensionCtx('JUAN','ROL','MEDICO');
	agregarDomDimensionCtx('JUAN','ROL','DEFAULT');
	agregarDomDimensionCtx('JUAN','ROL','FISIO');
	agregarDomDimensionCtx('JUAN','USER','JUAN');
END;
/
*/
/* PROBANDO METODO SON IGUALES --- FUNCIONA!
DECLARE 
	A Contexto_TYP;
	B Contexto_TYP;
	C BOOLEAN;
BEGIN
	C := FALSE;
	DBMS_OUTPUT.PUT_LINE('EJECUTA IGUALDAD');
	A := Contexto_TYP(1,ListaDomDimensionCtx_TYP(DomDimensionCtx_TYP('DOMA','DIMA'), DomDimensionCtx_TYP('DOMB','DIMB')));
	B := Contexto_TYP(2,ListaDomDimensionCtx_TYP(DomDimensionCtx_TYP('DOMA','DIMA'), DomDimensionCtx_TYP('DOMB','DIMB'), DomDimensionCtx_TYP('DOMC','DIMC')));
	C := B.esIgual(A.dimensiones);
	IF (C) THEN
		DBMS_OUTPUT.PUT_LINE('SON IGUALES');
	END IF;
	DBMS_OUTPUT.PUT_LINE('TERMINA IGUALDAD');
END;
/
*/


DECLARE 
	A  ListaDomDimensionCtx_TYP;
	T Trapezoide_TYP;
BEGIN
	A := ListaDomDimensionCtx_TYP(
													DomDimensionCtx_TYP('OPERATORIO','TASK'),
													DomDimensionCtx_TYP('FISIO','ROL'),
													DomDimensionCtx_TYP('JUAN','USER')
													);
	definirEtiqueta('PESO','GORDO',7,8,9,10,A,'JUAN',0);
	A := ListaDomDimensionCtx_TYP(
													DomDimensionCtx_TYP('OPERATORIO','TASK'),
													DomDimensionCtx_TYP('MEDICO','ROL'),
													DomDimensionCtx_TYP('JUAN','USER')
													);
	definirEtiqueta('PESO','GORDO',1,2,3,4,A,'JUAN',0);
	A := ListaDomDimensionCtx_TYP(
													DomDimensionCtx_TYP('OPERATORIO','TASK'),
													DomDimensionCtx_TYP('MEDICO','ROL'),
													DomDimensionCtx_TYP('JUAN','USER')
													);
	definirEtiqueta('PESO','GORDO',3,4,5,6,A,'JUAN',2);
	A := ListaDomDimensionCtx_TYP(
													DomDimensionCtx_TYP('OPERATORIO','TASK'),
													DomDimensionCtx_TYP('MEDICO','ROL'),
													DomDimensionCtx_TYP('JUAN','USER')
													);
	definirEtiqueta('PESO','GORDO',5,6,7,8,A,'JUAN',1);

	A := ListaDomDimensionCtx_TYP(
													DomDimensionCtx_TYP('OPERATORIO','TASK'),
													DomDimensionCtx_TYP('MEDICO','ROL'),
													DomDimensionCtx_TYP('JUAN','USER')
													);

	--T := CatalogoEtiqueta('JUAN', 'PESO', 'GORDO',A );
	--DBMS_OUTPUT.PUT_LINE('------->' || T.A || ' ' || T.B || ' ' || T.C || ' ' || T.D);

END;
/