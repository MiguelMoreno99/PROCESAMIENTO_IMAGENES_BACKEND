<?php
include "Model/Database.php";
class UserModel extends Database
{
    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM TABLA_USUARIO LIMIT ?", ["i", $limit]);
    }

    public function getUser($correo)
    {
        $query = "CALL traer_datos_usuario(?)";
        $params = ["s", $correo];
        return $this->select($query, $params);
    }

    public function insertUser($correo, $nombre, $apellido, $contra, $foto_perfil)
    {
        $query = "CALL insertar_usuario(?, ?, ?, ?, ?)";
        $params = [
            ["s", $correo],
            ["s", $nombre],
            ["s", $apellido],
            ["s", $contra],
            ["s", $foto_perfil]
        ];
        return $this->insert($query, $params);
    }

    public function modifyUser($correo, $nombre, $apellido, $contra, $foto_perfil)
    {
        $query = "CALL editar_datos_usuario(?, ?, ?, ?, ?)";
        $params = [
            ["s", $correo],
            ["s", $nombre],
            ["s", $apellido],
            ["s", $contra],
            ["s", $foto_perfil]
        ];
        return $this->insert($query, $params);
    }
}
