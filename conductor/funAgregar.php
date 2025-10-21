<?php
include_once 'controlador.php';
$api = new ApiControlador();

$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);

// ⚠️ Validar que el JSON llegó bien
if (!$datos) {
    echo json_encode(["mensaje" => "error_json_vacio"]);
    exit;
}

$item = array(
    'rut' => $datos->rut ?? '',
    'nombre' => $datos->nombre ?? '',
    'telefono' => $datos->telefono ?? '',
    'correo' => $datos->correo ?? ''
);

$api->agregarApi($item);
