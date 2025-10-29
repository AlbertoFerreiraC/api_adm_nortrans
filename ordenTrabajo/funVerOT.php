<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // Recibir ID desde el frontend
    $idOT = isset($_POST['idOT']) ? intval($_POST['idOT']) : 0;

    if ($idOT <= 0) {
        echo json_encode([
            "status" => "error",
            "message" => "ID de OT no válido."
        ]);
        exit;
    }

    $db = new DB();
    $pdo = $db->connect();

    // ========================
    // CONSULTA DE CABECERA
    // ========================
    $sqlCab = "SELECT 
                    idot_interna,
                    usuario,
                    maquina,
                    centro_de_costo,
                    fecha,
                    km_actual,
                    estado
                FROM ot_interna
                WHERE idot_interna = :idOT";
    $stmtCab = $pdo->prepare($sqlCab);
    $stmtCab->bindParam(':idOT', $idOT, PDO::PARAM_INT);
    $stmtCab->execute();
    $cabecera = $stmtCab->fetch(PDO::FETCH_ASSOC);

    if (!$cabecera) {
        echo json_encode([
            "status" => "no_data",
            "message" => "No se encontró la OT solicitada."
        ]);
        exit;
    }

    // ========================
    // CONSULTA DE DETALLE
    // ========================
    $sqlDet = "SELECT 
                    idtareas_ot AS id_tarea,
                    fecha,
                    personal_tecnico AS tecnico,
                    tipo_tarea_mantencion AS tipo_tarea,
                    sistema_maquina AS sistema,
                    sub_sistema_maquina AS sub_sistema,
                    observacion,
                    estado
                FROM tareas_ot
                WHERE ot_interna = :idOT
                ORDER BY fecha ASC";
    $stmtDet = $pdo->prepare($sqlDet);
    $stmtDet->bindParam(':idOT', $idOT, PDO::PARAM_INT);
    $stmtDet->execute();
    $detalle = $stmtDet->fetchAll(PDO::FETCH_ASSOC);

    // ========================
    // ESTRUCTURA DE RESPUESTA
    // ========================
    $data = [
        "num_ot" => $cabecera['idot_interna'],
        "fecha" => $cabecera['fecha'],
        "maquina" => $cabecera['maquina'],
        "centro_de_costo" => $cabecera['centro_de_costo'],
        "km" => $cabecera['km_actual'],
        "estado" => $cabecera['estado'],
        "creado_por" => $cabecera['usuario'],
        "tareas" => $detalle
    ];

    echo json_encode([
        "status" => "ok",
        "data" => $data
    ]);
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
