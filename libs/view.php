<?php
class View
{
    public $random;
    public $path;
    public $path_shared;
    public $path_img;
    public $path_header;
    public $path_footer;
    function __construct()
    {
        // echo "<p>View base</p>";
        $d2 = new DateTime();
        $random = $d2->format('YmdHisu');

        $this->random = $random;

        $this->path = "http://localhost/REPOSITORIO_PHP_ACTIVIDADES/04MASW-ACTIVIDAD1/";
        $this->path_shared = $this->path . "views/shared/";
        $this->path_img = $this->path . "assets/img/";
        $this->path_header = $this->path_shared . "header.php";
        $this->path_footer = $this->path_shared . "footer.php";
    }

    function render($nombre)
    {
        // ob_end_clean();
        // ob_start();
        require 'views/' . $nombre . '.php';
    }
}
