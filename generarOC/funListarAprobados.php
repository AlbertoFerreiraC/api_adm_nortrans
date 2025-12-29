<?php

require_once 'sql.php';

$sql = new Sql();

try {

    $data = $sql->listarOCParaEntrega();

    echo json_encode($data);
} catch (Exception $e) {

    http_response_code(500);
    echo json_encode([
        "error" => "Error al listar órdenes aprobadas"
    ]);
}
