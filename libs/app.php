<?php

require_once 'controllers/errores.php';

class App
{
    function __construct()
    {
        //  echo '<p>Nueva app</p>';
        $GLOBALS["PATH_SHARED"] = './views/shared/';
        $GLOBALS["PATH_IMG"] = './assets/img/';
        $GLOBALS["PATH_HEADER"] = $GLOBALS["PATH_SHARED"] . 'header.php';
        $GLOBALS["PATH_FOOTER"] = $GLOBALS["PATH_SHARED"] . 'footer.php';

        $url = '';
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
        }
        // var_dump($url);
        // var_dump($_GET);

        if (empty($url)) {
            $url = 'main';
            // return;
        }

        $url = rtrim($url, '/');
        $url = explode('/', $url);

        $archivoController = 'controllers/' . $url[0] . '.php';
        if (file_exists($archivoController)) {
            require_once $archivoController;
            $controller = new $url[0];
            if (isset($url[1])) {
                $controller->{$url[1]}();
            }
        } else {
            $controller = new Errores();
        }
    }
}
