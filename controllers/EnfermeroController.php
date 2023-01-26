<?php
class EnfermeroController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $this->view->render('enfermero/listar');
    }
    function listar()
    {
        $this->view->render('enfermero/listar');
    }

    function GetAllEnfermero()
    {
        header('Content-type: application/json');
        echo UISQL::TableToJSON('select * from get_enfermero();');
    }

    function PostEnfermero()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validar = ['id_enfermero', 'numero_identificacion', 'nombre', 'apellido', 'telefono', 'correo_electronico'];
            list($data, $prms) = UIHTTP::Validate($result, $validar);
            if (count($result->mensaje) == 0) {
                $sql = "Usp_post_enfermero";
                $result = UISQL::Execute($sql, $prms);
            }
        }
        echo json_encode($result);
    }
    
    function DeleteEnfermero()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validar = ['id_enfermero'];
            list($data, $prms) = UIHTTP::Validate($result, $validar);
            if (count($result->mensaje) == 0) {
                $sql = "Usp_delete_enfermero";
                $result = UISQL::Execute($sql, $prms);
            }
        }
        echo json_encode($result);
    }
}
