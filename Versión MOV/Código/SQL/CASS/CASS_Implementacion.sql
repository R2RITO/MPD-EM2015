/*
	CASS_Implementacion
	
	Ramón Marquez
	Esteban Oliveros
	Arturo Voltattorni
*/

CREATE OR REPLACE TYPE BODY Contexto_TYP AS 
	MEMBER FUNCTION esIgual(ctx IN ListaDomDimensionCtx_TYP) RETURN BOOLEAN IS
		CURSOR contextosA IS
			SELECT *
			FROM TABLE(ctx);
		CURSOR contextosB IS
			SELECT *
			FROM TABLE(SELF.dimensiones);		
		coincide	BOOLEAN; 
		existe 		BOOLEAN;			
		BEGIN
			coincide := TRUE;			
			existe := FALSE;
			
			FOR a IN contextosA LOOP
				existe := FALSE;
				FOR b IN contextosB LOOP
					existe := existe OR ((a.dominio = b.dominio) AND (a.dimension = b.dimension));
				END LOOP;
				coincide := coincide AND existe;
			END LOOP;

			FOR b IN contextosB LOOP
				existe := FALSE;
				FOR a IN contextosA LOOP
					existe := existe OR ((a.dominio = b.dominio) AND (a.dimension = b.dimension));
				END LOOP;
				coincide := coincide AND existe;
			END LOOP;
			
			RETURN coincide;
		END;
	MEMBER FUNCTION show RETURN VARCHAR2 IS
		CURSOR contextos IS
			SELECT *
			FROM TABLE(SELF.dimensiones);		
		BEGIN
			FOR a IN contextos LOOP
				DBMS_OUTPUT.PUT_LINE('------->' || a.dominio || ' ' || a.dimension);
			END LOOP;
			RETURN NULL;
		END;
END;
/
