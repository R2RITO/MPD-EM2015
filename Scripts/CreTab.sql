conn system/19254844;

-- Secuencia usada para las IDs de las Usuarios.
-- Se incrementa cada vez que es usada.
CREATE SEQUENCE Id_Per
    MINVALUE 1
    START WITH 1
    INCREMENT BY 1
    CACHE 20;

CREATE SEQUENCE Id_Dominio
    MINVALUE 1
    START WITH 1
    INCREMENT BY 1
    CACHE 20;

CREATE TABLE User_tab OF UserDef_objtyp (
  CONSTRAINT PK_User PRIMARY KEY (NickName) 
);

CREATE TABLE Usuarios OF UserDef_objtyp (
  CONSTRAINT PK_Usuarios PRIMARY KEY (NickName) 
);

CREATE TABLE Domain_tab OF Fuzzy_objtyp (
  CONSTRAINT PK_Domain PRIMARY KEY (dom_name)  
);

-- "PESO", "TONO_MUSCULAR", "DISPOSITIVOS", "CARAC_MARCHA"
-- ?
CREATE TABLE UDLinLab_tab (
  Label       VARCHAR2(50),
  User_name   VARCHAR2(50),
  Dom_name    VARCHAR2(50),
  Trapezoid   Trapezoid_objtyp,
  CONSTRAINT  PK_LL PRIMARY KEY (Label, User_name, Dom_name),
  CONSTRAINT  FK_LL_Dom FOREIGN KEY (Dom_name) REFERENCES Domain_tab
);

CREATE SEQUENCE Id_Historiales
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

CREATE TABLE D_Tono_Muscular OF dominio_fijo_t(
  CONSTRAINT PK_D_TONO PRIMARY KEY (valor),
  CHECK (valor IN ('1', '2', '3', '4'))
);

-- CREATE TABLE D_Tono_Mus2 OF dominio_fijo_t(
--   CONSTRAINT PK_D_TONO PRIMARY KEY (valor),
--   CHECK (valor IN ('0','1', '2', '3', '4','5'))
-- );

CREATE TABLE etiqueta_tono_muscular OF etiqueta_t(
  CONSTRAINT PK_ETIQ_TONO PRIMARY KEY (etiq)
);
-- Revisar aqui. Estas tablas no estan dando con respecto a lo que hace FachadaBD.
CREATE TABLE semejanza_fijo_etiqueta OF semejanza_fijo_etiqueta_t(
  CONSTRAINT PK_SEM_FIJO_ETIQ PRIMARY KEY (etiqueta, dominio, usuario, dom_name),
  CONSTRAINT FK_DOM_TONO FOREIGN KEY (dominio) REFERENCES D_Tono_Muscular(valor),
  CONSTRAINT FK_ETIQ_TONO FOREIGN KEY (etiqueta) REFERENCES etiqueta_Tono_Muscular(etiq),
  CONSTRAINT FK_DOMINIO_VAR FOREIGN KEY (dom_name) REFERENCES Domain_tab(dom_name),
  CONSTRAINT FK_USER FOREIGN KEY (usuario) REFERENCES Usuarios(NickName),
  CHECK (grado BETWEEN 0.00 and 1.00)
);

CREATE TABLE etiqueta_carac_marcha OF etiqueta_t(
  PRIMARY KEY (etiq)
);

CREATE TABLE semejanza_etiquetas OF semejanza_etiquetas_t (
  CONSTRAINT PK_SEM_ETIQ PRIMARY KEY (etiqueta_1, etiqueta_2, usuario, dom_name),
  CONSTRAINT FK_ETIQ_1 FOREIGN KEY (etiqueta_1) REFERENCES etiqueta_carac_marcha(etiq),
  CONSTRAINT FK_ETIQ_2 FOREIGN KEY (etiqueta_2) REFERENCES etiqueta_carac_marcha(etiq),
  CONSTRAINT FK_DOMINIO_ETIQ FOREIGN KEY (dom_name) REFERENCES Domain_tab(dom_name),
  CONSTRAINT FK_USER_ETIQ FOREIGN KEY (usuario) REFERENCES Usuarios(NickName)
);

CREATE TABLE dispositivo OF etiqueta_t(
  PRIMARY KEY (etiq)
);

CREATE TABLE dispositivos_usados OF dispositivos_usados_t(
  PRIMARY KEY (paciente, dispositivo),
  FOREIGN KEY (paciente, ID_Historial) REFERENCES Paciente(CI, ID_Historial),
  FOREIGN KEY (dispositivo) REFERENCES dispositivo(etiq),
  CHECK (grado BETWEEN 0.00 and 1.00)
);

CREATE TABLE espastica_cond OF etiqueta_t(
  PRIMARY KEY (etiq)
  );

