<?php
class FavoritoModel extends Database
{
  public function insertFavorito($id_publicacion, $correo)
  {
    $query = "CALL agregar_favoritos(?, ?)";
    $params = [
      ["i", $id_publicacion],
      ["s", $correo]
    ];
    return $this->insert($query, $params);
  }

  public function getFavorito($correo)
  {
    $query = "CALL mostrar_favoritos_por_usuarios(?)";
    $params = ["s", $correo];

    return $this->select($query, $params);
  }

  public function deleteFavorito($id_publicacion, $correo)
  {
    $query = "CALL  eliminar_favorito(?, ?)";
    $params = [
      ["i", $id_publicacion],
      ['s', $correo]
    ];
    return $this->insert($query, $params);
  }
}