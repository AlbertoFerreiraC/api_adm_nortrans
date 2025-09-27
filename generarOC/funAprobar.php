<?php
include_once 'controlador.php';

$datosRecibidos = file_get_contents("php://input");

if (!$datosRecibidos) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'No se recibieron datos']);
    exit;
}

$datos = json_decode($datosRecibidos);

if ($datos === null) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'Error al decodificar JSON: ' . json_last_error_msg()]);
    exit;
}

if (!isset($datos->id) || empty($datos->id)) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'ID no proporcionado']);
    exit;
}

$api = new ApiControlador();
$item = array(
    'id' => $datos->id
);

$api->aprobarApi($item);