CREATE TABLE EFA_tab (
  -- GENERAL
  ID_Historial  NUMBER(6),
  Estudio_PrPs  VARCHAR(2), 
  ID_Lab        NUMBER(6),
  Fecha_Examen  DATE,
  Edad          Number(2),
  Medico_Int    VARCHAR2(50),
  Medico_Fisio  VARCHAR2(50),
  Diagn_ref     VARCHAR2(50),
  Espastica     VARCHAR2(10),
  Tipo_estudio  VARCHAR2(10),
  ID_Persona    NUMBER(10),
  Talla         D_Talla,
  Peso          D_Peso,
  -- CADERA
  Flex_cad_der  D_FlexCad,
  Flex_cad_izq  D_FlexCad,
  Ext_cad_der   D_ExtCad,
  Ext_cad_izq   D_ExtCad,
  Abd0_cad_izq  D_Abd0,
  Abd0_cad_der  D_Abd0,
  Abd9_cad_der  D_Abd9,
  Abd9_cad_izq  D_Abd9,
  Abd_cad_der   D_Abd,
  Abd_cad_izq   D_Abd,
  --
  Selec_Flex_cad_der dominio_fijo_t,
  Selec_Flex_cad_izq dominio_fijo_t,
  Fuer_Ext_cad_der dominio_fijo_t,
  Fuer_Ext_cad_izq dominio_fijo_t,
  Fuer_Abd_cad_der dominio_fijo_t,
  Fuer_Abd_cad_izq dominio_fijo_t,
  Fuer_Adu_cad_der dominio_fijo_t,
  Fuer_Adu_cad_izq dominio_fijo_t,
  Tono_mus_Fle_cad_der dominio_fijo_t,
  Tono_mus_Fle_cad_izq dominio_fijo_t,
  Tono_mus_Ext_cad_der dominio_fijo_t,
  Tono_mus_Ext_cad_izq dominio_fijo_t,
  Tono_mus_Abd_cad_der dominio_fijo_t,
  Tono_mus_Abd_cad_izq dominio_fijo_t,
  Tono_mus_Adu_cad_der dominio_fijo_t,
  Tono_mus_Adu_cad_izq dominio_fijo_t,
  -- Anteversion, Rotacion, Eje Bimaleolar, Angulo Pie Muslo
  Ant_Fem_der D_AntFem,
  Ant_Fem_izq D_AntFem,
  Rot_Int_der D_RotInt,
  Rot_Int_izq D_RotInt,
  Rot_Ext_der D_RotExt, 
  Rot_Ext_izq D_RotExt,
  Eje_Bim_der D_EjeBim,
  Eje_Bim_izq D_EjeBim,
  Ang_pie_der D_AngPie,
  Ang_pie_izq D_AngPie,
  -- Rodilla
  Flex_Rod_der D_FlexRod,
  Flex_Rod_izq D_FlexRod,
  SLR D_Slr,
  Fuerza_Flex_der dominio_fijo_t,
  Fuerza_Flex_izq dominio_fijo_t,
  Fuerza_Ext_der dominio_fijo_t,
  Fuerza_Ext_izq dominio_fijo_t,
  Tono_Flex_der dominio_fijo_t,
  Tono_Flex_izq dominio_fijo_t,
  Tono_Ext_der dominio_fijo_t,
  Tono_Ext_izq dominio_fijo_t,
  -- Tobillo
  Dor_Rod_der9 D_DorRod9,
  Dor_Rod_izq9 D_DorRod9,
  Dor_Rod_der0 D_DorRod0,
  Dor_Rod_izq0 D_DorRod0,
  Plant_Flex_der D_PlanFlex,
  Plant_Flex_izq D_PlanFlex,
  Inver_der D_Inver,
  Inver_izq D_Inver,
  Ever_der D_Inver,
  Ever_izq D_Inver,
  -- 
  Fue_Mus_Dorsi_der dominio_fijo_t,
  Fue_Mus_Dorsi_izq dominio_fijo_t,
  Fue_Mus_Plan_der dominio_fijo_t,
  Fue_Mus_Plan_izq dominio_fijo_t,
  Fue_Mus_Inv_der dominio_fijo_t,
  Fue_Mus_Inv_izq dominio_fijo_t,
  Fue_Mus_Ever_der dominio_fijo_t,
  Fue_Mus_Ever_izq dominio_fijo_t,
  Tono_Flex_Dor_Izq dominio_fijo_t,
  Tono_Flex_Dor_Der dominio_fijo_t,
  Tono_Flex_Plan_Izq dominio_fijo_t,
  Tono_Flex_Plan_Der dominio_fijo_t,
  Tono_inv_der dominio_fijo_t,
  Tono_inv_izq dominio_fijo_t,
  Tono_ever_izq dominio_fijo_t,
  Tono_ever_der dominio_fijo_t,
  -- Pie
  -- Medidas Biometrcas
  -- Reflejos
  -- Clonus
  -- Pruebas Especiales
  Carac_Marcha  etiqueta_t,
  CONSTRAINT FK_ID_PERSON FOREIGN KEY (ID_Persona, ID_Historial) REFERENCES Paciente(CI, ID_Historial),
  CONSTRAINT FK_Med_Fisio FOREIGN KEY (Medico_Fisio) REFERENCES Medico (usuario),
  CONSTRAINT PK_EFA PRIMARY KEY (ID_Persona, Fecha_Examen),
  CONSTRAINT check_espastica CHECK (Espastica IN ('Derecha', 'Izquierda', 'Bilateral'))
);

