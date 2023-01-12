<?php
class Medico extends Controller{
    function __construct()
    {
        parent::__construct();
        $this->view->render('medico/index');
    }
}