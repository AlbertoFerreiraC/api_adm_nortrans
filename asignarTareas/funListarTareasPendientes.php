<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    $db = new DB();
    $pdo = $db->connect();

    $sql = "
        SELECT 
            t.idtareas_ot,
            t.fecha,
            o.idot_interna,
            o.usuario,
            o.maquina,
            o.centro_de_costo,
            t.tipo_tarea_mantencion,
            t.sistema_maquina,
            t.sub_sistema_maquina,
            t.observacion,
            t.personal_tecnico,
            t.estado
        FROM tareas_ot t
        INNER JOIN ot_interna o ON o.idot_interna = t.ot_interna
        WHERE t.estado = 'activo'
        ORDER BY t.fecha DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result && count($result) > 0) {
        echo json_encode([
            "status" => "ok",
            "data" => $result
        ]);
    } else {
        echo json_encode([
            "status" => "no_data",
            "message" => "No se encontraron tareas pendientes registradas."
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
