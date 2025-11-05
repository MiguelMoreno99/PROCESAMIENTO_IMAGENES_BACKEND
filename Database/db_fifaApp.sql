CREATE DATABASE IF NOT EXISTS DB_FIFAAPP
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE DB_FIFAAPP;

CREATE TABLE TABLA_USUARIO (
    CORREO_USUARIO VARCHAR(255) NOT NULL,
    NOMBRE_USUARIO VARCHAR(100) NOT NULL,
    APELLIDO_USUARIO VARCHAR(150),
    CONTRASEÑA_USUARIO VARCHAR(255) NOT NULL, -- Se Almacena el HASH de la contraseña (generado por PHP), NUNCA texto plano.
    FOTO_PERFIL_USUARIO VARCHAR(255), -- Se almacena el URL de la foto que se guardará en el servidor.
    PRIMARY KEY (CORREO_USUARIO)
);

CREATE TABLE TABLA_ESTAMPA_JUGADOR (
    UUID_JUGADOR CHAR(36) NOT NULL PRIMARY KEY DEFAULT (UUID()),
    IMG_PAIS_JUGADOR VARCHAR(255), -- Se almacena el URL de la api donde se saca la imagen
    NOMBRE_PAIS_JUGADOR VARCHAR(100),
    NOMBRE_ABREVIADO_PAIS_JUGADOR VARCHAR(10),
    IMG_SELECCION_JUGADOR VARCHAR(255), -- Se almacena el URL de la api donde se saca la imagen
    IMG_JUGADOR_JUGADOR VARCHAR(255), -- Se almacena el URL de la api donde se saca la imagen
    NOMBRE_SELECCION_JUGADOR VARCHAR(100),
    POSICION_JUGADOR VARCHAR(50),
    POSICION_ABREVIADO_JUGADOR VARCHAR(10),
    NUMERO_JUGADOR TINYINT,
    NOMBRE_COMPLETO_JUGADOR VARCHAR(200) NOT NULL,
    NOMBRE_CORTO_JUGADOR VARCHAR(100),
    NACIMIENTO_CORTO_JUGADOR VARCHAR(155), -- Se usa varchar porque se guarda mas información de su nacimiento
    NACIMIENTO_JUGADOR VARCHAR(255), -- Se usa varchar porque se guarda mas información de su nacimiento
    ALTURA_JUGADOR VARCHAR(155), -- Se usa varchar porque se guarda mas información de su altura
    ACTUAL_CLUB_JUGADOR VARCHAR(100),
    PRIMER_CLUB_JUGADOR VARCHAR(100),
    LOGROS_JUGADOR TEXT, -- se usa TEXT para textos largos como logros
    INDEX idx_nombre_jugador (NOMBRE_COMPLETO_JUGADOR) -- Añadimos este índice al nombre para búsquedas rápidas
);

CREATE TABLE TABLA_FAVORITO (
    CORREO_USUARIO VARCHAR(255) NOT NULL,
    UUID_JUGADOR CHAR(36) NOT NULL,
    PRIMARY KEY (CORREO_USUARIO, UUID_JUGADOR),
    
    CONSTRAINT fk_usuario_favorito
        FOREIGN KEY (CORREO_USUARIO) 
        REFERENCES TABLA_USUARIO(CORREO_USUARIO)
        ON DELETE CASCADE -- Si se borra el usuario, se borra su favorito
        ON UPDATE CASCADE, -- Si cambia el email (PK), se actualiza aquí
        
    CONSTRAINT fk_jugador_favorito
        FOREIGN KEY (UUID_JUGADOR)
        REFERENCES TABLA_ESTAMPA_JUGADOR(UUID_JUGADOR)
        ON DELETE CASCADE -- Si se borra el jugador, se borra el favorito
        ON UPDATE CASCADE
);

CREATE TABLE TABLA_ESTAMPAS_USUARIO (
    CORREO_USUARIO VARCHAR(255) NOT NULL,
    UUID_JUGADOR CHAR(36) NOT NULL,
    
    PRIMARY KEY (CORREO_USUARIO, UUID_JUGADOR),
    
    CONSTRAINT fk_usuario_estampa
        FOREIGN KEY (CORREO_USUARIO) 
        REFERENCES TABLA_USUARIO(CORREO_USUARIO)
        ON DELETE CASCADE -- Si se borra el usuario, se borra su inventario
        ON UPDATE CASCADE,
        
    CONSTRAINT fk_jugador_estampa
        FOREIGN KEY (UUID_JUGADOR)
        REFERENCES TABLA_ESTAMPA_JUGADOR(UUID_JUGADOR)
        ON DELETE CASCADE -- Si se borra la estampa maestra, se borra de los inventarios
        ON UPDATE CASCADE
);