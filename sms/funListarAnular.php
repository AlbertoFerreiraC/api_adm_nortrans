<?php
include_once 'controlador.php';
$api = new ApiControlador();

$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos, true);

if (!$datos || !isset($datos['id']) || empty($datos['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'ID no proporcionado']);
    exit;
}

$item = array(
    'id' => $datos['id']
);

$api->listarAnularApi($item);
