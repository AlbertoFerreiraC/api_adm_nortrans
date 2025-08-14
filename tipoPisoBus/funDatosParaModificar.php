<?php
include_once 'controlador.php';
$api = new ApiControlador();
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);
$item = array(
    'idtipo_piso_bus' => $datos->idtipo_piso_bus,
);
$api->obtenerDatosParaModificarApi($item);
