<?php

require_once 'models/TransactionEN.php';

class Medico extends Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->view->render('medico/index');
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
        echo UISQL::TableToJSON('select * from medico m order by id_medico limit 10;');
    }

    function PostMedico()
    {
        header('Content-type: application/json');
        $result = new TransactionEN();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            list($data, $prms) = UIHTTP::Validate($result, ['id_medico', 'nombre', 'apellido']);
            if (count($result->mensaje) == 0) {
                $sql = "UPDATE medico SET nombre=:nombre, apellido=:apellido WHERE id_medico=:id_medico;";
                // if (empty($data['id_medico'])) {
                //     $sql = "INSERTasdas da";
                // }
                // if ($data['id_medico'] == 'A') {
                // }
                $result = UISQL::Execute($sql, $prms);
            }
        }
        echo json_encode($result);
    }
}


// header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
// header("HTTP/1.0 404 Not Found");
// http_response_code($response_code);
// http_response_code(200);

// echo $data['nombre'] ?? 'asd';
// $data = [
//     'name' => $name,
//     'surname' => $surname,
//     'sex' => $sex,
//     'id' => $id,
// ];
// $sql = "UPDATE users SET name=:name, surname=:surname, sex=:sex WHERE id=:id";
// [$name, $surname, $sex, $id]
// $sql = "UPDATE users SET name=?, surname=?, sex=? WHERE id=?";