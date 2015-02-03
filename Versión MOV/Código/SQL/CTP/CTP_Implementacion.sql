/*
	CTP_Implementacion

	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni
*/

/* ******************* CAS ******************* */

	--CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2) RETURN SELF AS RESULT IS
	CREATE OR REPLACE FUNCTION CatalogoEtiqueta(Usuario IN VARCHAR2, Dominio IN VARCHAR2, Etiqueta IN VARCHAR2, Ctxs IN ListaDomDimensionCtx_TYP) RETURN Trapezoide_TYP IS
		coincide	BOOLEAN; -- Chequeamos que la lista de contextos coincidan
		existe 		BOOLEAN;
		no_etiqueta EXCEPTION;
		CURSOR domCtx IS
			SELECT 	*
			FROM 	TABLE(Ctxs);

		-- Cursor con todos los trapezoides definidos por el usuario.
		-- NOTA: En esto falta agregar los trapezoides con parametro ALWAYS en 2,
		-- pero eso luego de agregarse en el catalogo contextual.
		-- NOTA 2: Priorizar los definidos por el usuario, y luego los de always 2.
		CURSOR catCtx IS
			SELECT  *
	   		FROM    CatalogoCtx_TAB
	   		WHERE   usuario.nombre=Usuario AND etiqueta=Etiqueta AND dominio.nombre=Dominio;

		--tupla CatalogoCtx_TAB%ROWTYPE;
		--trapezoide Trapezoide_TYP;
		--CURSOR dom IS ListaDomDimensionCtx_TYP;
		BEGIN
			-- Prueba
			--dbms_output.put_line('EJECUTA');
			--FOR ctx IN domCtx LOOP
			--	dbms_output.put_line(ctx.dimension.nombre || ' --> ' || ctx.dominio);
			--END LOOP;

			-- Buscar si algun trapezoide coincide completamente.
			coincide := TRUE;
			existe := FALSE;
			FOR cat IN catCtx LOOP

				  -- Iterar sobre la lista de dominios de las dimensiones contextuales
					-- asociados al trapezoide.
				  CURSOR listaDomDimCtxTrap IS
					  SELECT *
						FROM cat.dimensiones;

					FOR ctxT IN listaCtxTrap LOOP
						FOR dom IN domCtx LOOP
							existe := existe OR (
												(dom.dimension.nombre LIKE ctxT.dimension.nombre) AND
												(dom.dominio LIKE ctxT.dominio)
												);
						END LOOP;
					coincide := coincide AND existe;
					END LOOP;

					-- Si "coincide" es TRUE, quiere decir que es el trapezoide correcto.
					IF coincide THEN
						return cat.trapezoide;
					END IF;

			END LOOP;

			-- Buscar si hay trapezoides en el always 2

			-- Buscar si hay trapezoide en usuario por defecto.

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

	--CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Valor IN NUMBER) RETURN SELF AS RESULT IS
 		--BEGIN
    	--	SELF:= Trapezoide_TYP( Valor, Valor, Valor, Valor);
    	--RETURN;
 		--END;

	--CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Etiqueta IN VARCHAR2, NodoA IN NUMBER, NodoB IN NUMBER, NodoC IN NUMBER, NodoD IN NUMBER) RETURN SELF AS RESULT IS
		--CT_T Trapezoid_Objtyp;
		--BEGIN
		--	CA_LinLab(Dominio, Etiqueta, User , NodoA, NodoB, NodoC, NodoD); -- Proceso para insertar en CatalogCtx_TAB
		--	SELF:= Trapezoid_Objtyp(NodoA, NodoB, NodoC, NodoD);
		--	RETURN;
		--END;

/* ******************* CAR ******************* */


/*
CREATE OR REPLACE FUNCTION CA_UserDefault(CT_Domain VARCHAR2, CT_Label VARCHAR2)
   RETURN Trapezoid_ObjTyp
is
  UD_reg UDLinLab_tab%rowtype;
  User_Def varchar2(10);
  CT_Trapezoid Trapezoid_Objtyp;
BEGIN
   User_Def:=UserDefault();
   SELECT  * INTO UD_reg
   FROM    UDLinLab_tab
   WHERE   User_name=User_Def AND Label=CT_Label AND Dom_name=CT_Domain;
   RETURN  UD_reg.Trapezoid;
   EXCEPTION WHEN NO_DATA_FOUND THEN
      Raise_application_error(-20001,'*** Label: '||CT_Label||', and Domain: '||CT_Domain||', Not Found *** ');
END;
/



-- Dado un dominio y una etiqueta retorna el trapezoide almacenado
-- por el usuario actualmente conectado, y de no existir la
-- definicion de este, busca la del usuario por defecto
CREATE OR REPLACE FUNCTION CA_Trap (CT_Domain VARCHAR2, CT_Label VARCHAR2)
   RETURN Trapezoid_Objtyp
is
  UD_reg UDLinLab_tab%rowtype;
  CT_T Trapezoid_Objtyp;
BEGIN
   SELECT  * INTO UD_reg
   FROM    UDLinLab_tab
   WHERE   User_name=user AND Label=CT_Label AND Dom_name=CT_Domain;
   CT_T:=UD_reg.Trapezoid;
   RETURN  CT_T;
   EXCEPTION when NO_DATA_FOUND THEN
        CT_T:= CA_UserDefault(CT_Domain,CT_Label);
        RETURN CT_T;
END;
/

-- Si no encuentra la definicion de la etiqueta en el dominio indicado
-- por el usuario entonces lo crea con los puntos dados
CREATE OR REPLACE PROCEDURE CA_LinLab (CT_D VARCHAR2, CT_L VARCHAR2, ID_Us VARCHAR2, TA NUMBER, TB NUMBER, TC NUMBER, TD NUMBER)
is
Us VARCHAR2(10);
    BEGIN
    select User_name into Us
    from UDLinlab_tab
    where Label = CT_L and User_name=Id_us And Dom_name=CT_D;
    EXCEPTION WHEN NO_DATA_FOUND THEN
      INSERT INTO UDLinLab_tab VALUES (CT_L, Id_Us, CT_D, Trapezoid_objtyp(TA,TB,TC,TD));
END;
/

-- No tengo idea de que hacen
CREATE OR REPLACE PROCEDURE CA_Sem_Fijo_Etiq (dom IN VARCHAR2, et IN VARCHAR2, val IN NUMBER, grado IN NUMBER)
is
us NUMBER(20);
    BEGIN
    SELECT grado INTO us
    FROM semejanza_fijo_etiqueta
    WHERE usuario = user AND dom_name = dom AND etiqueta = et AND dominio = val;
    EXCEPTION WHEN NO_DATA_FOUND THEN
      INSERT INTO semejanza_fijo_etiqueta VALUES (user, dom, et, val, grado);
END;
/

CREATE OR REPLACE PROCEDURE CA_Sem_Etiq (dom IN VARCHAR2, et1 IN VARCHAR2, et2 IN VARCHAR2, grado IN NUMBER)
is
us VARCHAR2(20);
    BEGIN
    SELECT usuario INTO us
    FROM semejanza_etiquetas
    WHERE usuario = user AND dom_name = dom AND ((etiqueta_1 = et1 AND etiqueta_2 = et2) OR (etiqueta_1 = et2 AND etiqueta_2 = et1));
    EXCEPTION WHEN NO_DATA_FOUND THEN
      INSERT INTO semejanza_etiquetas VALUES (user, dom, et1, et2, grado);
END;
/


*/
