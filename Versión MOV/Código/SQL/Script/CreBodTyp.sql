-- conn miniproyecto/miniproyecto;

CREATE OR REPLACE TYPE BODY Trapezoid_objtyp AS 
 
CONSTRUCTOR FUNCTION Trapezoid_objtyp (D1 IN VARCHAR2, L1 IN VARCHAR2) RETURN SELF AS RESULT IS
  UD_reg UDLinLab_tab%rowtype;
  CT_T Trapezoid_Objtyp;
  BEGIN
    SELECT  * INTO UD_reg
   FROM    UDLinLab_tab
   WHERE   User_name=user AND Label=L1 AND Dom_name=D1;
   SELF:=UD_reg.Trapezoid;
   RETURN;
   EXCEPTION when NO_DATA_FOUND THEN
        SELF:= CA_UserDefault(D1, L1);
        RETURN;
 END;

CONSTRUCTOR FUNCTION Trapezoid_objtyp (D1 IN VARCHAR2, N IN NUMBER) RETURN SELF AS RESULT IS
 BEGIN
    SELF:=Trapezoid_Objtyp( N, N, N, N);
    RETURN;
 END;

CONSTRUCTOR FUNCTION Trapezoid_objtyp (D1 IN VARCHAR2, L1 IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
CT_T Trapezoid_Objtyp;
BEGIN
   CA_LinLab(D1, L1, User , N1, N2, N3, N4);
   SELF:=Trapezoid_Objtyp( N1, N2, N3, N4);
   RETURN;
END;
  
MEMBER FUNCTION FEQT (T1 IN Trapezoid_objtyp) RETURN REAL IS
  FEQR  NUMBER (3,2); 
  S_a   NUMBER(12,3);
  S_b   NUMBER(12,3);
  T1_a  NUMBER(12,3);
  T1_b  NUMBER(12,3);
  BEGIN
   IF (SELF.T_a= 0 AND SELF.T_b= 0) THEN 
    S_a:=SELF.T_c;
    S_b:=SELF.T_c;
    ELSE
    S_a:=SELF.T_a;
    S_b:=SELF.T_b;
   END IF;
   IF (T1.T_a= 0 AND T1.T_b= 0) THEN 
    T1_a:=T1.T_c;
    T1_b:=T1.T_c;
    ELSE
    T1_a:=T1.T_a;
    T1_b:=T1.T_b;
   END IF;
   IF (SELF.T_a= T1.T_a AND SELF.T_b = T1.T_b AND SELF.T_c= T1.T_c AND SELF.T_d = T1.T_d) THEN FEQR:=1;  
     ELSIF (SELF.T_a= T1.T_a AND SELF.T_b = T1.T_b AND ((SELF.T_c<= T1.T_c AND SELF.T_d <= T1.T_d) OR (SELF.T_c>= T1.T_c AND SELF.T_d >= T1.T_d))) THEN FEQR:=1;
       ELSIF (S_a >= T1.T_d OR SELF.T_d <= T1_a) THEN FEQR:=0;
         ELSIF (SELF.T_c < T1_b AND SELF.T_d > T1_a) THEN 
           FEQR:=(SELF.T_d - T1_a)/((T1_b - T1_a)-(SELF.T_c - SELF.T_d));
             ELSIF  (S_b > T1.T_c AND S_a < T1.T_d) THEN
                FEQR:=(T1.T_d - S_a)/((S_b - S_a)-(T1.T_c - T1.T_d));
              ELSE
                FEQR:=1;
    END IF;
    RETURN FEQR;
  END;

MEMBER FUNCTION FEQ (D1 IN VARCHAR2, L1 IN VARCHAR2) RETURN REAL IS
  T1 Trapezoid_objtyp;
  BEGIN
    T1:=CA_Trap(D1,L1);
    RETURN SELF.FEQT(T1);
  END;

MEMBER FUNCTION LSHOW(Dom IN VARCHAR2) RETURN VARCHAR2 IS
   Trap Trapezoid_objtyp;
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
   T Trapezoid_objtyp;
   str VARCHAR(60);
 BEGIN
  T:=SELF;
  str:=str||'('||T.T_A||', '||T.T_B||', '||T.T_C||', '||T.T_D||')';
  RETURN str;
 END;

END;
/

CREATE OR REPLACE TYPE BODY DT_objtyp AS 
 
 CONSTRUCTOR FUNCTION DT_objtyp (Dom IN VARCHAR2, Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab(Dom, Lab, User , N1, N2, N3, N4);
    SELF:=DT_objtyp(Dom, Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION DT_objtyp (Dom IN VARCHAR2, Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=DT_objtyp(Dom, Lab, Trapezoid_objtyp(Dom, Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION DT_objtyp (Dom IN VARCHAR2, Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=DT_objtyp(Dom, NULL , Trapezoid_objtyp(Dom, Num));
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

OVERRIDING MEMBER FUNCTION FEQ (D1 IN VARCHAR2, L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ(D1,L1);
  END;
  
END;
/

CREATE OR REPLACE TYPE BODY Fuzzy_objtyp AS 
 MEMBER FUNCTION LSHOW (Dom IN VARCHAR2) RETURN VARCHAR2 IS
  BEGIN
    RETURN NULL;
  END;
 MEMBER FUNCTION SHOW RETURN VARCHAR2 IS
  BEGIN
    RETURN NULL;
  END;
  MEMBER FUNCTION FEQ (D1 IN VARCHAR2, L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN NULL;
  END;
  
END;
/

CREATE OR REPLACE TYPE BODY D_Peso AS 
 
 CONSTRUCTOR FUNCTION D_Peso (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('Peso', Lab, User , N1, N2, N3, N4);
    SELF:=D_Peso('Peso', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Peso (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Peso('Peso', Lab, Trapezoid_objtyp('Peso', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Peso (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Peso('Peso', User , Trapezoid_objtyp('Peso', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('Peso');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('Peso',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_Talla AS 
 
 CONSTRUCTOR FUNCTION D_Talla (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('Talla', Lab, User , N1, N2, N3, N4);
    SELF:=D_Talla('Talla', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Talla (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Talla('Talla', Lab, Trapezoid_objtyp('Talla', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Talla (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Talla('Talla', User , Trapezoid_objtyp('Talla', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('Talla');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('Talla',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_FlexCad AS 
 
 CONSTRUCTOR FUNCTION D_FlexCad (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('FlexCad', Lab, User , N1, N2, N3, N4);
    SELF:=D_FlexCad('FlexCad', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_FlexCad (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_FlexCad('FlexCad', Lab, Trapezoid_objtyp('FlexCad', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_FlexCad (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_FlexCad('FlexCad', User , Trapezoid_objtyp('FlexCad', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('FlexCad');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('FlexCad',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_ExtCad AS 
 
 CONSTRUCTOR FUNCTION D_ExtCad (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('ExtCad', Lab, User , N1, N2, N3, N4);
    SELF:=D_ExtCad('ExtCad', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_ExtCad (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_ExtCad('ExtCad', Lab, Trapezoid_objtyp('ExtCad', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_ExtCad (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_ExtCad('ExtCad', User , Trapezoid_objtyp('ExtCad', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('ExtCad');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('ExtCad',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_Abd0 AS 
 
 CONSTRUCTOR FUNCTION D_Abd0 (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('Abd0', Lab, User , N1, N2, N3, N4);
    SELF:=D_Abd0('Abd0', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Abd0 (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Abd0('Abd0', Lab, Trapezoid_objtyp('Abd0', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Abd0 (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Abd0('Abd0', User , Trapezoid_objtyp('Abd0', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('Abd0');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('Abd0',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_Abd9 AS 
 
 CONSTRUCTOR FUNCTION D_Abd9 (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('Abd9', Lab, User , N1, N2, N3, N4);
    SELF:=D_Abd9('Abd9', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Abd9 (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Abd9('Abd9', Lab, Trapezoid_objtyp('Abd9', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Abd9 (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Abd9('Abd9', User , Trapezoid_objtyp('Abd9', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('Abd9');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('Abd9',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_Abd AS 
 
 CONSTRUCTOR FUNCTION D_Abd (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('Abd', Lab, User , N1, N2, N3, N4);
    SELF:=D_Abd('Abd', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Abd (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Abd('Abd', Lab, Trapezoid_objtyp('Abd', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Abd (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Abd('Abd', User , Trapezoid_objtyp('Abd', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('Abd');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('Abd',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_AntFem AS 
 
 CONSTRUCTOR FUNCTION D_AntFem (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('AntFem', Lab, User , N1, N2, N3, N4);
    SELF:=D_AntFem('AntFem', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_AntFem (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_AntFem('AntFem', Lab, Trapezoid_objtyp('AntFem', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_AntFem (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_AntFem('AntFem', User , Trapezoid_objtyp('AntFem', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('AntFem');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('AntFem',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_RotInt AS 
 
 CONSTRUCTOR FUNCTION D_RotInt (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('RotInt', Lab, User , N1, N2, N3, N4);
    SELF:=D_RotInt('RotInt', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_RotInt (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_RotInt('RotInt', Lab, Trapezoid_objtyp('RotInt', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_RotInt (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_RotInt('RotInt', User , Trapezoid_objtyp('RotInt', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('RotInt');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('RotInt',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_RotExt AS 
 
 CONSTRUCTOR FUNCTION D_RotExt (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('RotExt', Lab, User , N1, N2, N3, N4);
    SELF:=D_RotExt('RotExt', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_RotExt (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_RotExt('RotExt', Lab, Trapezoid_objtyp('RotExt', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_RotExt (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_RotExt('RotExt', User , Trapezoid_objtyp('RotExt', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('RotExt');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('RotExt',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_EjeBim AS 
 
 CONSTRUCTOR FUNCTION D_EjeBim (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('EjeBim', Lab, User , N1, N2, N3, N4);
    SELF:=D_EjeBim('EjeBim', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_EjeBim (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_EjeBim('EjeBim', Lab, Trapezoid_objtyp('EjeBim', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_EjeBim (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_EjeBim('EjeBim', User , Trapezoid_objtyp('EjeBim', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('EjeBim');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('EjeBim',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_AngPie AS 
 
 CONSTRUCTOR FUNCTION D_AngPie (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('AngPie', Lab, User , N1, N2, N3, N4);
    SELF:=D_AngPie('AngPie', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_AngPie (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_AngPie('AngPie', Lab, Trapezoid_objtyp('AngPie', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_AngPie (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_AngPie('AngPie', User , Trapezoid_objtyp('AngPie', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('AngPie');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('AngPie',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_FlexRod AS 
 
 CONSTRUCTOR FUNCTION D_FlexRod (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('FlexRod', Lab, User , N1, N2, N3, N4);
    SELF:=D_FlexRod('FlexRod', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_FlexRod (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_FlexRod('FlexRod', Lab, Trapezoid_objtyp('FlexRod', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_FlexRod (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_FlexRod('FlexRod', User , Trapezoid_objtyp('FlexRod', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('FlexRod');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('FlexRod',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_Slr AS 
 
 CONSTRUCTOR FUNCTION D_Slr (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('Slr', Lab, User , N1, N2, N3, N4);
    SELF:=D_Slr('Slr', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Slr (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Slr('Slr', Lab, Trapezoid_objtyp('Slr', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Slr (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Slr('Slr', User , Trapezoid_objtyp('Slr', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('Slr');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('Slr',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_DorRod9 AS 
 
 CONSTRUCTOR FUNCTION D_DorRod9 (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('DorRod9', Lab, User , N1, N2, N3, N4);
    SELF:=D_DorRod9('DorRod9', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_DorRod9 (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_DorRod9('DorRod9', Lab, Trapezoid_objtyp('DorRod9', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_DorRod9 (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_DorRod9('DorRod9', User , Trapezoid_objtyp('DorRod9', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('DorRod9');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('DorRod9',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_DorRod0 AS 
 
 CONSTRUCTOR FUNCTION D_DorRod0 (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('DorRod0', Lab, User , N1, N2, N3, N4);
    SELF:=D_DorRod0('DorRod0', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_DorRod0 (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_DorRod0('DorRod0', Lab, Trapezoid_objtyp('DorRod0', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_DorRod0 (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_DorRod0('DorRod0', User , Trapezoid_objtyp('DorRod0', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('DorRod0');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('DorRod0',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_PlanFlex AS 
 
 CONSTRUCTOR FUNCTION D_PlanFlex (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('PlanFlex', Lab, User , N1, N2, N3, N4);
    SELF:=D_PlanFlex('PlanFlex', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_PlanFlex (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_PlanFlex('PlanFlex', Lab, Trapezoid_objtyp('PlanFlex', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_PlanFlex (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_PlanFlex('PlanFlex', User , Trapezoid_objtyp('PlanFlex', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('PlanFlex');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('PlanFlex',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_Inver AS 
 
 CONSTRUCTOR FUNCTION D_Inver (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('Inver', Lab, User , N1, N2, N3, N4);
    SELF:=D_Inver('Inver', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Inver (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Inver('Inver', Lab, Trapezoid_objtyp('Inver', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Inver (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Inver('Inver', User , Trapezoid_objtyp('Inver', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('Inver');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('Inver',L1);
  END;

END;
/

CREATE OR REPLACE TYPE BODY D_Ever AS 
 
 CONSTRUCTOR FUNCTION D_Ever (Lab IN VARCHAR2, N1 IN NUMBER, N2 IN NUMBER, N3 IN NUMBER, N4 IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    CA_LinLab('Ever', Lab, User , N1, N2, N3, N4);
    SELF:=D_Ever('Ever', Lab, Trapezoid_objtyp(N1, N2, N3, N4));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Ever (Lab IN VARCHAR2) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Ever('Ever', Lab, Trapezoid_objtyp('Ever', Lab));
    RETURN;
  END;

 CONSTRUCTOR FUNCTION D_Ever (Num IN NUMBER) RETURN SELF AS RESULT IS
  BEGIN
    SELF:=D_Ever('Ever', User , Trapezoid_objtyp('Ever', Num));
    RETURN;
  END;

MEMBER FUNCTION LSHOW RETURN VARCHAR2 IS
 BEGIN
  RETURN SELF.Trap.LSHOW('Ever');
 END;

MEMBER FUNCTION FEQ (L1 IN VARCHAR2) RETURN REAL IS
  BEGIN
    RETURN SELF.Trap.FEQ('Ever',L1);
  END;

END;
/

