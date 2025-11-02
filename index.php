<?php
include "inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode('/', $uri);

if ($uri[3] === 'user') {
    include "Controller/Api/UserController.php";
    $objFeedController = new UserController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
} else if ($uri[3] === 'publicacion') {
    include "Controller/Api/PublicacionController.php";
    $objFeedController = new PublicacionController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
} else if ($uri[3] === 'favorito') {
    include "Controller/Api/FavoritoController.php";
    $objFeedController = new FavoritoController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
} else if ($uri[3] != 'user' && $uri[3] != 'publicacion') {
    header("HTTP/1.1 404 Not Found");
    exit();
}