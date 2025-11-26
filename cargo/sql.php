<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    $query = $this->connect()->prepare("select * from cargo where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    if (isset($item['id'])) {
      // VERIFICAR EN MODIFICACIÓN
      $query = $this->connect()->prepare("
            SELECT * FROM cargo 
            WHERE estado = 'activo' 
              AND descripcion = :descripcion
              AND idcargo != :id
        ");
      $query->bindParam(":id", $item['id'], PDO::PARAM_INT);
    } else {
      // VERIFICAR EN AGREGAR
      $query = $this->connect()->prepare("
            SELECT * FROM cargo 
            WHERE estado = 'activo' 
              AND descripcion = :descripcion
        ");
    }

    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);

    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }


  function agregar($item)
  {
    $query = $this->connect()->prepare("insert cargo(descripcion,dependencia,estado) values(:descripcion,:dependencia,'activo')");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":dependencia", $item['dependencia'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from cargo where estado = 'activo' and 
      idcargo = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("update cargo set descripcion = :descripcion, dependencia = :dependencia where idcargo = :id and estado = 'activo'");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":dependencia", $item['dependencia'], PDO::PARAM_STR);
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("update cargo set estado = 'inactivo' where idcargo = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
