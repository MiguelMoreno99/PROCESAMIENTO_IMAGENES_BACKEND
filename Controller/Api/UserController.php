<?php
class UserController extends BaseController
{
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
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

    public function insertAction()
    {
        $strErrorDesc = '';
        $responseData = '';
        try {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $inputData = json_decode(file_get_contents("php://input"), true);

            if (strtoupper($requestMethod) != 'POST') {
                throw new Exception("Method not supported.");
            }
            if (
                !isset($inputData['correo']) || !isset($inputData['nombre']) ||
                !isset($inputData['apellido']) || !isset($inputData['contra']) ||
                !isset($inputData['foto_perfil'])
            ) {
                throw new Exception("Invalid input.");
            }

            $correo = $inputData['correo'];
            $nombre = $inputData['nombre'];
            $apellido = $inputData['apellido'];
            $contra = $inputData['contra'];
            $foto_perfil = $inputData['foto_perfil'];

            $contra_hash = password_hash($contra, PASSWORD_DEFAULT);
            if ($contra_hash === false) {
                throw new Exception("Fallo al hashear la contraseña.");
            }

            $foto_url = null;

            if (!empty($foto_perfil)) {
                if (preg_match('/^data:image\/(\w+);base64,/', $foto_perfil, $type)) {
                    $foto_perfil = substr($foto_perfil, strpos($foto_perfil, ',') + 1);
                    $tipo_archivo = strtolower($type[1]);
                    if (!in_array($tipo_archivo, ['jpg', 'jpeg', 'png', 'gif'])) {
                        throw new Exception('Tipo de imagen no válido.');
                    }
                } else {
                    $tipo_archivo = 'jpg';
                }

                $datos_imagen = base64_decode($foto_perfil);
                if ($datos_imagen === false) {
                    throw new Exception("Datos Base64 corruptos.");
                }

                $nombre_archivo = uniqid('foto_perfil_') . '_' . time() . '.' . $tipo_archivo;
                $ruta_guardado = __DIR__ . '/../../img/' . $nombre_archivo;

                if (file_put_contents($ruta_guardado, $datos_imagen)) {
                    $foto_url = API_BASE_URL . '/img/' . $nombre_archivo;
                } else {
                    throw new Exception("No se pudo guardar la imagen de perfil en el servidor.");
                }
            }

            $userModel = new UserModel();
            $result = $userModel->insertUser($correo, $nombre, $apellido, $contra_hash, $foto_url);

            if ($result) {
                $responseData = json_encode(["message" => "Usuario agregado exitosamente."]);
            } else {
                throw new Exception("Fallo insertar nuevo usuario.");
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

            if (!isset($inputData['correo'])) {
                throw new Exception("Invalid input.");
            }

            $correo = $inputData['correo'];

            $userModel = new UserModel();
            $arrUsers = $userModel->getUser($correo);
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

    public function modifyAction()
    {
        $strErrorDesc = '';
        $responseData = '';
        try {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $inputData = json_decode(file_get_contents("php://input"), true);

            if (strtoupper($requestMethod) != 'POST') {
                throw new Exception("Method not supported.");
            }

            if (
                !isset($inputData['correo']) || !isset($inputData['nombre']) ||
                !isset($inputData['apellido']) || !isset($inputData['contra']) ||
                !isset($inputData['foto_perfil'])
            ) {
                throw new Exception("Invalid input.");
            }

            $correo = $inputData['correo'];
            $nombre = $inputData['nombre'];
            $apellido = $inputData['apellido'];
            $contra = $inputData['contra'];
            $foto_perfil = $inputData['foto_perfil'];

            $contra_hash_para_db = null;
            if (!empty($contra)) {
                $contra_hash_para_db = password_hash($contra, PASSWORD_DEFAULT);
                if ($contra_hash_para_db === false) {
                    throw new Exception("Fallo al hashear la nueva contraseña.");
                }
            }

            $foto_url_para_db = null;
            if (preg_match('/^data:image\/(\w+);base64,/', $foto_perfil, $type)) {
                $foto_base64_data = substr($foto_perfil, strpos($foto_perfil, ',') + 1);
                $tipo_archivo = strtolower($type[1]);
                if (!in_array($tipo_archivo, ['jpg', 'jpeg', 'png', 'gif'])) {
                    throw new Exception('Tipo de imagen no válido.');
                }

                $datos_imagen = base64_decode($foto_base64_data);
                if ($datos_imagen === false) {
                    throw new Exception("Datos Base64 corruptos.");
                }

                $nombre_archivo = uniqid('foto_perfil_') . '_' . time() . '.' . $tipo_archivo;
                $ruta_guardado = __DIR__ . '/../../img/' . $nombre_archivo;

                if (file_put_contents($ruta_guardado, $datos_imagen)) {
                    $foto_url_para_db = API_BASE_URL . '/img/' . $nombre_archivo;
                } else {
                    throw new Exception("No se pudo guardar la nueva imagen de perfil en el servidor.");
                }
            } else if (!empty($foto_input)) {
                $foto_url_para_db = $foto_input;
            }

            $userModel = new UserModel();
            $result = $userModel->modifyUser($correo, $nombre, $apellido, $contra_hash_para_db, $foto_url_para_db);

            $arrUsers = $userModel->getUser($correo);
            $responseData = json_encode($arrUsers);
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

    public function verifyAction()
    {
        $strErrorDesc = '';
        $responseData = '';
        try {
            $requestMethod = $_SERVER["REQUEST_METHOD"];
            $inputData = json_decode(file_get_contents("php://input"), true);

            if (strtoupper($requestMethod) != 'POST') {
                throw new Exception("Method not supported.");
            }

            if (!isset($inputData['correo']) || !isset($inputData['contra'])) {
                throw new Exception("Invalid input.");
            }

            $correo = $inputData['correo'];
            $contra = $inputData['contra'];
            $userModel = new UserModel();
            $arrUsers = $userModel->getUser($correo);
            $userData = $arrUsers[0] ?? null;

            if ($userData && isset($userData['CONTRASEÑA_USUARIO'])) {
                $hash_from_db = $userData['CONTRASEÑA_USUARIO'];
                if (password_verify($contra, $hash_from_db)) {
                    $responseData = json_encode(["message" => "Credenciales válidas."]);
                    $statusHeader = 'HTTP/1.1 200 OK';
                } else {
                    $responseData = json_encode(["message" => "Credenciales no válidas."]);
                    $statusHeader = 'HTTP/1.1 401 Unauthorized';
                }
            } else {
                $responseData = json_encode(["message" => "Credenciales no válidas."]);
                $statusHeader = 'HTTP/1.1 401 Unauthorized';
            }
        } catch (Exception $e) {
            $strErrorDesc = $e->getMessage();
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }

        if (!$strErrorDesc) {
            $this->sendOutput($responseData, ['Content-Type: application/json', $statusHeader]);
        } else {
            $this->sendOutput(json_encode(["error" => $strErrorDesc]), ['Content-Type: application/json', $strErrorHeader]);
        }
    }
}
