<?php
class Especialidad extends Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->view->render('especialidad/index');
    }
    function index()
    {
        $this->view->render('especialidad/listar');
    }
    function listar()
    {
        $this->view->render('especialidad/listar');
    }

    function GetAllEspecialidad()
    {
        header('Content-type: application/json');
        echo UISQL::TableToJSON('select * from get_especialidad();');
    }

    function PostEspecialidad()
    {
        header('Content-type: application/json');        
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validar = ['id_especialidad', 'nombre'];
            list($data, $prms) = UIHTTP::Validate($result, $validar);
            if (count($result->mensaje) == 0) {
                $sql = "Usp_post_especialidad";
                $result = UISQL::Execute($sql, $prms);
            }
        }
        echo json_encode($result);
    }
}
