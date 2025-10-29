<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    if (!isset($_POST['ot_interna']) || empty($_POST['ot_interna'])) {
        echo json_encode(['status' => 'error', 'message' => 'Falta el ID de la OT.']);
        exit;
    }

    if (!isset($_POST['asignacion']) || empty($_POST['asignacion'])) {
        echo json_encode(['status' => 'error', 'message' => 'Debe seleccionar un tipo de asignación.']);
        exit;
    }

    $ot_interna = intval($_POST['ot_interna']);
    $asignacion = trim($_POST['asignacion']);
    $personal_tecnico = !empty($_POST['personal_tecnico']) ? intval($_POST['personal_tecnico']) : null;

    $db = new DB();
    $pdo = $db->connect();

    $sqlInsert = "
        INSERT INTO asignaciones_ot (
            ot_interna,
            personal_tecnico,
            fecha,
            asignacion
        )
        VALUES (
            :ot_interna,
            :personal_tecnico,
            NOW(),
            :asignacion
        )
    ";

    $stmt = $pdo->prepare($sqlInsert);
    $stmt->bindParam(':ot_interna', $ot_interna, PDO::PARAM_INT);

    if ($personal_tecnico !== null) {
        $stmt->bindParam(':personal_tecnico', $personal_tecnico, PDO::PARAM_INT);
    } else {
        $stmt->bindValue(':personal_tecnico', null, PDO::PARAM_NULL);
    }

    $stmt->bindParam(':asignacion', $asignacion, PDO::PARAM_STR);
    $stmt->execute();

    $insertId = $pdo->lastInsertId();

    // Ejemplo: marcar tarea como "asignada"
    if (isset($_POST['idTarea']) && !empty($_POST['idTarea'])) {
        $idTarea = intval($_POST['idTarea']);
        $sqlUpdate = "UPDATE tareas_ot SET estado = 'asignada' WHERE idtareas_ot = :idTarea";
        $stmtUpd = $pdo->prepare($sqlUpdate);
        $stmtUpd->bindParam(':idTarea', $idTarea, PDO::PARAM_INT);
        $stmtUpd->execute();
    }

    echo json_encode([
        'status' => 'ok',
        'message' => 'Asignación registrada correctamente.',
        'id_asignacion' => $insertId
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error general: ' . $e->getMessage()
    ]);
}
