<?php
include_once 'controlador.php';
$api = new ApiControlador();

$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);

$item = array(
    'idregistro_km' => $datos->idregistro_km
);

$api->eliminarApi($item);
