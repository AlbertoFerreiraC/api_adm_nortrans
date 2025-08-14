<?php

include_once '../db.php';

class Sql extends DB
{
  function listarHerramientas()
  {
    $query = $this->connect()->prepare("SELECT
                                          tpb.idtipo_piso_bus,
                                          tpb.nro_piso,
                                          COALESCE(cb.descripcion, '-') AS clase_piso,
                                          COALESCE(cb2.descripcion, '-') AS clase_piso_2,
                                          tpb.asiento_1,
                                          tpb.asiento_2,
                                          tpb.estado
                                      FROM
                                          tipo_piso_bus AS tpb
                                      LEFT JOIN
                                          clase_bus AS cb ON tpb.clase_piso = cb.idclase_bus
                                      LEFT JOIN
                                          clase_bus AS cb2 ON tpb.clase_piso_2 = cb2.idclase_bus
                                      WHERE
                                          tpb.estado = 'activo'
                                      ORDER BY tpb.idtipo_piso_bus asc");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("SELECT * FROM tipo_piso_bus
                                        WHERE estado = 'activo' AND 
                                        nro_piso = :nro_piso AND
                                        clase_piso = :clase_piso AND
                                        clase_piso_2 = :clase_piso_2 AND
                                        asiento_1 = :asiento_1 	AND
                                        asiento_2 = :asiento_2 ");
    $query->bindParam(":nro_piso", $item['nro_piso'], PDO::PARAM_STR);
    $query->bindParam(":clase_piso", $item['clase_piso'], PDO::PARAM_STR);
    $query->bindParam(":clase_piso_2", $item['clase_piso_2'], PDO::PARAM_STR);
    $query->bindParam(":asiento_1", $item['asiento_1'], PDO::PARAM_STR);
    $query->bindParam(":asiento_2", $item['asiento_2'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregar($item)
  {
    $query = $this->connect()->prepare("INSERT INTO tipo_piso_bus (nro_piso, clase_piso, clase_piso_2, asiento_1, asiento_2, estado) VALUES (:nro_piso, :clase_piso, :clase_piso_2, :asiento_1, :asiento_2, 'activo');");
    $query->bindParam(":nro_piso", $item['nro_piso'], PDO::PARAM_STR);
    $query->bindParam(":clase_piso", $item['clase_piso'], PDO::PARAM_STR);
    $query->bindParam(":clase_piso_2", $item['clase_piso_2'], PDO::PARAM_STR);
    $query->bindParam(":asiento_1", $item['asiento_1'], PDO::PARAM_STR);
    $query->bindParam(":asiento_2", $item['asiento_2'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from tipo_piso_bus where estado = 'activo' and 
      idtipo_piso_bus = :idtipo_piso_bus");
    $query->bindParam(":idtipo_piso_bus", $item['idtipo_piso_bus'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("UPDATE tipo_piso_bus SET
                                          nro_piso = :nro_piso, 
                                          clase_piso = :clase_piso, 
                                          clase_piso_2 = :clase_piso_2, 
                                          asiento_1 = :asiento_1, 
                                          asiento_2 = :asiento_2
                                        WHERE
                                          idtipo_piso_bus = :idtipo_piso_bus 
                                          and estado = 'activo';");
    $query->bindParam(":nro_piso", $item['nro_piso'], PDO::PARAM_STR);
    $query->bindParam(":clase_piso", $item['clase_piso'], PDO::PARAM_STR);
    $query->bindParam(":clase_piso_2", $item['clase_piso_2'], PDO::PARAM_STR);
    $query->bindParam(":asiento_1", $item['asiento_1'], PDO::PARAM_STR);
    $query->bindParam(":asiento_2", $item['asiento_2'], PDO::PARAM_STR);
    $query->bindParam(":idtipo_piso_bus", $item['idtipo_piso_bus'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("update tipo_piso_bus set estado = 'inactivo' where idtipo_piso_bus = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
