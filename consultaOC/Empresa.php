<?php
include_once '../db.php';

class Empresa extends DB
{
    function listarEmpresas()
    {
        $sql = "
            SELECT 
                idempresa AS id, 
                descripcion AS nombre 
            FROM empresa
            ORDER BY nombre
        ";

        $query = $this->connect()->prepare($sql);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }
}
