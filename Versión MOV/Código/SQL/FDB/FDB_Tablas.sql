/*
	FDB_Tablas
	
	Definición de tablas para soportar las estructuras
	de objetos.
	
*/

CREATE SEQUENCE Id_Dominio
    MINVALUE 1
    START WITH 1
    INCREMENT BY 1
    CACHE 20;

CREATE TABLE Domain_tab OF Fuzzy_objtyp (
  CONSTRAINT PK_Domain PRIMARY KEY (dom_name)  
);


CREATE TABLE UDLinLab_tab (
  Label       VARCHAR2(50),
  User_name   VARCHAR2(50),
  Dom_name    VARCHAR2(50),
  Trapezoid   Trapezoid_objtyp,
  CONSTRAINT  PK_LL PRIMARY KEY (Label, User_name, Dom_name),
  CONSTRAINT  FK_LL_Dom FOREIGN KEY (Dom_name) REFERENCES Domain_tab
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

CREATE TABLE semejanza_etiquetas OF semejanza_etiquetas_t (
  CONSTRAINT PK_SEM_ETIQ PRIMARY KEY (etiqueta_1, etiqueta_2, usuario, dom_name),
  CONSTRAINT FK_ETIQ_1 FOREIGN KEY (etiqueta_1) REFERENCES etiqueta_carac_marcha(etiq),
  CONSTRAINT FK_ETIQ_2 FOREIGN KEY (etiqueta_2) REFERENCES etiqueta_carac_marcha(etiq),
  CONSTRAINT FK_DOMINIO_ETIQ FOREIGN KEY (dom_name) REFERENCES Domain_tab(dom_name),
  CONSTRAINT FK_USER_ETIQ FOREIGN KEY (usuario) REFERENCES Usuarios(NickName)
);

CREATE OR REPLACE PROCEDURE sem_fijo_etiq (dom_name1 VARCHAR2, usuario1 VARCHAR2, etiqueta1 VARCHAR2, dominio1 NUMBER, grado1 NUMBER)
is
	gradoviejo NUMBER;
BEGIN
	INSERT INTO semejanza_fijo_etiqueta VALUES (usuario1, dom_name1, etiqueta1, dominio1, grado1);
	EXCEPTION
	WHEN DUP_VAL_ON_INDEX THEN
		UPDATE semejanza_fijo_etiqueta SET grado = grado1 WHERE dom_name = dom_name1 AND usuario = usuario1 AND etiqueta = etiqueta1 AND dominio = dominio1;
END;
/

CREATE OR REPLACE PROCEDURE sem_etiquetas (dom_name1 VARCHAR2, usuario1 VARCHAR2, etiqueta1 VARCHAR2, etiqueta2 VARCHAR2, grado1 NUMBER)
is
	gradoviejo NUMBER;
BEGIN
	INSERT INTO semejanza_etiquetas VALUES (usuario1, dom_name1, etiqueta1, etiqueta2, grado1);
EXCEPTION
WHEN DUP_VAL_ON_INDEX THEN
	UPDATE semejanza_etiquetas SET grado = grado1 WHERE dom_name = dom_name1 AND usuario = usuario1 AND etiqueta_1 = etiqueta1 AND etiqueta_2 = etiqueta2;
END;
/
