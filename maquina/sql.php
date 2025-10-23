<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    $query = $this->connect()->prepare("select * from maquina where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from maquina where estado = 'activo' and 
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
    $query = $this->connect()->prepare("INSERT INTO maquina (centro_de_costo, tipo_bus, descripcion, km_anterior, fecha_km, km_actual, estado) VALUES (:centro_de_costo, :tipo_bus, :descripcion, :km_anterior, :fecha_km, :km_actual, 'activo');");
    $query->bindParam(":centro_de_costo", $item['centro_de_costo'], PDO::PARAM_STR);
    $query->bindParam(":tipo_bus", $item['tipo_bus'], PDO::PARAM_STR);
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":km_anterior", $item['km_anterior'], PDO::PARAM_STR);
    $query->bindParam(":fecha_km", $item['fecha_km'], PDO::PARAM_STR);
    $query->bindParam(":km_actual", $item['km_actual'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("
        SELECT  * FROM maquina WHERE estado = 'activo'   AND idmaquina = :idmaquina ");
    $query->bindParam(":idmaquina", $item['idmaquina'], PDO::PARAM_INT);
    if ($query->execute()) {
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
      return null;
    }
  }


  function modificar($item)
  {
    $query = $this->connect()->prepare("
        UPDATE maquina 
        SET 
            centro_de_costo = :centro_de_costo, 
            tipo_bus = :tipo_bus, 
            descripcion = :descripcion, 
            km_anterior = :km_anterior, 
            fecha_km = :fecha_km, 
            km_actual = :km_actual 
        WHERE idmaquina = :idmaquina 
        AND estado = 'activo';
    ");

    $query->bindParam(":centro_de_costo", $item['centro_de_costo'], PDO::PARAM_STR);
    $query->bindParam(":tipo_bus", $item['tipo_bus'], PDO::PARAM_STR);
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":km_anterior", $item['km_anterior'], PDO::PARAM_STR);
    $query->bindParam(":fecha_km", $item['fecha_km'], PDO::PARAM_STR);
    $query->bindParam(":km_actual", $item['km_actual'], PDO::PARAM_STR);
    $query->bindParam(":idmaquina", $item['idmaquina'], PDO::PARAM_INT);

    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("update maquina set estado = 'inactivo' where idmaquina = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
