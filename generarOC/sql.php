<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    $query = $this->connect()->prepare("select * from generar_oc where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from clase_bus where estado = 'activo' and 
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
    $query = $this->connect()->prepare("INSERT INTO generar_oc (fecha_creacion, nro_oc, proveedor, solicitud_ms, doc_proveedor, empresa, plazo_entrega, tipo_doc_compra, plazo_oc, pago_oc, pre_aprueba, num_doc_proveedor, sub_total, descuento_total, exento_total, neto_total, iva_total, retencion_total, total_general, estado) VALUES (:fecha_creacion, :nro_oc, :proveedor, :solicitud_ms, :doc_proveedor, :empresa, :plazo_entrega, :tipo_doc_compra, :plazo_oc, :pago_oc, :pre_aprueba, :num_doc_proveedor, :sub_total, :descuento_total, :exento_total, :neto_total, :iva_total, :retencion_total, :total_general, 'activo');");

    $query->bindParam(":fecha_creacion", $item['fecha_creacion'], PDO::PARAM_STR);
    $query->bindParam(":nro_oc", $item['nro_oc'], PDO::PARAM_STR);
    $query->bindParam(":proveedor", $item['proveedor'], PDO::PARAM_STR);
    $query->bindParam(":solicitud_ms", $item['solicitud_ms'], PDO::PARAM_STR);
    $query->bindParam(":doc_proveedor", $item['doc_proveedor'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":plazo_entrega", $item['plazo_entrega'], PDO::PARAM_STR);
    $query->bindParam(":tipo_doc_compra", $item['tipo_doc_compra'], PDO::PARAM_STR);
    $query->bindParam(":plazo_oc", $item['plazo_oc'], PDO::PARAM_STR);
    $query->bindParam(":pago_oc", $item['pago_oc'], PDO::PARAM_STR);
    $query->bindParam(":pre_aprueba", $item['pre_aprueba'], PDO::PARAM_STR);
    $query->bindParam(":num_doc_proveedor", $item['num_doc_proveedor'], PDO::PARAM_STR);
    $query->bindParam(":sub_total", $item['sub_total'], PDO::PARAM_STR);
    $query->bindParam(":descuento_total", $item['descuento_total'], PDO::PARAM_STR);
    $query->bindParam(":exento_total", $item['exento_total'], PDO::PARAM_STR);
    $query->bindParam(":neto_total", $item['neto_total'], PDO::PARAM_STR);
    $query->bindParam(":iva_total", $item['iva_total'], PDO::PARAM_STR);
    $query->bindParam(":retencion_total", $item['retencion_total'], PDO::PARAM_STR);
    $query->bindParam(":total_general", $item['total_general'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from clase_bus where estado = 'activo' and 
      idclase_bus = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("update clase_bus set descripcion = :descripcion where idclase_bus = :id and estado = 'activo'");
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
    $query = $this->connect()->prepare("update clase_bus set estado = 'inactivo' where idclase_bus = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function aprobar($item)
  {
    try {
      $query = $this->connect()->prepare("UPDATE generar_oc SET estado = 'aprobado' WHERE idcontratacion = :id AND estado = 'pre_aprobado'");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);

      if ($query->execute()) {
        return "ok";
      } else {
        return "nok";
      }
    } catch (PDOException $e) {
      return "nok";
    }
  }
}
