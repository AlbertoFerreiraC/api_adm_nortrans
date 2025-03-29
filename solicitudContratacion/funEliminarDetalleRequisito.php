<?php
include_once 'controlador.php';
$api = new ApiControlador();
$item = array(
    'contratacion' => $_POST['id']
);
$api->eliminarDetalleRequisitoApi($item);
