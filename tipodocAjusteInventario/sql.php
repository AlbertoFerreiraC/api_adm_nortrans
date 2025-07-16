<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    $query = $this->connect()->prepare("select * from tipo_documento_ajuste_inventario where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from tipo_documento_ajuste_inventario where estado = 'activo' and 
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
    $query = $this->connect()->prepare("insert tipo_documento_ajuste_inventario(descripcion,estado) values(:descripcion,'activo')");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from tipo_documento_ajuste_inventario where estado = 'activo' and 
      idtipo_documento_ajuste_inventario = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("update tipo_documento_ajuste_inventario set descripcion = :descripcion where idtipo_documento_ajuste_inventario = :id and estado = 'activo'");
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
    $query = $this->connect()->prepare("update tipo_documento_ajuste_inventario set estado = 'inactivo' where idtipo_documento_ajuste_inventario = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
