<?php
include_once 'controlador.php';
$api = new ApiControlador();
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos);

if (!$datosRecibidos) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'No se recibieron datos']);
    exit;
}

if ($datos === null) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'Error al decodificar JSON: ' . json_last_error_msg()]);
    exit;
}
if (!isset($datos->idcontratacion) || empty($datos->idcontratacion)) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'ID no proporcionado']);
    exit;
}

$item = array(
    'id' => $datos->idcontratacion
);
$api->aprobarApi($item);
