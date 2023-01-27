<?php

require_once 'controllers/errores.php';

class App
{
    function __construct()
    {
        $url = '';
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
        }


        if (empty($url)) {
            $url = 'main';
        }

        $url = rtrim($url, '/');
        $url = explode('/', $url);

        $nombreController = $url[0];
        
        $archivoController = 'controllers/' . $nombreController . '.php';
        if (!file_exists($archivoController)) {
            $nombreController = $url[0]."Controller";
            $archivoController = 'controllers/' . $nombreController . '.php';
        }
        if (file_exists($archivoController)) {            
            require_once $archivoController;
            $controller = new $nombreController;
            if (!isset($url[1])) {
                $url[1] = 'index';
            }
            $controller->{$url[1]}();
        } else {
            $controller = new Errores();
        }
    }
}
