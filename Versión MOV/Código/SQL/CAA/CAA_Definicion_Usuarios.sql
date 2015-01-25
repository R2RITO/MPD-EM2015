/*
	CAA_Definicion_Usuarios
	
	Definición de tipos de usuarios
	
	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni

*/

CREATE OR REPLACE TYPE UserDef_objtyp AS OBJECT (
  NickName     VARCHAR2(50)
);
/

CREATE OR REPLACE TYPE Medico_t AS OBJECT(
   CI NUMBER(10),
   Nombres VARCHAR2(50),
   Apellidos VARCHAR2(50),
   Usuario VARCHAR2(20),
   Contrasena VARCHAR2(20),
   Fisio NUMBER(1)
) NOT FINAL;
/

CREATE OR REPLACE TYPE Paciente_t AS OBJECT(
   CI NUMBER(10),
   Nombres VARCHAR2(50),
   Apellidos VARCHAR2(50),
   Profesion VARCHAR2(50),
   Lugar_Residencia VARCHAR2(50),
   Fecha_Nacimiento DATE,
   ID_Historial NUMBER(6),
   Diagnostico VARCHAR2(200),
   Intervenciones_Quir VARCHAR2(150),
   MEMBER FUNCTION FEQ (et IN NUMBER) return real,
   MEMBER FUNCTION prom_parecido3 (et IN NUMBER) return real
) NOT FINAL;
/
