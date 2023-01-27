<?php
class ReporteController extends Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->view->render('paciente/index');
    }
    function index()
    {
        $this->view->render('reporte/index');
    }
    function GetCitaAnual()
    {
        // var_dump("{$_SERVER['HTTP_HOST']}:{$_SERVER['SERVER_PORT']}{$_SERVER['PHP_SELF']}");
         var_dump($_SERVER);
        $anio = isset($_GET['anio']) ? $_GET['anio'] : '0';
        header('Content-type: application/json');
        echo UISQL::TableToJSON("SELECT * FROM rep_cita_anual($anio);");
    }
}
