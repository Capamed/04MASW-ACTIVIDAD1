<?php
include_once 'models/EspecialidadModel.php';
class EspecialidadController extends Controller
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
        echo EspecialidadModel::GetAll();
    }

    function PostEspecialidad()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // $validar = ['id_especialidad', 'nombre'];
            list($data, $prms, $model) = UIHTTP::ValidateWithModel($result, EspecialidadModel::PARAMS, EspecialidadModel::class);
            if (count($result->mensaje) == 0) {
                $result = EspecialidadModel::Post($model);
            }
        }
        echo json_encode($result);
    }
}
