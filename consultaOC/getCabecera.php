<?php
header("Content-Type: application/json");

include_once '../db.php';
include_once 'GenerarOC.php';

$input = json_decode(file_get_contents("php://input"), true);

$empresa = $input["empresa"] ?? "";
$nroOC   = $input["nroOC"] ?? "";

if (!$empresa || !$nroOC) {
    echo json_encode(["success" => false, "message" => "Faltan datos obligatorios"]);
    exit;
}

$oc = new GenerarOC();
$data = $oc->buscarCabecera($empresa, $nroOC);

if (!$data) {
    echo json_encode(["success" => false, "message" => "OC no encontrada"]);
    exit;
}

echo json_encode([
    "success" => true,
    "data" => $data
]);
