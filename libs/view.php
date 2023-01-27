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
        
        $d2 = new DateTime();
        $random = $d2->format('YmdHisu');

        $this->random = $random;

        // $this->path = "http://localhost/VIU/BackEnd/04MASW-ACTIVIDAD1/";
        $this->path = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}:{$_SERVER['SERVER_PORT']}" . str_replace("index.php", "", "{$_SERVER['PHP_SELF']}");
        $this->path_shared = $this->path . "views/shared/";
        $this->path_img = $this->path . "assets/img/";
        $this->path_header = $this->path_shared . "header.php";
        $this->path_footer = $this->path_shared . "footer.php";
    }

    function render($nombre)
    {
       
        $HTML = file_get_contents('views/' . $nombre . '.php', true);
        $HTML = trim($HTML);
        $HTML = str_replace("{{URL}}", $this->path, $HTML);
        $HTML = str_replace("{{RANDOM}}", $this->random, $HTML);
        eval('?>' . $HTML . '<?php');
    }
}
