USE DB_FIFAAPP;

DELIMITER $$
CREATE PROCEDURE traer_datos_usuario(
    IN in_correo VARCHAR(255)
)
BEGIN
    SELECT 
        CORREO_USUARIO, 
        NOMBRE_USUARIO, 
        APELLIDO_USUARIO, 
        FOTO_PERFIL_USUARIO,
        CONTRASEÑA_USUARIO
    FROM TABLA_USUARIO 
    WHERE CORREO_USUARIO = in_correo;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE insertar_usuario(
    IN in_correo VARCHAR(255),
    IN in_nombre VARCHAR(100),
    IN in_apellido VARCHAR(150),
    IN in_contra_hash VARCHAR(255),
    IN in_foto_url VARCHAR(255)
)
BEGIN
    INSERT INTO TABLA_USUARIO (
        CORREO_USUARIO, 
        NOMBRE_USUARIO, 
        APELLIDO_USUARIO, 
        CONTRASEÑA_USUARIO, 
        FOTO_PERFIL_USUARIO
    ) 
    VALUES (
        in_correo, 
        in_nombre, 
        in_apellido, 
        in_contra_hash, 
        in_foto_url
    );
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE editar_datos_usuario(
    IN in_correo VARCHAR(255),
    IN in_nombre VARCHAR(100),
    IN in_apellido VARCHAR(150),
    IN in_contra_hash VARCHAR(255),
    IN in_foto_url VARCHAR(255)
)
BEGIN
    UPDATE TABLA_USUARIO
    SET
        NOMBRE_USUARIO = in_nombre,
        APELLIDO_USUARIO = in_apellido,
        CONTRASEÑA_USUARIO = IF(in_contra_hash IS NOT NULL AND in_contra_hash != '', in_contra_hash, CONTRASEÑA_USUARIO),
        FOTO_PERFIL_USUARIO = IF(in_foto_url IS NOT NULL, in_foto_url, FOTO_PERFIL_USUARIO)
    WHERE CORREO_USUARIO = in_correo;
END$$
DELIMITER ;