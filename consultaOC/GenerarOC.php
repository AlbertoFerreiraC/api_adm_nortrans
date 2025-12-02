<?php
include_once '../db.php';

class GenerarOC extends DB
{
    function buscarCabecera($empresa, $nroOC)
    {
        $sql = "
            SELECT *
            FROM generar_oc
            WHERE empresa = :empresa
              AND idgenerar_oc = :nroOC
            LIMIT 1
        ";

        $query = $this->connect()->prepare($sql);
        $query->bindParam(":empresa", $empresa, PDO::PARAM_STR);
        $query->bindParam(":nroOC", $nroOC, PDO::PARAM_STR);

        if ($query->execute()) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }
}
