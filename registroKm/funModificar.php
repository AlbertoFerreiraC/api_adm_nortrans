<?php
include_once 'controlador.php';
$api = new ApiControlador();

$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);

// Aceptamos tanto "id" como "idregistro_km"
$idregistro_km = isset($datos->idregistro_km) ? $datos->idregistro_km : $datos->id;

$item = array(
    'idregistro_km'   => $idregistro_km,
    'centro_de_costo' => $datos->centro_de_costo,
    'tipo_bus'        => $datos->tipo_bus,
    'maquina'         => $datos->maquina,
    'descripcion'     => $datos->descripcion,
    'km_anterior'     => $datos->km_anterior,
    'fecha_km'        => $datos->fecha_km,
    'km_actual'       => $datos->km_actual
);

$api->modificarApi($item);
