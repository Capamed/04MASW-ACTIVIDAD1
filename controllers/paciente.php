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
}