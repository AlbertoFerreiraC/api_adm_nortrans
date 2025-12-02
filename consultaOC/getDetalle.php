<?php
header("Content-Type: application/json");

include_once '../db.php';

class DetalleOC extends DB
{
    function listarPorCabecera($id)
    {
        $sql = "
            SELECT *
            FROM detalle_oc
            WHERE generar_oc = :id
            ORDER BY nro_item ASC
        ";

        $query = $this->connect()->prepare($sql);
        $query->bindParam(":id", $id, PDO::PARAM_INT);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }
}

$input = json_decode(file_get_contents("php://input"), true);
$id = $input["nroOC"] ?? "";

$detalle = new DetalleOC();
$data = $detalle->listarPorCabecera($id);

echo json_encode([
    "success" => $data !== null,
    "data" => $data ?? []
]);
