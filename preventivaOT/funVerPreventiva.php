<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // Validar parámetro
    if (!isset($_POST['idPreventiva']) || empty($_POST['idPreventiva'])) {
        echo json_encode(['status' => 'error', 'msg' => 'Falta el ID de la OT preventiva.']);
        exit;
    }

    $id = intval($_POST['idPreventiva']);

    // Conexión usando la clase DB
    $db = new DB();
    $pdo = $db->connect();

    // =========================
    // CABECERA (ot_interna)
    // =========================
    $sqlCab = "
        SELECT 
            o.idot_interna AS id_preventiva,
            o.usuario,
            o.maquina,
            o.centro_de_costo,
            o.fecha,
            o.km_actual,
            o.estado
        FROM ot_interna o
        WHERE o.idot_interna = :id
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sqlCab);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $cabecera = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cabecera) {
        echo json_encode(['status' => 'no_data']);
        exit;
    }

    // =========================
    // DETALLE (tareas_ot)
    // =========================
    $sqlDet = "
        SELECT 
            t.idtareas_ot,
            t.personal_tecnico,
            t.tipo_tarea_mantencion,
            t.sistema_maquina,
            t.sub_sistema_maquina,
            t.fecha,
            t.observacion,
            t.estado
        FROM tareas_ot t
        WHERE t.ot_interna = :id
        ORDER BY t.fecha DESC
    ";

    $stmtDet = $pdo->prepare($sqlDet);
    $stmtDet->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtDet->execute();

    $tareas = $stmtDet->fetchAll(PDO::FETCH_ASSOC);
    $cabecera['tareas'] = $tareas ?: [];

    // =========================
    // RESPUESTA
    // =========================
    echo json_encode(['status' => 'ok', 'data' => $cabecera]);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'msg' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'msg' => 'Error general: ' . $e->getMessage()
    ]);
}
