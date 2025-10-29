<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // ==========================================================
    // 🔹 CONEXIÓN
    // ==========================================================
    $db = new DB();
    $pdo = $db->connect();

    // ==========================================================
    // 🔹 VALIDAR PARAMETRO RECIBIDO
    // ==========================================================
    if (!isset($_POST['idOT']) || empty($_POST['idOT'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Falta el ID de la Orden de Trabajo."
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $idOT = $_POST['idOT'];

    // ==========================================================
    // 🔹 CONSULTA CABECERA (ot_interna)
    // ==========================================================
    $sqlCabecera = "
        SELECT 
            idot_interna,
            usuario,
            maquina,
            centro_de_costo,
            fecha,
            km_actual,
            estado
        FROM adm_nortrans.ot_interna
        WHERE idot_interna = :idOT
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
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // ==========================================================
    // 🔹 CONSULTA DETALLE (tareas_ot)
    // ==========================================================
    $sqlDetalle = "
        SELECT 
            t.idtareas_ot,
            t.fecha,
            t.tipo_tarea_mantencion,
            t.sistema_maquina,
            t.sub_sistema_maquina,
            t.observacion,
            t.estado
        FROM adm_nortrans.tareas_ot t
        WHERE t.ot_interna = :idOT
        ORDER BY t.fecha DESC
    ";

    $stmtDet = $pdo->prepare($sqlDetalle);
    $stmtDet->bindParam(':idOT', $idOT, PDO::PARAM_INT);
    $stmtDet->execute();
    $detalle = $stmtDet->fetchAll(PDO::FETCH_ASSOC);

    // ==========================================================
    // 🔹 RESPUESTA JSON COMPLETA
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
