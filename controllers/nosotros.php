<?php
class Nosotros extends Controller{
    function __construct()
    {
        parent::__construct();
        
    }
    function index(){
        $this->view->render('nosotros/index');
    }

    function saludo()
    {
        echo "<p>Ejecutándose el método Saludo</p>";
    }
    
}