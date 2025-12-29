<?php

require_once 'sql.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(["mensaje" => "nok"]);
    exit;
}

$sql = new Sql();

try {

    $resultado = $sql->marcarOCEntregada($id);

    echo json_encode([
        "mensaje" => $resultado
    ]);

} catch (Exception $e) {

    echo json_encode([
        "mensaje" => "nok"
    ]);
}
