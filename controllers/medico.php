<?php
class Medico extends Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->view->render('medico/index');
    }
    function index()
    {
        $this->view->render('medico/index');
    }
    function listar()
    {
        $this->view->render('medico/listar');
    }

    function GetAllMedico()
    {
        header('Content-type: application/json');
        $resultado = UISQL::ejecutarSQL('select * from medico m ;');
        echo json_encode($resultado);
        exit();
    }
}
