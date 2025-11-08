<?php
class FavoritoController extends BaseController
{
  public function insertFavoritoAction()
  {
    $strErrorDesc = '';
    $responseData = '';
    $strErrorHeader = 'HTTP/1.1 201 OK';
    try {
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $inputData = json_decode(file_get_contents("php://input"), true);

      if (strtoupper($requestMethod) != 'POST') {
        throw new Exception("Method not supported.");
      }

      if (!isset($inputData['UUID_JUGADOR']) || !isset($inputData['CORREO_USUARIO'])) {
        throw new Exception("Invalid input.");
      }

      $UUID_JUGADOR = $inputData['UUID_JUGADOR'];
      $CORREO_USUARIO = $inputData['CORREO_USUARIO'];

      $FavoritoModel = new FavoritoModel();
      $result = $FavoritoModel->insertFavorito($UUID_JUGADOR, $CORREO_USUARIO);
      if ($result) {
        $responseData = json_encode(["message" => "Favorito agregado exitosamente"]);
      } else {
        throw new Exception("Fallo insertar nuevo favorito.");
      }
    } catch (Exception $e) {
      $errorMessage = $e->getMessage();
      if (strpos($errorMessage, 'Duplicate entry') !== false && strpos($errorMessage, 'PRIMARY') !== false) {
        $responseData = json_encode(["message" => "Ya tienes esta estampa en favoritos!"]);
        $strErrorHeader = 'HTTP/1.1 200 OK';
      } else {
        $strErrorDesc = $errorMessage;
        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
      }
    }
    if (!$strErrorDesc) {
      $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 201 OK']);
    } else {
      $this->sendOutput(json_encode(["error" => $strErrorDesc]), ['Content-Type: application/json', $strErrorHeader]);
    }
  }

  public function listAction()
  {
    $strErrorDesc = '';
    $responseData = '';
    try {
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $inputData = json_decode(file_get_contents("php://input"), true);

      if (strtoupper($requestMethod) != 'POST') {
        throw new Exception("Method not supported.");
      }

      if (!isset($inputData['CORREO_USUARIO'])) {
        throw new Exception("Invalid input.");
      }

      $CORREO_USUARIO = $inputData['CORREO_USUARIO'];

      $FavoritoModel = new FavoritoModel();
      $arrUsers = $FavoritoModel->getFavorito($CORREO_USUARIO);
      $responseData = json_encode($arrUsers);
    } catch (Error $e) {
      $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    }

    if (!$strErrorDesc) {
      $this->sendOutput(
        $responseData,
        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
      );
    } else {
      $this->sendOutput(json_encode(["error" => $strErrorDesc]), ['Content-Type: application/json', $strErrorHeader]);
    }
  }

  public function eliminarAction()
  {
    $strErrorDesc = '';
    $responseData = '';
    try {
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $inputData = json_decode(file_get_contents("php://input"), true);

      if (strtoupper($requestMethod) != 'POST') {
        throw new Exception("Method not supported.");
      }

      if (!isset($inputData['UUID_JUGADOR']) || !isset($inputData['CORREO_USUARIO'])) {
        throw new Exception("Invalid input.");
      }
      $UUID_JUGADOR = $inputData['UUID_JUGADOR'];
      $CORREO_USUARIO = $inputData['CORREO_USUARIO'];

      $FavoritoModel = new FavoritoModel();
      $result = $FavoritoModel->deleteFavorito($UUID_JUGADOR, $CORREO_USUARIO);
      if ($result) {
        $responseData = json_encode(["message" => "Favorito eliminado exitosamente"]);
      } else {
        throw new Exception("Fallo eliminar favorito.");
      }
    } catch (Exception $e) {
      $strErrorDesc = $e->getMessage();
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    }

    if (!$strErrorDesc) {
      $this->sendOutput($responseData, ['Content-Type: application/json', 'HTTP/1.1 200 OK']);
    } else {
      $this->sendOutput(json_encode(["error" => $strErrorDesc]), ['Content-Type: application/json', $strErrorHeader]);
    }
  }
}