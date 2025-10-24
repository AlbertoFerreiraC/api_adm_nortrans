<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // Conexión
    $db = new DB();
    $pdo = $db->connect();

    // Leer datos del cuerpo (POST JSON)
    $input = json_decode(file_get_contents("php://input"), true);
    $idservicio = $input['idservicio_externo'] ?? null;

    if (!$idservicio) {
        echo json_encode([
            "mensaje" => "nok",
            "error" => "ID de servicio externo no proporcionado"
        ]);
        exit;
    }

    $pdo->beginTransaction();

    // Primero eliminar detalles asociados
    $stmtDetalle = $pdo->prepare("DELETE FROM detalle_servicio_externo WHERE servicio_externo = :id");
    $stmtDetalle->execute([':id' => $idservicio]);

    // Luego eliminar el registro principal
    $stmt = $pdo->prepare("DELETE FROM servicio_externo WHERE idservicio_externo = :id");
    $stmt->execute([':id' => $idservicio]);

    $pdo->commit();

    echo json_encode(["mensaje" => "ok"]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode([
        "mensaje" => "nok",
        "error" => $e->getMessage()
    ]);
}
