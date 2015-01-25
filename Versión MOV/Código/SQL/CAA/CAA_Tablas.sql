/*
	CAA_Tablas
	
	
*/



-- Es usado para la insercion de EFA
CREATE SEQUENCE Id_Per
    MINVALUE 1
    START WITH 1
    INCREMENT BY 1
    CACHE 20;
	
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

CREATE TABLE etiqueta_carac_marcha OF etiqueta_t(
  PRIMARY KEY (etiq)
);

-- Dispositivo como ej: muletas, silla de ruedas, ...

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

