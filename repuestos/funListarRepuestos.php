<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    $db = new DB();
    $pdo = $db->connect();

    // ==========================================================
    // 🔹 CONSULTA PRINCIPAL — LISTAR REPUESTOS ACTIVOS
    // ==========================================================
    $sql = "
        SELECT 
            idrepuestos,
            familia_repuesto,
            sub_familia_repuesto,
            marca_repuesto,
            modelo_repuesto,
            sistema_de_aplicacion,
            descripcion,
            codigo_de_lectura,
            aplicacion,
            stock_minimo,
            stock_maximo,
            stock_reposicion,
            ubicacion_x,
            ubicacion_y,
            anho_desde,
            anho_hasta,
            estado
        FROM adm_nortrans.repuestos
        WHERE estado = 'Activo'
        ORDER BY familia_repuesto ASC, sub_familia_repuesto ASC, descripcion ASC
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
            "message" => "No se encontraron repuestos activos registrados."
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
