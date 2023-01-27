<?php
include_once 'models/EnfermeroModel.php';
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
        echo EnfermeroModel::GetAll();
    }

    function PostEnfermero()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            list($data, $prms, $model) = UIHTTP::ValidateWithModel($result, EnfermeroModel::PARAMS, EnfermeroModel::class);
            if (count($result->mensaje) == 0) {
                $result = EnfermeroModel::Post($model);
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
            list($data, $prms, $model) = UIHTTP::ValidateWithModel($result, $validar, EnfermeroModel::class);
            if (count($result->mensaje) == 0) {
                $result = EnfermeroModel::Delete($model);
            }
        }
        echo json_encode($result);
    }
}
