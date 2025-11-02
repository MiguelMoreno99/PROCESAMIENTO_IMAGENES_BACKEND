<?php

class PublicacionModel extends Database
{
  public function insertPublicacion(
    $correo,
    $titulo,
    $nombre_tema,
    $foto_portada,
    $instrucciones,
    $descripcion,
    $num_likes,
    $foto_proceso
  ) {
    $query = "CALL insertar_publicacion(?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [
      ["s", $correo],
      ["s", $titulo],
      ["s", $nombre_tema],
      ["s", $foto_portada],
      ["s", $instrucciones],
      ["s", $descripcion],
      ["i", $num_likes],
      ["s", $foto_proceso]
    ];
    return $this->insert($query, $params);
  }

  public function getTodasPublicaciones()
  {
    return $this->select("CALL traer_todas_publicaciones()");
  }

  public function getPublicacionesUsuario($correo)
  {
    $query = "CALL traer_publicacion_por_usuario(?)";
    $params = ["s", $correo];
    return $this->select($query, $params);
  }

  public function modifyPublicacion($id_publicacion, $correo, $titulo, $nombre_tema, $foto_portada, $descripcion, $instrucciones, $foto_proceso)
  {
    $query = "CALL modificar_publicacion(?, ?, ?, ?, ?, ?, ?, ?)";
    $params = [
      ["i", $id_publicacion],
      ["s", $correo],
      ["s", $titulo],
      ["s", $nombre_tema],
      ["s", $foto_portada],
      ["s", $descripcion],
      ["s", $instrucciones],
      ["s", $foto_proceso]
    ];
    return $this->insert($query, $params);
  }

  public function deletePublicacion($id_publicacion, $correo)
  {
    $query = "CALL eliminar_publicacion(?, ?)";
    $params = [
      ["i", $id_publicacion],
      ["s", $correo]
    ];
    return $this->insert($query, $params);
  }
}