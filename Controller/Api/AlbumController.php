<?php
class AlbumController extends BaseController
{
  public function reclamarAction()
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
        throw new Exception("Invalid input. 'UUID_JUGADOR' y 'correo' son requeridos.");
      }

      $UUID_JUGADOR = $inputData['UUID_JUGADOR'];
      $CORREO_USUARIO = $inputData['CORREO_USUARIO'];

      $albumModel = new AlbumModel();
      $result = $albumModel->reclamarEstampa($UUID_JUGADOR, $CORREO_USUARIO);

      if ($result) {
        $responseData = json_encode(["message" => "Estampa reclamada exitosamente"]);
      } else {
        throw new Exception("Fallo al reclamar la estampa. (¿Quizás ya la tienes?)");
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
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $arrQueryStringParams = $this->getQueryStringParams();
    if (strtoupper($requestMethod) == 'GET') {
      try {

        $albumModel = new AlbumModel();
        $arrEstampas = $albumModel->getTodasEstampas();
        $responseData = json_encode($arrEstampas);
      } catch (Error $e) {
        $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
        $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
      }
    } else {
      $strErrorDesc = 'Method not supported';
      $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
    }
    if (!$strErrorDesc) {
      $this->sendOutput(
        $responseData,
        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
      );
    } else {
      $this->sendOutput(
        json_encode(array('error' => $strErrorDesc)),
        array('Content-Type: application/json', $strErrorHeader)
      );
    }
  }

  public function listUserAction()
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
        throw new Exception("Invalid input. 'correo' es requerido.");
      }

      $CORREO_USUARIO = $inputData['CORREO_USUARIO'];

      $albumModel = new AlbumModel();
      $arrEstampas = $albumModel->getEstampasUsuario($CORREO_USUARIO);

      $responseData = json_encode($arrEstampas);
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

      $AlbumModel = new AlbumModel();
      $result = $AlbumModel->deleteEstampaUsuario($UUID_JUGADOR, $CORREO_USUARIO);
      if ($result) {
        $responseData = json_encode(["message" => "Estampa eliminada exitosamente"]);
      } else {
        throw new Exception("Fallo eliminar estampa.");
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