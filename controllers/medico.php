<?php
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
        $array = array();
        for ($i = 0; $i < 5; $i++) {
            $array[$i]['id'] = $i;
            $array[$i]['nombre'] = "Nombre" . $i;
            $array[$i]['apellido'] = "Apellido" . $i;
            $array[$i]['edad'] = $i + 22;
        }
        // print_r(json_encode($resultado));
        print_r(json_encode($array));
        header('Content-type: application/json');
        exit();
    }
}
