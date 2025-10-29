<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // 🔹 Conexión
    $db = new DB();
    $pdo = $db->connect();

    // 🔹 Verificar si se envió el ID del repuesto
    if (!isset($_POST['idRepuesto']) || empty($_POST['idRepuesto'])) {
        echo json_encode([
            "status" => "error",
            "message" => "Falta el ID del repuesto."
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $idRepuesto = $_POST['idRepuesto'];

    // ==========================================================
    // 🔹 CONSULTA DETALLADA — OBTENER UN REPUESTO
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
        WHERE idrepuestos = :idRepuesto
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idRepuesto', $idRepuesto, PDO::PARAM_INT);
    $stmt->execute();

    $repuesto = $stmt->fetch(PDO::FETCH_ASSOC);

    // ==========================================================
    // 🔹 RESPUESTA JSON
    // ==========================================================
    if ($repuesto) {
        echo json_encode([
            "status" => "ok",
            "data" => $repuesto
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            "status" => "no_data",
            "message" => "No se encontraron datos del repuesto solicitado."
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
