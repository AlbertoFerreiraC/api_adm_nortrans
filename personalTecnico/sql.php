<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    $query = $this->connect()->prepare("select * from personal_tecnico where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from personal_tecnico where estado = 'activo' and 
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
    $query = $this->connect()->prepare("INSERT INTO personal_tecnico(rut, nombre, telefono, correo, estado) VALUES (:rut, :nombre, :telefono, :correo, 'activo');");
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
    $query = $this->connect()->prepare("select * from personal_tecnico where estado = 'activo' and 
      idpersonal_tecnico = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("UPDATE personal_tecnico SET rut = :rut, nombre = :nombre, telefono = :telefono, correo = :correo WHERE idpersonal_tecnico = :id AND estado = 'activo';");
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
    $query = $this->connect()->prepare("update personal_tecnico set estado = 'inactivo' where idpersonal_tecnico = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
