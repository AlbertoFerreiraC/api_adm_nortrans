<?php
include_once '../db.php';

class HistorialRepuesto extends DB
{

    function listarHistorial()
    {

        $sql = "
            SELECT
                g.idgenerar_oc,
                DATE(g.fecha_creacion) AS fecha_creacion,
                d.nro_item,
                r.idrepuestos,
                d.costo_unitario,
                d.cantidad

            FROM generar_oc g

            INNER JOIN detalle_oc d
                ON d.generar_oc = g.idgenerar_oc

            LEFT JOIN repuestos r
                ON r.idrepuestos = d.sms

            WHERE d.tipo_producto = 'REPUESTO'

            ORDER BY g.fecha_creacion DESC
        ";

        $query = $this->connect()->prepare($sql);

        if ($query->execute()) {

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {

            return [];
        }
    }
}


/* ----------- EJECUCION DEL API ----------- */

$historial = new HistorialRepuesto();

$resultado = $historial->listarHistorial();

header('Content-Type: application/json');

echo json_encode($resultado);
