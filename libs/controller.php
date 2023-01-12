<?php
class Controller
{
    public $view;
    function __construct()
    {
        // echo "<p>Controllador base</p>";
        $this->view = new View();
    }
}
