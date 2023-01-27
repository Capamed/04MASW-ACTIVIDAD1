<?php
class Color extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $this->view->render('color/listar');
    }
    function listar()
    {
        $this->view->render('color/listar');
    }

    function GetAllColor()
    {
        header('Content-type: application/json');
        echo UISQL::TableToJSON('select * from get_color();');
    }

    function PostColor()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validar = ['id_color', 'nombre'];
            list($data, $prms) = UIHTTP::Validate($result, $validar);
            if (count($result->mensaje) == 0) {
                $sql = "Usp_post_color";
                $result = UISQL::Execute($sql, $prms);
            }
        }
        echo json_encode($result);
    }
    function DeleteColor()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validar = ['id_color'];
            list($data, $prms) = UIHTTP::Validate($result, $validar);
            if (count($result->mensaje) == 0) {
                $sql = "Usp_delete_color";
                $result = UISQL::Execute($sql, $prms);
            }
        }
        echo json_encode($result);
    }
}
