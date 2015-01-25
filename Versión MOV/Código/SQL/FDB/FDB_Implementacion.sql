/*
	FDB_Implementacion
	
	Implementación de estructuras para dominios difusos.
	
	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni
	
	Cambios respecto a versión anterior:
	
	- Renombrar
		Fuzzy_objtyp 		---> DominioDifuso_TYP
		Trapezoid_objtyp 	---> Trapezoide_TYP 
		DT_objtyp			---> Continuo_TYP
		
	- Eliminar
		* Funciones de DominioDifuso_TYP:
			Solo retornan NULL. 
			
			
	NOTA: 	Para lo indicado con * chequear que sea 
			factible la modificación	
*/

CREATE OR REPLACE TYPE BODY Trapezoide_TYP AS 
 
 	
	CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Label IN VARCHAR2) RETURN SELF AS RESULT IS
		UD_reg UDLinLab_tab%rowtype;
	  	CT_T Trapezoide_TYP;
	  	BEGIN
	    	SELECT  * INTO UD_reg
	   	FROM    UDLinLab_tab
	   	WHERE   User_name=user AND Label=Label AND Dom_name=Dominio;
	   	SELF:=UD_reg.Trapezoid;
	   	RETURN;
	   	EXCEPTION when NO_DATA_FOUND THEN
	    	SELF:= CA_UserDefault(Dominio, Label);
	        RETURN;
	 END;

CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, N IN NUMBER) RETURN SELF AS RESULT IS
 BEGIN
    SELF:=Trapezoide_TYP( N, N, N, N);
    RETURN;
 END;

CONSTRUCTOR FUNCTION Trapezoide_TYP (Dominio IN VARCHAR2, Label IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
CT_T Trapezoide_TYP;
BEGIN
   CA_LinLab(Dominio, Label, User , N1, N2, N3, N4);
   SELF:=Trapezoide_TYP( N1, N2, N3, N4);
   RETURN;
END;
  
MEMBER FUNCTION FEQT (T1 IN Trapezoide_TYP) RETURN REAL IS
  FEQR  NUMBER (3,2); 
  S_a   NUMBER(12,3);
  S_b   NUMBER(12,3);
  T1_a  NUMBER(12,3);
  T1_b  NUMBER(12,3);
  BEGIN
   IF (SELF.A= 0 AND SELF.B= 0) THEN 
    S_a:=SELF.C;
    S_b:=SELF.C;
    ELSE
    S_a:=SELF.A;
    S_b:=SELF.B;
   END IF;
   IF (T1.A= 0 AND T1.B= 0) THEN 
    T1_a:=T1.C;
    T1_b:=T1.C;
    ELSE
    T1_a:=T1.A;
    T1_b:=T1.B;
   END IF;
   IF (SELF.A= T1.A AND SELF.B = T1.B AND SELF.C= T1.C AND SELF.D = T1.D) THEN FEQR:=1;  
     ELSIF (SELF.A= T1.A AND SELF.B = T1.B AND ((SELF.C<= T1.C AND SELF.D <= T1.D) OR (SELF.C>= T1.C AND SELF.D >= T1.D))) THEN FEQR:=1;
       ELSIF (S_a >= T1.D OR SELF.D <= T1_a) THEN FEQR:=0;
         ELSIF (SELF.C < T1_b AND SELF.D > T1_a) THEN 
           FEQR:=(SELF.D - T1_a)/((T1_b - T1_a)-(SELF.C - SELF.D));
             ELSIF  (S_b > T1.C AND S_a < T1.D) THEN
                FEQR:=(T1.D - S_a)/((S_b - S_a)-(T1.C - T1.D));
              ELSE
                FEQR:=1;
    END IF;
    RETURN FEQR;
  END;

MEMBER FUNCTION FEQ (Dominio IN VARCHAR2, Label IN VARCHAR2) RETURN REAL IS
  T1 Trapezoide_TYP;
  BEGIN
    T1:=CA_Trap(Dominio,Label);
    RETURN SELF.FEQT(T1);
  END;

MEMBER FUNCTION LSHOW(Dom IN VARCHAR2) RETURN VARCHAR2 IS
   Trap Trapezoide_TYP;
   TYPE CUR_TYP IS REF CURSOR;
   c_cursor   CUR_TYP;
   Lab1       VarCHAR2(20);
   FEQ        Number(3,2);
   v_query    VARCHAR2(255);
   str        VARCHAR(60);
 BEGIN
  Trap:=SELF;
  v_query := 'SELECT L.Trapezoid.FEQT(:T1), Label
   FROM UDLinLab_TAB L 
   WHERE User_name=User AND Dom_name=:D AND L.Trapezoid.FEQT(:T2)>0'; 
  OPEN c_cursor FOR v_query USING Trap, Dom, Trap;
    LOOP
      FETCH c_cursor INTO FEQ, Lab1;
      EXIT WHEN c_cursor%NOTFOUND;
      str:=str||FEQ||'/'||Lab1||'; ';
    END LOOP;
  CLOSE c_cursor;
  RETURN str;
  EXCEPTION WHEN NO_DATA_FOUND THEN
    Raise_application_error(-20001,'*** User Not Found *** ');
 END;

MEMBER FUNCTION SHOW RETURN VARCHAR2 IS
   T Trapezoide_TYP;
   str VARCHAR(60);
 BEGIN
  T:=SELF;
  str:=str||'('||T.A||', '||T.B||', '||T.C||', '||T.D||')';
  RETURN str;
 END;

END;
/

CREATE OR REPLACE TYPE BODY Continuo_TYP AS 
 
 CONSTRUCTOR FUNCTION Continuo_TYP (Dom IN VARCHAR2, Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab(Dom, Lab, User , N1, N2, N3, N4);
    SELF:=Continuo_TYP(Dom, Lab, Trapezoide_TYP(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION Continuo_TYP (Dom IN VARCHAR2, Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=Continuo_TYP(Dom, Lab, Trapezoide_TYP(Dom, Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION Continuo_TYP (Dom IN VARCHAR2, Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=Continuo_TYP(Dom, NULL , Trapezoide_TYP(Dom, Num));
    RETURN;
  END;

OVERRIDING MEMBER FUNCTION LSHOW (Dom IN VARCHAR2) RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW(Dom);
 END;

OVERRIDING MEMBER FUNCTION SHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.SHOW();
 END;

OVERRIDING MEMBER FUNCTION FEQ (Dominio IN VARCHAR2, Label IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ(Dominio,Label);
  END;
  
END;
/