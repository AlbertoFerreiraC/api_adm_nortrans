<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    $query = $this->connect()->prepare("select * from documento_de_maquina where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from documento_de_maquina where estado = 'activo' and 
        descripcion = :descripcion");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregar($item)
  {
    $query = $this->connect()->prepare("insert documento_de_maquina(descripcion,estado) values(:descripcion,'activo')");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from documento_de_maquina where estado = 'activo' and 
      iddocumento_de_maquina = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("update documento_de_maquina set descripcion = :descripcion where iddocumento_de_maquina = :id and estado = 'activo'");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("update documento_de_maquina set estado = 'inactivo' where iddocumento_de_maquina = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
