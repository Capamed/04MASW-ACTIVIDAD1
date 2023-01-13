<?php

require_once 'controllers/errores.php';

class App
{
    function __construct()
    {
        // var_dump($URL);
        // $GLOBALS["URL"] = $URL;
        // $GLOBALS["PATH_SHARED"] = "{$URL}views/shared/";
        // $GLOBALS["PATH_IMG"] = "{$URL}assets/img/";
        // $GLOBALS["PATH_HEADER"] = $GLOBALS["PATH_SHARED"] . 'header.php';
        // $GLOBALS["PATH_FOOTER"] = $GLOBALS["PATH_SHARED"] . 'footer.php';

        $url = '';
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
        }
        // var_dump($url);
        // var_dump($_GET);
        // var_dump($_SERVER["SERVER_NAME"]);
        // var_dump($_SERVER["PHP_SELF"]);
        // var_dump($_SERVER);

        if (empty($url)) {
            $url = 'main';
            // return;
        }

        $url = rtrim($url, '/');
        $url = explode('/', $url);

        // var_dump($url);

        $archivoController = 'controllers/' . $url[0] . '.php';
        if (file_exists($archivoController)) {
            // var_dump($archivoController);
            // var_dump($url);
            require_once $archivoController;
            $controller = new $url[0];
            if (!isset($url[1])) {
                $url[1] = 'index';
            }
            $controller->{$url[1]}();
        } else {
            $controller = new Errores();
        }
    }
}
