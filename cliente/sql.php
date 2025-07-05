<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    try {
      $query = $this->connect()->prepare("select * from cliente where estado = 'activo'");
      $query->execute();
      return $query->fetchAll();
    } catch (PDOException $e) {
      error_log("Error en listarHerramientas: " . $e->getMessage());
      return null;
    }
  }


  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from cliente where estado = 'activo' and 
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
    $query = $this->connect()->prepare("INSERT INTO cliente(rut, nombre, apellido, telefono, correo, direccion, estado) VALUES (:rut, :nombre, :apellido, :telefono, :correo, :direccion, 'activo');");
    $query->bindParam(":rut", $item['rut'], PDO::PARAM_STR);
    $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
    $query->bindParam(":apellido", $item['apellido'], PDO::PARAM_STR);
    $query->bindParam(":telefono", $item['telefono'], PDO::PARAM_STR);
    $query->bindParam(":correo", $item['correo'], PDO::PARAM_STR);
    $query->bindParam(":direccion", $item['direccion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from cliente where estado = 'activo' and 
      idcliente = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("UPDATE cliente SET
                                        rut = :rut, 
                                        nombre = :nombre, 
                                        apellido = :apellido, 
                                        telefono = :telefono, 
                                        correo = :correo, 
                                        direccion = :direccion
                                      WHERE
                                        idcliente = :id AND estado = 'activo';");
    $query->bindParam(":rut", $item['rut'], PDO::PARAM_STR);
    $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
    $query->bindParam(":apellido", $item['apellido'], PDO::PARAM_STR);
    $query->bindParam(":telefono", $item['telefono'], PDO::PARAM_STR);
    $query->bindParam(":correo", $item['correo'], PDO::PARAM_STR);
    $query->bindParam(":direccion", $item['direccion'], PDO::PARAM_STR);
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("update cliente set estado = 'inactivo' where idcliente = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
