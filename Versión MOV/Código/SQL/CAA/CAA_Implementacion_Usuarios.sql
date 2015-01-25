
-- Busca y retorna al usuario por defecto
CREATE OR REPLACE FUNCTION UserDefault 
   RETURN VARCHAR
is
  User_Def VARCHAR(10);
BEGIN
   SELECT NICKNAME INTO User_Def
   FROM USER_tab;
   RETURN User_Def; 
   EXCEPTION WHEN NO_DATA_FOUND THEN
      Raise_application_error(-20001,'*** User Default Not Found *** ');
END;
/

CREATE OR REPLACE TYPE BODY Paciente_t AS
MEMBER FUNCTION FEQ (et in NUMBER) return real is
cursor inv1_idiomas is
SELECT dispositivo FROM dispositivos_usados WHERE paciente = self.CI ORDER BY dispositivo;
cursor inv2_idiomas is
SELECT dispositivo FROM dispositivos_usados WHERE paciente = et ORDER BY dispositivo;
idioma1 VARCHAR2(50);
idioma2 VARCHAR2(50);
valor1 NUMBER(4,2);
valor2 NUMBER(4,2);
resp NUMBER(4,2);
BEGIN
IF (self.CI = et) THEN
  RETURN 1;
END IF;
   OPEN inv1_idiomas;
   OPEN inv2_idiomas;
      LOOP
         FETCH inv1_idiomas INTO idioma1;
         EXIT WHEN inv1_idiomas%NOTFOUND;
         FETCH inv2_idiomas INTO idioma2;
         EXIT WHEN inv2_idiomas%NOTFOUND;
            IF (idioma1 <> idioma2) THEN
              RETURN 0;
            END IF;
      END LOOP;

    --FETCH inv1_idiomas INTO idioma1;
    IF inv1_idiomas%NOTFOUND THEN
      FETCH inv2_idiomas INTO idioma2;
      IF inv2_idiomas%FOUND THEN
        RETURN 0;
      ELSE
        SELECT MIN(grado) INTO valor1 FROM dispositivos_usados WHERE paciente = self.ci;
        SELECT MIN(grado) INTO valor2 FROM dispositivos_usados WHERE paciente = et;

        resp := least(valor1, valor2);

        RETURN resp;
      END IF;
    ELSE
      RETURN 0;
    END IF;

    --FETCH inv2_idiomas INTO idioma2;
    IF inv2_idiomas%NOTFOUND THEN
      RETURN 0;
    END IF;

   CLOSE inv2_idiomas;
   CLOSE inv1_idiomas;

SELECT MIN(grado) INTO valor1 FROM dispositivos_usados WHERE paciente = self.ci;
SELECT MIN(grado) INTO valor2 FROM dispositivos_usados WHERE paciente = et;

resp := least(valor1, valor2);

RETURN resp;

END FEQ;

MEMBER FUNCTION prom_parecido3 (et in NUMBER) return real is
cursor inv1_idiomas is
SELECT dispositivo FROM dispositivos_usados WHERE paciente = self.CI ORDER BY dispositivo;
cursor inv2_idiomas is
SELECT dispositivo FROM dispositivos_usados WHERE paciente = et ORDER BY dispositivo;
idioma1 VARCHAR2(50);
idioma2 VARCHAR2(50);
valor1 NUMBER(4,2);
valor2 NUMBER(4,2);
resp NUMBER(4,2);
BEGIN
IF (self.CI = et) THEN
  RETURN 1;
END IF;
   OPEN inv1_idiomas;
   OPEN inv2_idiomas;
      LOOP
         FETCH inv1_idiomas INTO idioma1;
         EXIT WHEN inv1_idiomas%NOTFOUND;
         FETCH inv2_idiomas INTO idioma2;
         EXIT WHEN inv2_idiomas%NOTFOUND;
            IF (idioma1 <> idioma2) THEN
              RETURN 0;
            END IF;
      END LOOP;

    --FETCH inv1_idiomas INTO idioma1;
    IF inv1_idiomas%NOTFOUND THEN
      FETCH inv2_idiomas INTO idioma2;
      IF inv2_idiomas%FOUND THEN
        RETURN 0;
      ELSE
        SELECT MIN(grado) INTO valor1 FROM dispositivos_usados WHERE paciente = self.ci;
        SELECT MIN(grado) INTO valor2 FROM dispositivos_usados WHERE paciente = et;

        resp := ((valor1 + valor2) / 2);

        RETURN resp;
      END IF;
    ELSE
      RETURN 0;
    END IF;

    --FETCH inv2_idiomas INTO idioma2;
    IF inv2_idiomas%NOTFOUND THEN
      RETURN 0;
    END IF;

   CLOSE inv2_idiomas;
   CLOSE inv1_idiomas;

SELECT MIN(grado) INTO valor1 FROM dispositivos_usados WHERE paciente = self.ci;
SELECT MIN(grado) INTO valor2 FROM dispositivos_usados WHERE paciente = et;

resp := ((valor1 + valor2) / 2);

RETURN resp;

END prom_parecido3;

END;
/

