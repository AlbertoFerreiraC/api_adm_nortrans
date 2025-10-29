<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // Recibir número de OT (puede venir vacío)
    $nroSolicitud = isset($_POST['nroSolicitud']) ? trim($_POST['nroSolicitud']) : '';

    // Conectar a la base de datos usando la clase DB
    $db = new DB();
    $pdo = $db->connect();

    // Consulta principal (cabecera OT)
    if ($nroSolicitud !== '') {
        $sql = "
            SELECT 
                o.idot_interna AS id_preventiva,
                o.usuario,
                o.maquina,
                o.centro_de_costo,
                o.fecha,
                o.km_actual,
                o.estado
            FROM ot_interna o
            WHERE o.idot_interna = :nroSolicitud
            ORDER BY o.fecha DESC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nroSolicitud', $nroSolicitud, PDO::PARAM_INT);
    } else {
        $sql = "
            SELECT 
                o.idot_interna AS id_preventiva,
                o.usuario,
                o.maquina,
                o.centro_de_costo,
                o.fecha,
                o.km_actual,
                o.estado
            FROM ot_interna o
            ORDER BY o.fecha DESC
        ";
        $stmt = $pdo->prepare($sql);
    }

    $stmt->execute();
    $ots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($ots && count($ots) > 0) {

        // Recorrer cada OT para traer sus tareas (detalle)
        foreach ($ots as &$ot) {
            $sqlDetalle = "
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
                WHERE t.ot_interna = :idOT
                ORDER BY t.fecha DESC
            ";
            $stmtDetalle = $pdo->prepare($sqlDetalle);
            $stmtDetalle->bindParam(':idOT', $ot['id_preventiva'], PDO::PARAM_INT);
            $stmtDetalle->execute();
            $tareas = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);

            // Adjuntar detalle al registro de cabecera
            $ot['tareas'] = $tareas ?: [];
        }

        echo json_encode([
            "status" => "ok",
            "data" => $ots
        ]);
    } else {
        echo json_encode([
            "status" => "no_data",
            "message" => "No se encontraron órdenes de trabajo registradas."
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
