INSERT INTO Domain_tab VALUES ('Tono_Flexores_Dorsales_Der');
INSERT INTO Domain_tab VALUES ('Tono_Flexores_Dorsales_Izq');
INSERT INTO Domain_tab VALUES ('Carac_Marcha');
INSERT INTO Domain_tab VALUES ('Peso');

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

COMMIT;
