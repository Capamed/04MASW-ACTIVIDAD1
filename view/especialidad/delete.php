<?php
    require_once("/Users/marcotintinduran/Desktop/prueba1/controller/especialidadController.php");
    $controller = new especialidadController();
    echo $_GET['id'];
    $controller->delete($_GET['id']);
?>