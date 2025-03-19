<?php

include_once '../db.php';

class Sql extends DB
{

  function listarHerramientas()
  {
    $query = $this->connect()->prepare("SELECT * FROM institucion WHERE estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarInstitucionsApi($item)
  {
    $query = $this->connect()->prepare("SELECT ins.tipo_institucion,
      ins.descripcion,
      ins.codigo_externo
      FROM institucion ins
      WHERE ins.estado = 'activo';");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from institucion where estado = 'activo' and 
        idinstitucion = :idinstitucion");
    $query->bindParam(":idinstitucion", $item['idinstitucion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregar($item)
  {
    $query = $this->connect()->prepare("INSERT INTO institucion (tipo_institucion, descripcion, codigo_externo, estado) 
          VALUES (:tipo_institucion, :descripcion, :codigo_externo, 'activo')");

    if (isset($item['tipo_institucion'], $item['descripcion'], $item['codigo_externo'])) {
      $query->bindParam(":tipo_institucion", $item['tipo_institucion'], PDO::PARAM_STR);
      $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
      $query->bindParam(":codigo_externo", $item['codigo_externo'], PDO::PARAM_STR);
    } else {
      return "nok";
    }

    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
