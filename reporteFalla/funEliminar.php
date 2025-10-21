<?php
include_once 'controlador.php';

$api = new ApiControlador();

// Leer cuerpo JSON del POST
$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos, true); // ✅ array asociativo

// Validar que venga el ID
if (!isset($datos['id']) || empty($datos['id'])) {
    echo json_encode(['mensaje' => 'id_no_enviado']);
    exit;
}

// Preparar arreglo
$item = array('id' => $datos['id']);

// Ejecutar eliminación
$api->eliminarApi($item);
?>
