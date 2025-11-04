USE DB_FIFAAPP;

-- USUARIO DE EJEMPLO

CALL insertar_usuario("CORREO@EJEMPO.COM","NOMBRE EJEMPLO","APELLIDO EJEMPLO","CONTRASEÑA_EJEMPLO","https://url_de_ejemplo.com/foto.jpg");

CALL traer_datos_usuario("CORREO@EJEMPO.COM");

CALL editar_datos_usuario("CORREO@EJEMPO.COM","NOMBRE EJEMPLO EDITADO","APELLIDO EJEMPLO EDITADO","CONTRASEÑA_EJEMPLO_EDITADA","https://url_de_ejemplo.com/foto_editada.jpg");

select * from tabla_usuario;