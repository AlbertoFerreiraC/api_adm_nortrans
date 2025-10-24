<?php
include_once 'controlador.php';
$api = new ApiControlador();

$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);

// Validar que se haya recibido correctamente la máquina
if (!isset($datos->maquina)) {
    echo json_encode(["mensaje" => "error_datos"]);
    exit;
}

$item = array(
    'idmaquina'       => $datos->maquina,
    'centro_de_costo' => $datos->centro_de_costo,
    'tipo_bus'        => $datos->tipo_bus,
    'descripcion'     => trim(preg_replace('/\s+/', ' ', $datos->descripcion)),
    'km_anterior'     => $datos->km_anterior,
    'fecha_km'        => $datos->fecha_km,
    'km_actual'       => $datos->km_actual
);

$api->modificarApi($item);
