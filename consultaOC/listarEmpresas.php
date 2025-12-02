<?php
header("Content-Type: application/json");
include_once '../db.php';
include_once 'Empresa.php';

$empresa = new Empresa();
$data = $empresa->listarEmpresas();

echo json_encode([
    "success" => $data !== null,
    "data" => $data
]);
