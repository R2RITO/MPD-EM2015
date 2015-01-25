-- Dado el dominio y la etiqueta devuelve la definicion de estos, junto al
-- correspondiente trapezoide que fue definido por el usuario por defecto
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


