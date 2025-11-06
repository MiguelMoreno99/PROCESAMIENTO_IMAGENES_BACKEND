<?php
include "Model/Database.php";
class UserModel extends Database
{
    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM TABLA_USUARIO LIMIT ?", ["i", $limit]);
    }

    public function getUser($CORREO_USUARIO)
    {
        $query = "CALL traer_datos_usuario(?)";
        $params = ["s", $CORREO_USUARIO];
        return $this->select($query, $params);
    }

    public function insertUser($CORREO_USUARIO, $NOMBRE_USUARIO, $APELLIDO_USUARIO, $CONTRASEÑA_USUARIO, $FOTO_PERFIL_USUARIO)
    {
        $query = "CALL insertar_usuario(?, ?, ?, ?, ?)";
        $params = [
            ["s", $CORREO_USUARIO],
            ["s", $NOMBRE_USUARIO],
            ["s", $APELLIDO_USUARIO],
            ["s", $CONTRASEÑA_USUARIO],
            ["s", $FOTO_PERFIL_USUARIO]
        ];
        return $this->insert($query, $params);
    }

    public function modifyUser($CORREO_USUARIO, $NOMBRE_USUARIO, $APELLIDO_USUARIO, $CONTRASEÑA_USUARIO, $FOTO_PERFIL_USUARIO)
    {
        $query = "CALL editar_datos_usuario(?, ?, ?, ?, ?)";
        $params = [
            ["s", $CORREO_USUARIO],
            ["s", $NOMBRE_USUARIO],
            ["s", $APELLIDO_USUARIO],
            ["s", $CONTRASEÑA_USUARIO],
            ["s", $FOTO_PERFIL_USUARIO]
        ];
        return $this->insert($query, $params);
    }
}