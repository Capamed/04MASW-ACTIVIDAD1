<?php
include_once 'models/CitaModel.php';
class CitaController extends Controller
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

    function PostCita()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            list($data, $prms) = UIHTTP::ValidateWithModel($result, CitaModel::PARAMS,CitaModel::class);
            if (count($result->mensaje) == 0) {
                $result = CitaModel::Post($model);
            }
        }
        echo json_encode($result);
    }
    
    function DeleteCita()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validar = ['id_enfermero'];
            list($data, $prms) = UIHTTP::Validate($result, $validar);
            if (count($result->mensaje) == 0) {
                $sql = "Usp_delete_cita";
                $result = UISQL::Execute($sql, $prms);
            }
        }
        echo json_encode($result);
    }
}
