/*
	Módulo CAR

	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni

*/


/* 
    Busca el trapezoide definido por el usuario por defecto, si no lo encuentra
    retorna un error 
*/
CREATE OR REPLACE FUNCTION CA_UserDefault(CT_Domain VARCHAR2, CT_Label VARCHAR2) 
   RETURN Trapezoid_TYP
is
  UD_reg CatalogoCtx_TAB%rowtype;
  User_Def varchar2(10);
  CT_Trapezoid Trapezoid_Objtyp;
BEGIN
   User_Def:=UserDefault();
   SELECT  * INTO UD_reg
   FROM    CatalogoCtx_TAB
   WHERE   User_name=User_Def AND Label=CT_Label AND Dom_name=CT_Domain;
   RETURN  UD_reg.trapezoide;
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
