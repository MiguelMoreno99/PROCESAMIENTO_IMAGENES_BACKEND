<?php

class AlbumModel extends Database
{
  public function reclamarEstampa($UUID_JUGADOR, $CORREO_USUARIO)
  {
    $query = "CALL reclamar_estampa_usuario(?, ?)";
    $params = [
      ["s", $UUID_JUGADOR],
      ["s", $CORREO_USUARIO]
    ];
    return $this->insert($query, $params);
  }

  public function getTodasEstampas()
  {
    return $this->select("CALL traer_todas_estampas()");
  }

  public function getEstampasUsuario($CORREO_USUARIO)
  {
    $query = "CALL listar_estampas_usuario(?)";
    $params = ["s", $CORREO_USUARIO];

    return $this->select($query, $params);
  }

  public function deleteEstampaUsuario($UUID_JUGADOR, $CORREO_USUARIO)
  {
    $query = "CALL  eliminar_estampa_usuario(?, ?)";
    $params = [
      ["s", $UUID_JUGADOR],
      ['s', $CORREO_USUARIO]
    ];
    return $this->insert($query, $params);
  }
}