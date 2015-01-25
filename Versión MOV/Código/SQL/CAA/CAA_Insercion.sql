DROP USER USERDEF CASCADE;
CREATE USER USERDEF IDENTIFIED BY 1234;
GRANT ALL PRIVILEGES TO USERDEF;
INSERT INTO User_tab VALUES ('SYSTEM');


INSERT INTO Domain_tab VALUES ('Talla');
INSERT INTO Domain_tab VALUES ('Peso');
INSERT INTO Domain_tab VALUES ('Flex_cad_der');
INSERT INTO Domain_tab VALUES ('Flex_cad_izq');
INSERT INTO Domain_tab VALUES ('Ext_cad_der');
INSERT INTO Domain_tab VALUES ('Ext_cad_izq');,
INSERT INTO Domain_tab VALUES ('Abd0_cad_izq');
INSERT INTO Domain_tab VALUES ('Abd0_cad_der');
INSERT INTO Domain_tab VALUES ('Abd9_cad_der');
INSERT INTO Domain_tab VALUES ('Abd9_cad_izq');
INSERT INTO Domain_tab VALUES ('Abd_cad_der');
INSERT INTO Domain_tab VALUES ('Abd_cad_izq');
INSERT INTO Domain_tab VALUES ('Selec_Flex_cad_der');
INSERT INTO Domain_tab VALUES ('Selec_Flex_cad_izq');
INSERT INTO Domain_tab VALUES ('Fuer_Ext_cad_der');
INSERT INTO Domain_tab VALUES ('Fuer_Ext_cad_izq');
INSERT INTO Domain_tab VALUES ('Fuer_Abd_cad_der');
INSERT INTO Domain_tab VALUES ('Fuer_Abd_cad_izq');
INSERT INTO Domain_tab VALUES ('Fuer_Adu_cad_der');
INSERT INTO Domain_tab VALUES ('Fuer_Adu_cad_izq');
INSERT INTO Domain_tab VALUES ('Tono_mus_Fle_cad_der');
INSERT INTO Domain_tab VALUES ('Tono_mus_Fle_cad_izq');
INSERT INTO Domain_tab VALUES ('Tono_mus_Ext_cad_der');
INSERT INTO Domain_tab VALUES ('Tono_mus_Ext_cad_izq');
INSERT INTO Domain_tab VALUES ('Tono_mus_Abd_cad_der');
INSERT INTO Domain_tab VALUES ('Tono_mus_Abd_cad_izq');
INSERT INTO Domain_tab VALUES ('Tono_mus_Adu_cad_der');
INSERT INTO Domain_tab VALUES ('Tono_mus_Adu_cad_izq');
INSERT INTO Domain_tab VALUES ('Ant_Fem_der');
INSERT INTO Domain_tab VALUES ('Ant_Fem_izq');
INSERT INTO Domain_tab VALUES ('Rot_Int_der');
INSERT INTO Domain_tab VALUES ('Rot_Int_izq');
INSERT INTO Domain_tab VALUES ('Rot_Ext_der'); 
INSERT INTO Domain_tab VALUES ('Rot_Ext_izq');
INSERT INTO Domain_tab VALUES ('Eje_Bim_der');
INSERT INTO Domain_tab VALUES ('Eje_Bim_izq');
INSERT INTO Domain_tab VALUES ('Ang_pie_der');
INSERT INTO Domain_tab VALUES ('Ang_pie_izq');
INSERT INTO Domain_tab VALUES ('Flex_Rod_der');
INSERT INTO Domain_tab VALUES ('Flex_Rod_izq');
INSERT INTO Domain_tab VALUES ('SLR');
INSERT INTO Domain_tab VALUES ('Fuerza_Flex_der');
INSERT INTO Domain_tab VALUES ('Fuerza_Flex_izq');
INSERT INTO Domain_tab VALUES ('Fuerza_Ext_der');
INSERT INTO Domain_tab VALUES ('Fuerza_Ext_izq');
INSERT INTO Domain_tab VALUES ('Tono_Flex_der');
INSERT INTO Domain_tab VALUES ('Tono_Flex_izq');,
INSERT INTO Domain_tab VALUES ('Tono_Ext_der');
INSERT INTO Domain_tab VALUES ('Tono_Ext_izq');
INSERT INTO Domain_tab VALUES ('Dor_Rod_der9');
INSERT INTO Domain_tab VALUES ('Dor_Rod_izq9');
INSERT INTO Domain_tab VALUES ('Dor_Rod_der0');
INSERT INTO Domain_tab VALUES ('Dor_Rod_izq0');
INSERT INTO Domain_tab VALUES ('Plant_Flex_der');
INSERT INTO Domain_tab VALUES ('Plant_Flex_izq');
INSERT INTO Domain_tab VALUES ('Inver_der');
INSERT INTO Domain_tab VALUES ('Inver_izq');
INSERT INTO Domain_tab VALUES ('Ever_der');
INSERT INTO Domain_tab VALUES ('Ever_izq');
INSERT INTO Domain_tab VALUES ('Fue_Mus_Dorsi_der');
INSERT INTO Domain_tab VALUES ('Fue_Mus_Dorsi_izq');
INSERT INTO Domain_tab VALUES ('Fue_Mus_Plan_der');
INSERT INTO Domain_tab VALUES ('Fue_Mus_Plan_izq');
INSERT INTO Domain_tab VALUES ('Fue_Mus_Inv_der');
INSERT INTO Domain_tab VALUES ('Fue_Mus_Inv_izq');
INSERT INTO Domain_tab VALUES ('Fue_Mus_Ever_der');
INSERT INTO Domain_tab VALUES ('Fue_Mus_Ever_izq');
INSERT INTO Domain_tab VALUES ('Tono_Flex_Dor_Izq');
INSERT INTO Domain_tab VALUES ('Tono_Flex_Dor_Der');
INSERT INTO Domain_tab VALUES ('Tono_Flex_Plan_Izq');
INSERT INTO Domain_tab VALUES ('Tono_Flex_Plan_Der');
INSERT INTO Domain_tab VALUES ('Tono_inv_der');
INSERT INTO Domain_tab VALUES ('Tono_inv_izq');
INSERT INTO Domain_tab VALUES ('Tono_ever_izq');
INSERT INTO Domain_tab VALUES ('Tono_ever_der');

