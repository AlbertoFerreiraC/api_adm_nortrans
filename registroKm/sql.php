<?php

include_once '../db.php';

class Sql extends DB
{

  function listarHerramientas()
  {
    $query = $this->connect()->prepare("SELECT * FROM registro_km WHERE estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("
    SELECT km_actual 
    FROM registro_km 
    WHERE estado = 'activo' 
      AND descripcion = :descripcion
    ORDER BY fecha_km DESC 
    LIMIT 1
  ");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);

    if ($query->execute()) {
      return $query->fetch(PDO::FETCH_ASSOC);
    } else {
      return null;
    }
  }


  function agregar($item)
  {
    try {
      $pdo = $this->connect();
      $pdo->beginTransaction();

      // Insertar nuevo registro de kilometraje
      $query = $pdo->prepare("
      INSERT INTO registro_km 
      (centro_de_costo, tipo_bus, maquina, descripcion, km_anterior, fecha_km, km_actual, estado) 
      VALUES 
      (:centro_de_costo, :tipo_bus, :maquina, :descripcion, :km_anterior, :fecha_km, :km_actual, 'activo')
    ");
      $query->bindParam(":centro_de_costo", $item['centro_de_costo'], PDO::PARAM_STR);
      $query->bindParam(":tipo_bus", $item['tipo_bus'], PDO::PARAM_STR);
      $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_INT);
      $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
      $query->bindParam(":km_anterior", $item['km_anterior'], PDO::PARAM_STR);
      $query->bindParam(":fecha_km", $item['fecha_km'], PDO::PARAM_STR);
      $query->bindParam(":km_actual", $item['km_actual'], PDO::PARAM_STR);
      $query->execute();

      // Actualizar el km_actual de la máquina
      $update = $pdo->prepare("
      UPDATE maquina 
      SET km_actual = :km_actual 
      WHERE idmaquina = :idmaquina
    ");
      $update->bindParam(":km_actual", $item['km_actual'], PDO::PARAM_STR);
      $update->bindParam(":idmaquina", $item['maquina'], PDO::PARAM_INT);
      $update->execute();

      $pdo->commit();
      return "ok";
    } catch (PDOException $e) {
      $pdo->rollBack();
      return "nok";
    }
  }


  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("
      SELECT * 
      FROM registro_km 
      WHERE estado = 'activo' 
      AND idregistro_km = :idregistro_km
    ");
    $query->bindParam(":idregistro_km", $item['idregistro_km'], PDO::PARAM_INT);
    if ($query->execute()) {
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("
      UPDATE registro_km 
      SET 
        centro_de_costo = :centro_de_costo, 
        tipo_bus = :tipo_bus, 
        maquina = :maquina,
        descripcion = :descripcion, 
        km_anterior = :km_anterior, 
        fecha_km = :fecha_km, 
        km_actual = :km_actual 
      WHERE idregistro_km = :idregistro_km 
      AND estado = 'activo'
    ");

    $query->bindParam(":centro_de_costo", $item['centro_de_costo'], PDO::PARAM_STR);
    $query->bindParam(":tipo_bus", $item['tipo_bus'], PDO::PARAM_STR);
    $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_STR);
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":km_anterior", $item['km_anterior'], PDO::PARAM_STR);
    $query->bindParam(":fecha_km", $item['fecha_km'], PDO::PARAM_STR);
    $query->bindParam(":km_actual", $item['km_actual'], PDO::PARAM_STR);
    $query->bindParam(":idregistro_km", $item['idregistro_km'], PDO::PARAM_INT);

    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("
      UPDATE registro_km 
      SET estado = 'inactivo' 
      WHERE idregistro_km = :idregistro_km 
      AND estado = 'activo'
    ");
    $query->bindParam(":idregistro_km", $item['idregistro_km'], PDO::PARAM_INT);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
