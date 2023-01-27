<?php
class Home extends Controller{
    function __construct()
    {
        parent::__construct();
        
    }
    function index(){
        $this->view->render('home/index');
    }

    function saludo()
    {
        echo "<p>Ejecutándose el método Saludo</p>";
    }
    
}