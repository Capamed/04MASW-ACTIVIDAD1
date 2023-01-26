<?php
class Historial extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $this->view->render('historial/listar');
    }
    function listar()
    {
        $this->view->render('historial/listar');
    }

    function GetAllPaciente()
    {
        header('Content-type: application/json');
        echo UISQL::TableToJSON('select * from get_paciente();');
    }
}
