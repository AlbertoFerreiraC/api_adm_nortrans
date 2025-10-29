<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    $db = new DB();
    $pdo = $db->connect();

    // ============================================
    // 🔹 CONSULTA PRINCIPAL (cabeceras asignadas)
    // ============================================
    $sql = "
        SELECT 
            a.idasignaciones_ot,
            a.ot_interna AS numero_ot,
            o.maquina,
            o.centro_de_costo,
            o.usuario AS creado_por,
            o.fecha AS fecha_ot,
            o.km_actual,
            o.estado,
            a.asignacion AS tipo_ot,
            a.fecha AS fecha_asignacion,
            a.observacion AS observacion_asignacion,
            a.fecha_finalizacion,
            COALESCE(pt.nombre, 'No asignado') AS tecnico_asignado
        FROM adm_nortrans.asignaciones_ot a
        INNER JOIN adm_nortrans.ot_interna o 
            ON o.idot_interna = a.ot_interna
        LEFT JOIN adm_nortrans.personal_tecnico pt 
            ON pt.idpersonal_tecnico = a.personal_tecnico
        ORDER BY a.fecha DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ============================================
    // 🔹 RESPUESTA JSON
    // ============================================
    if ($result && count($result) > 0) {
        echo json_encode([
            "status" => "ok",
            "data" => $result
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            "status" => "no_data",
            "message" => "No se encontraron órdenes de trabajo asignadas."
        ], JSON_UNESCAPED_UNICODE);
    }
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
