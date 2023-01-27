<?php
include_once 'models/PacienteModel.php';
class PacienteController extends Controller
{
    function __construct()
    {
        parent::__construct();
        
    }
    function index()
    {
        $this->view->render('paciente/index');
    }
    function listar()
    {
        $this->view->render('paciente/listar');
    }

    function GetAllPaciente()
    {
        header('Content-type: application/json');
        echo PacienteModel::GetAll();
    }

    function PostPaciente()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            list($data, $prms, $model) = UIHTTP::ValidateWithModel($result, PacienteModel::PARAMS, PacienteModel::class);
            if (count($result->mensaje) == 0) {
                $result = PacienteModel::Post($model);
            }
        }
        echo json_encode($result);
    }
    function DeletePaciente()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validar = ['id_paciente'];
            list($data, $prms, $model) = UIHTTP::ValidateWithModel($result, $validar, PacienteModel::class);
            if (count($result->mensaje) == 0) {
                $result = PacienteModel::Delete($model);
            }
        }
        echo json_encode($result);
    }
}