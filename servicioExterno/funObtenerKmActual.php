<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['idmaquina'])) {
    echo json_encode(["mensaje" => "nok", "error" => "ID de máquina no recibido"]);
    exit;
}

try {
    $db = new DB();
    $pdo = $db->connect();

    $stmt = $pdo->prepare("SELECT km_actual FROM maquina WHERE idmaquina = :idmaquina LIMIT 1");
    $stmt->execute([':idmaquina' => $input['idmaquina']]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo json_encode(["mensaje" => "ok", "km_actual" => $resultado['km_actual']]);
    } else {
        echo json_encode(["mensaje" => "nok", "error" => "Máquina no encontrada"]);
    }

} catch (Exception $e) {
    echo json_encode(["mensaje" => "nok", "error" => $e->getMessage()]);
}
