<?php
class Cita extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $this->view->render('cita/listar');
    }
    function listar()
    {
        $this->view->render('cita/listar');
    }

    function GetAllCita()
    {
        header('Content-type: application/json');
        echo UISQL::TableToJSON('select * from get_citas();');
    }
}
