/*
	CAA_Tablas_Usuarios
	
	Definición de tablas para soportar las estructuras
	de usuarios.
	
*/


	
CREATE TABLE User_tab OF UserDef_objtyp (
  CONSTRAINT PK_User PRIMARY KEY (NickName) 
);

CREATE TABLE Usuarios OF UserDef_objtyp (
  CONSTRAINT PK_Usuarios PRIMARY KEY (NickName) 
);

CREATE SEQUENCE Id_Historiales -- Usado para la insercion de pacientes
    MINVALUE 1
    START WITH 1
    INCREMENT BY 1
    CACHE 20;
	
CREATE TABLE Medico OF Medico_t(
  CONSTRAINT PK_MEDICO PRIMARY KEY (usuario)
);

CREATE TABLE Paciente OF Paciente_t(
  CONSTRAINT PK_PACIENTE PRIMARY KEY (CI, ID_Historial)
);
	