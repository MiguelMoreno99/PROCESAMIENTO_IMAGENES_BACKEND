<?php
class FavoritoController extends BaseController
{
  public function insertFavoritoAction()
  {
    $strErrorDesc = '';
    $responseData = '';
    try {
      $requestMethod = $_SERVER["REQUEST_METHOD"];
      $inputData = json_decode(file_get_contents("php://input"), true);

      if (strtoupper($requestMethod) != 'POST') {
        throw new Exception("Method not supported.");
      }

      if (!isset($inputData['uuid_jugador']) || !isset($inputData['correo'])) {
        throw new Exception("Invalid input.");
      }

      $uuid_jugador = $inputData['uuid_jugador'];
      $correo = $inputData['correo'];

      $FavoritoModel = new FavoritoModel();
      $result = $FavoritoModel->insertFavorito($uuid_jugador, $correo);
      if ($result) {
        $responseData = json_encode(["message" => "Favorito agregado exitosamente"]);
      } else {
        throw new Exception("Fallo insertar nuevo favorito.");
      }
    } catch (Exception $e) {
      $strErrorDesc = $e->getMessage();
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
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

      if (!isset($inputData['correo'])) {
        throw new Exception("Invalid input.");
      }

      $correo = $inputData['correo'];

      $FavoritoModel = new FavoritoModel();
      $arrUsers = $FavoritoModel->getFavorito($correo);
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

      if (!isset($inputData['uuid_jugador']) || !isset($inputData['correo'])) {
        throw new Exception("Invalid input.");
      }
      $uuid_jugador = $inputData['uuid_jugador'];
      $correo = $inputData['correo'];

      $FavoritoModel = new FavoritoModel();
      $result = $FavoritoModel->deleteFavorito($uuid_jugador, $correo);
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