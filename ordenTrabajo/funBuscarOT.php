<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // Recibir datos del frontend
    $nroOT = isset($_POST['nroOT']) ? trim($_POST['nroOT']) : '';

    $db = new DB();
    $pdo = $db->connect();

    // Consulta dinámica: si se envía nroOT, filtra; si no, trae todas
    if ($nroOT !== '') {
        $sql = "SELECT 
                    idot_interna,
                    usuario,
                    maquina,
                    centro_de_costo,
                    fecha,
                    km_actual,
                    estado
                FROM ot_interna
                WHERE idot_interna = :nroOT
                ORDER BY fecha DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nroOT', $nroOT, PDO::PARAM_INT);
    } else {
        $sql = "SELECT 
                    idot_interna,
                    usuario,
                    maquina,
                    centro_de_costo,
                    fecha,
                    km_actual,
                    estado
                FROM ot_interna
                ORDER BY fecha DESC";
        $stmt = $pdo->prepare($sql);
    }

    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultado && count($resultado) > 0) {
        echo json_encode([
            "status" => "ok",
            "data" => $resultado
        ]);
    } else {
        echo json_encode([
            "status" => "no_data",
            "message" => "No se encontraron órdenes de trabajo."
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
