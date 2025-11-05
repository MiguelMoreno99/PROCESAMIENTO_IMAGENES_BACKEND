<?php
class FavoritoModel extends Database
{
  public function insertFavorito($uuid_jugador, $correo)
  {
    $query = "CALL agregar_favoritos(?, ?)";
    $params = [
      ["s", $uuid_jugador],
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

  public function deleteFavorito($uuid_jugador, $correo)
  {
    $query = "CALL  eliminar_favorito(?, ?)";
    $params = [
      ["s", $uuid_jugador],
      ['s', $correo]
    ];
    return $this->insert($query, $params);
  }
}