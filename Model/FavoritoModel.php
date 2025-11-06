<?php
class FavoritoModel extends Database
{
  public function insertFavorito($UUID_JUGADOR, $CORREO_USUARIO)
  {
    $query = "CALL agregar_favoritos(?, ?)";
    $params = [
      ["s", $UUID_JUGADOR],
      ["s", $CORREO_USUARIO]
    ];
    return $this->insert($query, $params);
  }

  public function getFavorito($CORREO_USUARIO)
  {
    $query = "CALL mostrar_favoritos_por_usuarios(?)";
    $params = ["s", $CORREO_USUARIO];

    return $this->select($query, $params);
  }

  public function deleteFavorito($UUID_JUGADOR, $CORREO_USUARIO)
  {
    $query = "CALL  eliminar_favorito(?, ?)";
    $params = [
      ["s", $UUID_JUGADOR],
      ['s', $CORREO_USUARIO]
    ];
    return $this->insert($query, $params);
  }
}