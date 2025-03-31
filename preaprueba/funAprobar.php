<?php
include_once 'controlador.php';
$api = new ApiControlador();
$item = array(
    'idcontratacion' => $_POST['idcontratacion'],
    'observacion_pre_aprobacion' => $_POST['observacion_pre_aprobacion'],
    'fecha_pre_aperobacion' => $_POST['fecha_pre_aperobacion'],
);
$api->aprobarApi($item);
