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
            list($data, $prms, $model) = UIHTTP::ValidateWithModel($result, CitaModel::PARAMS, CitaModel::class);
            if (count($result->mensaje) == 0) {
                $result = CitaModel::Post($model);
            }
        }
        echo json_encode($result);
    }
    
}
