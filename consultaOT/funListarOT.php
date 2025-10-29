<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // 🔹 Conexión a la base de datos
    $db = new DB();
    $pdo = $db->connect();

    // ==========================================================
    // 🔹 CONSULTA — LISTA COMPLETA DE OTs (sin importar estado)
    // ==========================================================
    $sql = "
        SELECT 
            o.idot_interna,
            o.usuario,
            o.maquina,
            o.centro_de_costo,
            o.fecha,
            o.km_actual,
            o.estado,
            COUNT(t.idtareas_ot) AS total_tareas
        FROM adm_nortrans.ot_interna o
        LEFT JOIN adm_nortrans.tareas_ot t 
            ON t.ot_interna = o.idot_interna
        GROUP BY 
            o.idot_interna, o.usuario, o.maquina, o.centro_de_costo, 
            o.fecha, o.km_actual, o.estado
        ORDER BY o.fecha DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ==========================================================
    // 🔹 RESPUESTA JSON
    // ==========================================================
    if ($result && count($result) > 0) {
        echo json_encode([
            "status" => "ok",
            "data" => $result
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            "status" => "no_data",
            "message" => "No se encontraron órdenes de trabajo registradas."
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
