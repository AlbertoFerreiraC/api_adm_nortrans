<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    $db = new DB();
    $pdo = $db->connect();

    // Consulta principal — puedes ajustar nombres de tabla y campos según tu base
    $sql = "SELECT 
            se.idservicio_externo,
            se.fecha_ot,
            m.descripcion AS maquina,
            p.descripcion AS proveedor,
            se.estado
            FROM servicio_externo se
            JOIN detalle_servicio_externo dse ON se.idservicio_externo = dse.servicio_externo
            LEFT JOIN maquina m ON se.maquina = m.idmaquina
            LEFT JOIN proveedor p ON se.proveedor = p.idproveedor
            ORDER BY se.idservicio_externo DESC
            ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    echo json_encode([
        "mensaje" => "nok",
        "error" => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
