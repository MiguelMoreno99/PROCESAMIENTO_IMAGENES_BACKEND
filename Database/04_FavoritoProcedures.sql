USE DB_FIFAAPP;

DELIMITER $$
CREATE PROCEDURE agregar_favoritos(
    IN in_uuid_jugador CHAR(36),
    IN in_correo VARCHAR(255)
)
BEGIN
    INSERT INTO TABLA_FAVORITO (UUID_JUGADOR, CORREO_USUARIO)
    VALUES (in_uuid_jugador, in_correo);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE mostrar_favoritos_por_usuarios(
    IN in_correo VARCHAR(255)
)
BEGIN
    SELECT 
        j.*
    FROM 
        TABLA_FAVORITO AS f
    INNER JOIN 
        TABLA_ESTAMPA_JUGADOR AS j ON f.UUID_JUGADOR = j.UUID_JUGADOR
    WHERE 
        f.CORREO_USUARIO = in_correo;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE eliminar_favorito(
    IN in_uuid_jugador CHAR(36),
    IN in_correo VARCHAR(255)
)
BEGIN
    DELETE FROM TABLA_FAVORITO
    WHERE UUID_JUGADOR = in_uuid_jugador AND CORREO_USUARIO = in_correo;
END$$
DELIMITER ;