<?php
include_once 'controlador.php';

// Capturar el cuerpo de la solicitud
$datosRecibidos = file_get_contents("php://input");

// Verificar si hay datos recibidos
if (!$datosRecibidos) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'No se recibieron datos']);
    exit;
}

// Decodificar los datos JSON
$datos = json_decode($datosRecibidos);

// Verificar si la decodificación fue exitosa
if ($datos === null) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'Error al decodificar JSON: ' . json_last_error_msg()]);
    exit;
}

// Verificar si el ID está presente
if (!isset($datos->id) || empty($datos->id)) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'ID no proporcionado']);
    exit;
}

// Crear el objeto API y procesar la solicitud
$api = new ApiControlador();
$item = array(
    'id' => $datos->id
);

// Llamar al método para modificar
$api->modificarApi($item);
