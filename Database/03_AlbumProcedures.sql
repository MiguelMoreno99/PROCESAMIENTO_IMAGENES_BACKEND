USE DB_FIFAAPP;

DELIMITER $$
CREATE PROCEDURE reclamar_estampa_usuario(
    IN in_uuid_jugador CHAR(36),
    IN in_correo VARCHAR(255)
)
BEGIN
    INSERT INTO TABLA_ESTAMPAS_USUARIO (UUID_JUGADOR, CORREO_USUARIO)
    VALUES (in_uuid_jugador, in_correo);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE verificar_estampa_reclamada(
    IN in_uuid_jugador CHAR(36)
)
BEGIN
    SELECT 
        CORREO_USUARIO 
    FROM 
        TABLA_ESTAMPAS_USUARIO 
    WHERE 
        UUID_JUGADOR = in_uuid_jugador
    LIMIT 1;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE traer_todas_estampas()
BEGIN
    SELECT * FROM TABLA_ESTAMPA_JUGADOR;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE listar_estampas_usuario(
    IN in_correo VARCHAR(255)
)
BEGIN
    SELECT 
        j.*
    FROM 
        TABLA_ESTAMPAS_USUARIO AS eu
    INNER JOIN 
        TABLA_ESTAMPA_JUGADOR AS j ON eu.UUID_JUGADOR = j.UUID_JUGADOR
    WHERE 
        eu.CORREO_USUARIO = in_correo;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE eliminar_estampa_usuario(
    IN in_uuid_jugador CHAR(36),
    IN in_correo VARCHAR(255)
)
BEGIN
    DELETE FROM TABLA_ESTAMPAS_USUARIO
    WHERE UUID_JUGADOR = in_uuid_jugador AND CORREO_USUARIO = in_correo;
END$$
DELIMITER ;

select * from tabla_usuario;
select * from tabla_estampa_jugador;

