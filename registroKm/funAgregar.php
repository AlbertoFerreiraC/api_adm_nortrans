<?php
include_once 'controlador.php';
$api = new ApiControlador();

$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);

$item = array(
    'centro_de_costo' => $datos->centro_de_costo,
    'tipo_bus'        => $datos->tipo_bus,
    'maquina'         => $datos->maquina,
    'descripcion' => trim(preg_replace('/\s+/', ' ', $datos->descripcion)),
    'km_anterior'     => $datos->km_anterior,
    'fecha_km'        => $datos->fecha_km,
    'km_actual'       => $datos->km_actual
);

$api->agregarApi($item);
