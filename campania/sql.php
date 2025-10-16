<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    $query = $this->connect()->prepare("select * from campanha where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from campanha where estado = 'activo' and 
        idcampanha = :idcampanha");
    $query->bindParam(":idcampanha", $item['idcampanha'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregar($item)
  {
    $query = $this->connect()->prepare("INSERT INTO campanha (fecha_creacion, tipo_campaha, descripcion, tipo_frecuencia, frecuencia, comentario, fecha_desde, fecha_hasta, estado) VALUES (:fecha_creacion, :tipo_campaha,:descripcion,:tipo_frecuencia,:frecuencia,:comentario,:fecha_desde,:fecha_hasta, 'activo');");

    $query->bindParam(":fecha_creacion", $item['fecha_creacion'], PDO::PARAM_STR);
    $query->bindParam(":tipo_campaha", $item['tipo_campaha'], PDO::PARAM_STR);
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":tipo_frecuencia", $item['tipo_frecuencia'], PDO::PARAM_STR);
    $query->bindParam(":frecuencia", $item['frecuencia'], PDO::PARAM_STR);
    $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);
    $query->bindParam(":fecha_desde", $item['fecha_desde'], PDO::PARAM_STR);
    $query->bindParam(":fecha_hasta", $item['fecha_hasta'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return $query;
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from campanha where estado = 'activo' and 
      idcampanha = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("UPDATE campanha SET
	fecha_creacion = :fecha_creacion, 
	tipo_campaha = :tipo_campaha, 
	descripcion = :descripcion, 
	tipo_frecuencia = :tipo_frecuencia, 
	frecuencia = :frecuencia, 
	comentario = :comentario, 
	fecha_desde = :fecha_desde, 
	fecha_hasta = :fecha_hasta
	WHERE idcampanha = :idcampanha AND estado = 'activo';");

    $query->bindParam(":idcampanha", $item['idcampanha'], PDO::PARAM_INT);
    $query->bindParam(":fecha_creacion", $item['fecha_creacion'], PDO::PARAM_STR);
    $query->bindParam(":tipo_campaha", $item['tipo_campaha'], PDO::PARAM_STR);
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":tipo_frecuencia", $item['tipo_frecuencia'], PDO::PARAM_STR);
    $query->bindParam(":frecuencia", $item['frecuencia'], PDO::PARAM_STR);
    $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);
    $query->bindParam(":fecha_desde", $item['fecha_desde'], PDO::PARAM_STR);
    $query->bindParam(":fecha_hasta", $item['fecha_hasta'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }


  function eliminar($item)
  {
    $query = $this->connect()->prepare("update campanha set estado = 'inactivo' where idcampanha = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
