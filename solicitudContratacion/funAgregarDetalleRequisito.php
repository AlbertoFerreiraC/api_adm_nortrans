<?php
include_once 'controlador.php';
$api = new ApiControlador();
$item = array(
    'contratacion' => $_POST['id'],
    'requisito' => $_POST['requisito'],
    'observacion' => $_POST['observacion']
);
$api->agregarRequisitoDetalleApi($item);
