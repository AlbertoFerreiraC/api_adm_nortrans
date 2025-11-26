<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    try {
      $query = $this->connect()->prepare("SELECT pro.idproveedor,
          com.descripcion AS comuna,
          cdp.descripcion AS condicion_de_pago,
          tdp.descripcion AS tipo_de_proveedor,
          pro.descripcion,
          pro.rut,
          pro.telefono_contacto,
          pro.correo_contacto,
          pro.direccion,
          pro.criticidad,
          cri.descripcion AS criticidad
          FROM proveedor pro
          JOIN comuna com ON com.idcomuna = pro.comuna
          JOIN condicion_de_pago cdp ON cdp.idcondicion_de_pago = pro.condicion_de_pago
          JOIN tipo_de_proveedor tdp ON tdp.idtipo_de_proveedor = pro.tipo_de_proveedor
          JOIN criticidad cri ON cri.idcriticidad = pro.criticidad
          WHERE pro.estado = 'activo'");
      $query->execute();
      return $query->fetchAll();
    } catch (PDOException $e) {
      error_log("Error en listarHerramientas: " . $e->getMessage());
      return null;
    }
  }


  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from proveedor where estado = 'activo' and 
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
    $query = $this->connect()->prepare("INSERT INTO proveedor(comuna, condicion_de_pago, tipo_de_proveedor, descripcion, rut, telefono_contacto, correo_contacto, direccion, criticidad, estado ) VALUES (:comuna, :condicion_de_pago, :tipo_de_proveedor, :descripcion, :rut, :telefono_contacto, :correo_contacto, :direccion, :criticidad, 'activo')");
    $query->bindParam(":comuna", $item['comuna'], PDO::PARAM_STR);
    $query->bindParam(":condicion_de_pago", $item['condicion_de_pago'], PDO::PARAM_STR);
    $query->bindParam(":tipo_de_proveedor", $item['tipo_de_proveedor'], PDO::PARAM_STR);
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":rut", $item['rut'], PDO::PARAM_STR);
    $query->bindParam(":telefono_contacto", $item['telefono_contacto'], PDO::PARAM_STR);
    $query->bindParam(":correo_contacto", $item['correo_contacto'], PDO::PARAM_STR);
    $query->bindParam(":direccion", $item['direccion'], PDO::PARAM_STR);
    $query->bindParam(":criticidad", $item['criticidad'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from proveedor where estado = 'activo' and 
      idproveedor = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("UPDATE proveedor SET
    comuna = :comuna,
    condicion_de_pago = :condicion_de_pago,
    tipo_de_proveedor = :tipo_de_proveedor,
    descripcion = :descripcion,
    rut = :rut,
    telefono_contacto = :telefono_contacto,
    correo_contacto = :correo_contacto,
    direccion = :direccion,
    criticidad = :criticidad
    WHERE idproveedor = :id AND estado = 'activo'");
    $query->bindParam(":comuna", $item['comuna'], PDO::PARAM_STR);
    $query->bindParam(":condicion_de_pago", $item['condicion_de_pago'], PDO::PARAM_STR);
    $query->bindParam(":tipo_de_proveedor", $item['tipo_de_proveedor'], PDO::PARAM_STR);
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":rut", $item['rut'], PDO::PARAM_STR);
    $query->bindParam(":telefono_contacto", $item['telefono_contacto'], PDO::PARAM_STR);
    $query->bindParam(":correo_contacto", $item['correo_contacto'], PDO::PARAM_STR);
    $query->bindParam(":direccion", $item['direccion'], PDO::PARAM_STR);
    $query->bindParam(":criticidad", $item['criticidad'], PDO::PARAM_STR);
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("update proveedor set estado = 'inactivo' where idproveedor = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
