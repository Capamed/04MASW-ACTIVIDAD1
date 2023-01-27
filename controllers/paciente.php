<?php
class Paciente extends Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->view->render('paciente/index');
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
        $estado = isset($_GET['estado']) ? $_GET['estado'] : '';
        header('Content-type: application/json');
        echo UISQL::TableToJSON("select * from get_paciente('{$estado}');");
    }

    function PostPaciente()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validar = ['id_paciente', 'nombre', 'apellido', 'sexo', 'telefono', 'direccion', 'correo_electronico', 'fecha_nacimiento', 'estado'];
            list($data, $prms) = UIHTTP::Validate($result, $validar);
            if (count($result->mensaje) == 0) {
                $sql = "Usp_post_paciente";
                $result = UISQL::Execute($sql, $prms);
            }
        }
        echo json_encode($result);
    }
}
