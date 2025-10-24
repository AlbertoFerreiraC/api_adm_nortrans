<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

$input = json_decode(file_get_contents("php://input"), true);

try {
    $db = new DB();
    $pdo = $db->connect();
    $pdo->beginTransaction();

    // 🔹 Cambio: "proveedo" → "proveedor"
    $stmt = $pdo->prepare("
        INSERT INTO servicio_externo (usuario, maquina, proveedor, fecha_ot, fecha_hora, estado)
        VALUES (:usuario, :maquina, :proveedor, :fecha_ot, :fecha_hora, :estado)
    ");

    $stmt->execute([
        ':usuario'    => $input['usuario'],
        ':maquina'    => $input['maquina'],
        ':proveedor'  => $input['proveedor'], // ← también aquí
        ':fecha_ot'   => $input['fecha_ot'],
        ':fecha_hora' => $input['fecha_hora'],
        ':estado'     => $input['estado']
    ]);

    $idServicio = $pdo->lastInsertId();

    $stmtDetalle = $pdo->prepare("
        INSERT INTO detalle_servicio_externo (servicio_externo, sistema_maquina, sub_sistema_maquina, observacion)
        VALUES (:servicio_externo, :sistema_maquina, :sub_sistema_maquina, :observacion)
    ");

    foreach ($input['tareas'] as $tarea) {
        $stmtDetalle->execute([
            ':servicio_externo'   => $idServicio,
            ':sistema_maquina'    => $tarea['sistema_maquina'],
            ':sub_sistema_maquina' => $tarea['sub_sistema_maquina'],
            ':observacion'        => $tarea['observacion']
        ]);
    }

    $pdo->commit();

    echo json_encode(["mensaje" => "ok"]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo json_encode(["mensaje" => "nok", "error" => $e->getMessage()]);
}
