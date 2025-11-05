<?php

class AlbumModel extends Database
{
  public function reclamarEstampa($uuid_jugador, $correo)
  {
    $query = "CALL reclamar_estampa_usuario(?, ?)";
    $params = [
      ["s", $uuid_jugador],
      ["s", $correo]
    ];
    return $this->insert($query, $params);
  }

  public function getTodasEstampas()
  {
    return $this->select("CALL traer_todas_estampas()");
  }

  public function getEstampasUsuario($correo)
  {
    $query = "CALL listar_estampas_usuario(?)";
    $params = ["s", $correo];

    return $this->select($query, $params);
  }

  public function deleteEstampaUsuario($uuid_jugador, $correo)
  {
    $query = "CALL  eliminar_estampa_usuario(?, ?)";
    $params = [
      ["s", $uuid_jugador],
      ['s', $correo]
    ];
    return $this->insert($query, $params);
  }
}