<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    $query = $this->connect()->prepare("select * from conductor where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from conductor where estado = 'activo' and 
        rut = :rut");
    $query->bindParam(":rut", $item['rut'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregar($item)
  {
    $query = $this->connect()->prepare("INSERT INTO conductor(rut, nombre, telefono, correo, estado) VALUES (:rut, :nombre, :telefono, :correo, 'activo');");
    $query->bindParam(":rut", $item['rut'], PDO::PARAM_STR);
    $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
    $query->bindParam(":telefono", $item['telefono'], PDO::PARAM_STR);
    $query->bindParam(":correo", $item['correo'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from conductor where estado = 'activo' and 
      idconductor = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("UPDATE conductor SET rut = :rut, nombre = :nombre, telefono = :telefono, correo = :correo WHERE idconductor = :id AND estado = 'activo';");
    $query->bindParam(":rut", $item['rut'], PDO::PARAM_STR);
    $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
    $query->bindParam(":telefono", $item['telefono'], PDO::PARAM_STR);
    $query->bindParam(":correo", $item['correo'], PDO::PARAM_STR);
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("update conductor set estado = 'inactivo' where idconductor = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
