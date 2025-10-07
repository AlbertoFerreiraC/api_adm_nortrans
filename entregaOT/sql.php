<?php

include_once '../db.php';

class Sql extends DB
{
    public function listarOTApi($item)
    {
        try {
            $pdo = $this->connect();
            $sql = "SELECT 
                        s.idsms,
                        d.iddetalle_sms,
                        d.tipo AS tipo_producto,
                        CASE 
                            WHEN d.tipo = 'Repuesto' THEN d.repuestos
                            WHEN d.tipo = 'Insumo' THEN d.insumos
                            ELSE NULL
                        END AS idproducto,
                        d.cantidad,
                        s.bodega,
                        s.empresa,
                        s.maquina
                    FROM sms s
                    INNER JOIN detalle_sms d ON s.idsms = d.sms
                    WHERE s.estado IN ('activo','aprobado')";

            $query = $pdo->prepare($sql);

            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->registrarError("Error en listarAnularApi: " . $e->getMessage());
            return null;
        }
    }

    private function registrarLog($mensaje)
    {
        error_log("[LOG] " . $mensaje);
    }

    private function registrarError($mensaje)
    {
        error_log("[ERROR] " . $mensaje);
    }
}
