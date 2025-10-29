<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // ================================
    // 🔹 CONEXIÓN
    // ================================
    $db = new DB();
    $pdo = $db->connect();

    // ================================
    // 🔹 DATOS RECIBIDOS
    // ================================
    $idOT = isset($_POST['idOT']) ? intval($_POST['idOT']) : 0;

    if ($idOT <= 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Falta el ID de la orden de trabajo."
        ]);
        exit;
    }

    // ================================
    // 🔹 CONSULTA DE CABECERA
    // ================================
    $sqlCabecera = "
        SELECT 
            a.idasignaciones_ot,
            o.idot_interna,
            o.usuario,
            o.maquina,
            o.centro_de_costo,
            o.fecha,
            o.km_actual,
            o.estado,
            a.asignacion,
            a.fecha AS fecha_asignacion,
            a.observacion AS observacion_asignacion,
            a.fecha_finalizacion,
            COALESCE(p.nombre, 'No asignado') AS tecnico_asignado
        FROM adm_nortrans.asignaciones_ot a
        INNER JOIN adm_nortrans.ot_interna o ON o.idot_interna = a.ot_interna
        LEFT JOIN adm_nortrans.personal_tecnico p ON p.idpersonal_tecnico = a.personal_tecnico
        WHERE a.ot_interna = :idOT
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sqlCabecera);
    $stmt->bindParam(':idOT', $idOT, PDO::PARAM_INT);
    $stmt->execute();
    $cabecera = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cabecera) {
        echo json_encode([
            "status" => "no_data",
            "message" => "No se encontró la cabecera de la OT."
        ]);
        exit;
    }

    // ================================
    // 🔹 CONSULTA DE DETALLE (TAREAS)
    // ================================
    $sqlDetalle = "
        SELECT 
            t.idtareas_ot,
            t.fecha,
            COALESCE(pt.nombre, 'No asignado') AS personal_tecnico,
            t.tipo_tarea_mantencion,
            t.sistema_maquina,
            t.sub_sistema_maquina,
            t.observacion,
            t.estado
        FROM adm_nortrans.tareas_ot t
        LEFT JOIN adm_nortrans.personal_tecnico pt 
            ON pt.idpersonal_tecnico = t.personal_tecnico
        WHERE t.ot_interna = :idOT
        ORDER BY t.fecha ASC
    ";

    $stmt = $pdo->prepare($sqlDetalle);
    $stmt->bindParam(':idOT', $idOT, PDO::PARAM_INT);
    $stmt->execute();
    $detalle = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ================================
    // 🔹 RESPUESTA JSON FINAL
    // ================================
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
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Error general: " . $e->getMessage()
    ]);
}
