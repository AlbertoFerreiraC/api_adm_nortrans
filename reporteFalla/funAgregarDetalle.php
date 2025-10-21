<?php
include_once 'controlador.php';

file_put_contents('debug_reporte.log', "\n=============================\n📥 INICIO funAgregarDetalle.php\n=============================\n", FILE_APPEND);

$api = new ApiControlador();

// Leer cuerpo JSON del POST
$datosRecibidos = file_get_contents("php://input");
file_put_contents('debug_reporte.log', "📨 Datos RAW recibidos en funAgregarDetalle:\n" . $datosRecibidos . "\n", FILE_APPEND);

$datos = json_decode($datosRecibidos, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    file_put_contents('debug_reporte.log', "❌ Error al decodificar JSON: " . json_last_error_msg() . "\n", FILE_APPEND);
}

// Validar datos mínimos
if (!isset($datos['idreporte_falla']) || empty($datos['detalle'])) {
    file_put_contents('debug_reporte.log', "⚠️ Datos incompletos detectados en funAgregarDetalle\n", FILE_APPEND);
    echo json_encode(['mensaje' => 'datos_incompletos']);
    exit;
}

$idReporte = intval($datos['idreporte_falla']);
$detalles = $datos['detalle'];

file_put_contents('debug_reporte.log', "🧩 ID Reporte recibido: {$idReporte}\n", FILE_APPEND);
file_put_contents('debug_reporte.log', "📦 Detalles recibidos:\n" . json_encode($detalles, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);

// Llamar al controlador
$resultado = $api->agregarDetalleApi($idReporte, $detalles);

file_put_contents('debug_reporte.log', "💬 Resultado de agregarDetalleApi(): {$resultado}\n", FILE_APPEND);

// Retornar resultado al frontend
echo json_encode(['mensaje' => $resultado]);

file_put_contents('debug_reporte.log', "✅ Fin de ejecución funAgregarDetalle.php\n", FILE_APPEND);
