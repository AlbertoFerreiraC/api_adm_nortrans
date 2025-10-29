<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    $db = new DB();
    $pdo = $db->connect();

    // Recibir datos
    $idAsignacion = isset($_POST['idAsignacion']) ? intval($_POST['idAsignacion']) : 0;
    $observacion = isset($_POST['observacion']) ? trim($_POST['observacion']) : '';

    if ($idAsignacion <= 0) {
        echo json_encode(["status" => "error", "message" => "Falta el ID de la asignación."]);
        exit;
    }

    // Fecha actual del sistema (Paraguay)
    $fechaFinalizacion = date('Y-m-d H:i:s');

    // ==========================================================
    // 🔹 Actualizar la asignación con observación y fecha final
    // ==========================================================
    $sql = "
        UPDATE adm_nortrans.asignaciones_ot
        SET 
            observacion = :observacion,
            fecha_finalizacion = :fecha_finalizacion
        WHERE idasignaciones_ot = :idAsignacion
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':observacion', $observacion);
    $stmt->bindParam(':fecha_finalizacion', $fechaFinalizacion);
    $stmt->bindParam(':idAsignacion', $idAsignacion, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // También podemos actualizar el estado de la OT (opcional)
        $sqlEstado = "
            UPDATE adm_nortrans.ot_interna
            SET estado = 'Finalizado'
            WHERE idot_interna = (
                SELECT ot_interna FROM adm_nortrans.asignaciones_ot WHERE idasignaciones_ot = :idAsignacion
            )
        ";
        $stmtEstado = $pdo->prepare($sqlEstado);
        $stmtEstado->bindParam(':idAsignacion', $idAsignacion, PDO::PARAM_INT);
        $stmtEstado->execute();

        echo json_encode([
            "status" => "ok",
            "message" => "La tarea fue finalizada correctamente.",
            "fecha_finalizacion" => $fechaFinalizacion
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No se pudo actualizar la asignación."
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error en la base de datos: " . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error general: " . $e->getMessage()
    ]);
}
