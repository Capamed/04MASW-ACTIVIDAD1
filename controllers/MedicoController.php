<?php
require_once 'models/MedicoModel.php';
class MedicoController extends Controller
{
    function __construct()
    {
        parent::__construct();
        
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
        echo MedicoModel::GetAll();
    }

    function PostMedico()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            list($data, $prms, $model) = UIHTTP::ValidateWithModel($result, MedicoModel::PARAMS, MedicoModel::class);
            if (count($result->mensaje) == 0) {
                $result = MedicoModel::Post($model);
            }
        }
        echo json_encode($result);
    }
    function DeleteMedico()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validar = ['id_medico'];
            list($data, $prms, $model) = UIHTTP::ValidateWithModel($result, $validar, MedicoModel::class);
            if (count($result->mensaje) == 0) {
                $result = MedicoModel::Delete($model);
            }
        }
        echo json_encode($result);
    }
}

