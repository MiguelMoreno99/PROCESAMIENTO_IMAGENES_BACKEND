<?php
include "inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode('/', $uri);

if ($uri[3] === 'user') {
    include "Controller/Api/UserController.php";
    $objFeedController = new UserController();
    $strMethodName = $uri[4] . 'Action';
    $objFeedController->{$strMethodName}();
} else if ($uri[3] === 'album') {
    include "Controller/Api/AlbumController.php";
    $objFeedController = new AlbumController();
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

//Si hay tiempo, agregar EstampaController para manejar estampas de forma individual