INSERT INTO UDLinLab_tab VALUES ('Normal', 'USERDEF', 'Peso', Trapezoid_objtyp(48,60,75,90));
INSERT INTO UDLinLab_tab VALUES ('Obeso', 'USERDEF', 'Peso', Trapezoid_objtyp(85,110,150,300));
INSERT INTO UDLinLab_tab VALUES ('Delgado', 'USERDEF', 'Peso', Trapezoid_objtyp(0,1,35,50));

INSERT INTO UDLinLab_tab VALUES ('Normal', 'ANDEL', 'Peso', Trapezoid_objtyp(48,60,75,90));
INSERT INTO UDLinLab_tab VALUES ('Obeso', 'ANDEL', 'Peso', Trapezoid_objtyp(85,110,150,300));
INSERT INTO UDLinLab_tab VALUES ('Delgado', 'ANDEL', 'Peso', Trapezoid_objtyp(0,1,35,50));

INSERT INTO UDLinLab_tab VALUES ('Sano', 'JHOSBERT', 'Peso', Trapezoid_objtyp(58,70,80,95));
INSERT INTO UDLinLab_tab VALUES ('Gordo', 'JHOSBERT', 'Peso', Trapezoid_objtyp(95,115,155,300));
INSERT INTO UDLinLab_tab VALUES ('Flaco', 'JHOSBERT', 'Peso', Trapezoid_objtyp(0,1,35,60));

INSERT INTO UDLinLab_tab VALUES ('Sano', 'SYSTEM', 'Peso', Trapezoid_objtyp(58,70,80,95));
INSERT INTO UDLinLab_tab VALUES ('Gordo', 'SYSTEM', 'Peso', Trapezoid_objtyp(95,115,155,300));
INSERT INTO UDLinLab_tab VALUES ('Flaco', 'SYSTEM', 'Peso', Trapezoid_objtyp(0,1,35,60));

