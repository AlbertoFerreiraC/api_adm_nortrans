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
$datos = json_decode($datosRecibidos, true);

// Verificar si la decodificación fue exitosa
if ($datos === null) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'Error al decodificar JSON: ' . json_last_error_msg()]);
    exit;
}

// Verificar si el ID y el comentario están presentes
if (!isset($datos['id']) || empty($datos['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'ID no proporcionado']);
    exit;
}

if (!isset($datos['comentario']) || empty(trim($datos['comentario']))) {
    header('Content-Type: application/json');
    echo json_encode(['mensaje' => 'nok', 'error' => 'Comentario no proporcionado']);
    exit;
}

// Crear el objeto API y procesar la solicitud
$api = new ApiControlador();
$item = array(
    'id' => $datos['id'],
    'comentario' => $datos['comentario']
);

// Llamar al método para anular
$api->AnularApi($item);
