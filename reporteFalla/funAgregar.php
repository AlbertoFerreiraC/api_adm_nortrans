<?php
include_once 'controlador.php';

file_put_contents('debug_reporte.log', "\n=============================\n📥 INICIO funAgregar.php\n=============================\n", FILE_APPEND);

$api = new ApiControlador();

$datosRecibidos = file_get_contents("php://input");
file_put_contents('debug_reporte.log', "Datos RAW recibidos:\n" . $datosRecibidos . "\n", FILE_APPEND);

$datos = json_decode($datosRecibidos, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    file_put_contents('debug_reporte.log', "❌ Error al decodificar JSON: " . json_last_error_msg() . "\n", FILE_APPEND);
}

if (
    !isset($datos['usuario']) ||
    !isset($datos['maquina']) ||
    !isset($datos['conductor']) ||
    !isset($datos['km_reportado'])
) {
    file_put_contents('debug_reporte.log', "⚠️ Datos incompletos detectados en funAgregar\n", FILE_APPEND);
    echo json_encode(['mensaje' => 'datos_incompletos']);
    exit;
}

$item = array(
    'usuario'      => intval($datos['usuario']),
    'dependencia'  => 1,
    'maquina'      => intval($datos['maquina']),
    'conductor'    => intval($datos['conductor']),
    'km_reportado' => $datos['km_reportado'],
    'fecha'        => date("Y-m-d H:i:s"),
    'estado'       => 'activo'
);

file_put_contents('debug_reporte.log', "📦 Datos preparados para insertar CABECERA:\n" . json_encode($item) . "\n", FILE_APPEND);

ob_start();
$api->agregarApi($item);
$respuesta = ob_get_clean();

file_put_contents('debug_reporte.log', "💬 Respuesta desde controlador.agregarApi:\n{$respuesta}\n", FILE_APPEND);

if (!empty($respuesta)) {
    echo $respuesta;
} else {
    file_put_contents('debug_reporte.log', "❌ No se recibió respuesta del controlador\n", FILE_APPEND);
    echo json_encode(['mensaje' => 'nok', 'idreporte_falla' => null]);
}

file_put_contents('debug_reporte.log', "✅ Fin de ejecución funAgregar.php\n", FILE_APPEND);