INSERT INTO UDLinLab_tab VALUES ('Normal', 'SYSTEM', 'Talla', Trapezoid_objtyp(1.40,1.55,1.60,1.75));
INSERT INTO UDLinLab_tab VALUES ('Alto', 'SYSTEM', 'Talla', Trapezoid_objtyp(1.74,1.80,1.90,3.00));
INSERT INTO UDLinLab_tab VALUES ('Bajo', 'SYSTEM', 'Talla', Trapezoid_objtyp(0.0,0.1,0.80,1.49));

INSERT INTO UDLinLab_tab VALUES ('Normal', 'USERDEF', 'Talla', Trapezoid_objtyp(1.40,1.55,1.60,1.75));
INSERT INTO UDLinLab_tab VALUES ('Alto', 'USERDEF', 'Talla', Trapezoid_objtyp(1.74,1.80,1.90,3.00));
INSERT INTO UDLinLab_tab VALUES ('Bajo', 'USERDEF', 'Talla', Trapezoid_objtyp(0.0,0.1,0.80,1.49));

INSERT INTO UDLinLab_tab VALUES ('Normal', 'SYSTEM', 'Peso', Trapezoid_objtyp(48,60,75,90));
INSERT INTO UDLinLab_tab VALUES ('Obeso', 'SYSTEM', 'Peso', Trapezoid_objtyp(85,110,150,300));
INSERT INTO UDLinLab_tab VALUES ('Delgado', 'SYSTEM', 'Peso', Trapezoid_objtyp(0,1,35,50));

INSERT INTO UDLinLab_tab VALUES ('Normal', 'USERDEF', 'Flex_cad_der', Trapezoid_objtyp(100,110,150,169));
INSERT INTO UDLinLab_tab VALUES ('Hyperfelx', 'USERDEF', 'Flex_cad_der', Trapezoid_objtyp(168,175,200,300));
INSERT INTO UDLinLab_tab VALUES ('LowFlex', 'USERDEF', 'Flex_cad_der', Trapezoid_objtyp(0,0,80,150));




INSERT INTO Etiqueta_Tono_Muscular Values (1,'Atonia');
INSERT INTO Etiqueta_Tono_Muscular Values (2,'Hipotonia');
INSERT INTO Etiqueta_Tono_Muscular Values (3,'Normotonia');
INSERT INTO Etiqueta_Tono_Muscular Values (4,'Hipertonia');

INSERT INTO D_Tono_Muscular Values (1,1);
INSERT INTO D_Tono_Muscular Values (2,2);
INSERT INTO D_Tono_Muscular Values (3,3);
INSERT INTO D_Tono_Muscular Values (4,4);

INSERT INTO Etiqueta_Carac_Marcha Values (1,'Normal');
INSERT INTO Etiqueta_Carac_Marcha Values (2,'Hemiplejica');
INSERT INTO Etiqueta_Carac_Marcha Values (3,'Ataxica');
INSERT INTO Etiqueta_Carac_Marcha Values (4,'Parkinsoniana');
INSERT INTO Etiqueta_Carac_Marcha Values (5,'Danzante');
INSERT INTO Etiqueta_Carac_Marcha Values (6,'Antialgica');
INSERT INTO Etiqueta_Carac_Marcha Values (7,'Espastica');

INSERT INTO Dispositivo Values (1, 'Muletas');
INSERT INTO Dispositivo Values (2, 'Silla de ruedas');
INSERT INTO Dispositivo Values (3, 'Baston');
INSERT INTO Dispositivo Values (4, 'Andadera');

INSERT INTO espastica_cond Values (1,'Derecha');
INSERT INTO espastica_cond Values (2,'Izquierda');
INSERT INTO espastica_cond Values (3,'Bilateral');
INSERT INTO espastica_cond Values (4,'Ninguna');

COMMIT;
