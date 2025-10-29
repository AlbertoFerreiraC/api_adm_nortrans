<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // Conexión
    $db = new DB();
    $pdo = $db->connect();

    // Recibir ID de la OT
    $idOT = isset($_POST['idOT']) ? intval($_POST['idOT']) : 0;

    if ($idOT <= 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Falta el ID de la OT."
        ]);
        exit;
    }

    // ==========================================================
    // 🔹 1. CONSULTA DE CABECERA (JOIN entre asignaciones_ot, ot_interna y personal_tecnico)
    // ==========================================================
    $sqlCabecera = "
        SELECT 
            o.idot_interna,
            o.usuario AS creado_por,
            o.maquina,
            o.centro_de_costo,
            o.fecha,
            o.km_actual,
            o.estado,
            a.asignacion,
            a.fecha AS fecha_asignacion,
            a.observacion AS observacion_asignacion,
            a.fecha_finalizacion,
            COALESCE(pt.nombre, 'No asignado') AS tecnico_asignado,
            pt.telefono AS telefono_tecnico,
            pt.correo AS correo_tecnico
        FROM adm_nortrans.ot_interna o
        INNER JOIN adm_nortrans.asignaciones_ot a 
            ON o.idot_interna = a.ot_interna
        LEFT JOIN adm_nortrans.personal_tecnico pt 
            ON pt.idpersonal_tecnico = a.personal_tecnico
        WHERE o.idot_interna = :idOT
        LIMIT 1
    ";

    $stmtCab = $pdo->prepare($sqlCabecera);
    $stmtCab->bindParam(':idOT', $idOT, PDO::PARAM_INT);
    $stmtCab->execute();
    $cabecera = $stmtCab->fetch(PDO::FETCH_ASSOC);

    if (!$cabecera) {
        echo json_encode([
            "status" => "no_data",
            "message" => "No se encontró la cabecera de la OT."
        ]);
        exit;
    }

    // ==========================================================
    // 🔹 2. CONSULTA DE DETALLE (tareas_ot asociadas)
    // ==========================================================
    $sqlDetalle = "
        SELECT 
            idtareas_ot,
            ot_interna,
            tipo_tarea_mantencion,
            sistema_maquina,
            sub_sistema_maquina,
            fecha,
            observacion,
            estado
        FROM adm_nortrans.tareas_ot
        WHERE ot_interna = :idOT
        ORDER BY fecha ASC
    ";

    $stmtDet = $pdo->prepare($sqlDetalle);
    $stmtDet->bindParam(':idOT', $idOT, PDO::PARAM_INT);
    $stmtDet->execute();
    $detalle = $stmtDet->fetchAll(PDO::FETCH_ASSOC);

    // ==========================================================
    // 🔹 RESPUESTA JSON
    // ==========================================================
    echo json_encode([
        "status" => "ok",
        "data" => [
            "cabecera" => $cabecera,
            "detalle" => $detalle
        ]
    ], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error en la base de datos: " . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error general: " . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
