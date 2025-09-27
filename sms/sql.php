<?php

include_once '../db.php';

class Sql extends DB
{

  function listarApruebaApi($item)
  {
    $query = $this->connect()->prepare("SELECT * FROM sms WHERE estado = 'pre_aprobado' AND pre_aprueba = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarPreApruebaApi($item)
  {
    $query = $this->connect()->prepare("SELECT * FROM sms WHERE estado = 'activo' AND pre_aprueba = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarAnularApi($item)
  {
    $query = $this->connect()->prepare("
        SELECT * 
        FROM sms 
        WHERE estado IN ('activo', 'pre_aprobado') 
          AND pre_aprueba = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);

    if ($query->execute()) {
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
      return null;
    }
  }

  function preAprobar($item)
  {
    try {
      $query = $this->connect()->prepare("
        UPDATE sms 
        SET 
          estado = 'pre_aprobado',
          observacion_pre_aprobacion = :comentario,
          fecha_pre_aprobacion = NOW()
        WHERE idsms = :id AND estado = 'activo'
      ");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);

      if ($query->execute()) {
        $this->registrarLog("Pre-aprobación exitosa para ID: " . $item['id']);
        return "ok";
      } else {
        $this->registrarError("Error al pre-aprobar ID: " . $item['id'] . ". Error: " . implode(", ", $query->errorInfo()));
        return "nok";
      }
    } catch (PDOException $e) {
      $this->registrarError("Excepción al pre-aprobar ID: " . $item['id'] . ". Error: " . $e->getMessage());
      return "nok";
    }
  }

  function anular($item)
  {
    try {
      $query = $this->connect()->prepare("
        UPDATE sms 
        SET 
          estado = 'anulado',
          observacion_pre_aprobacion = :comentario,
          fecha_pre_aprobacion = NOW()
        WHERE idsms = :id AND estado IN ('activo', 'pre_aprobado')
      ");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);

      if ($query->execute()) {
        $this->registrarLog("Anulación exitosa para ID: " . $item['id']);
        return "ok";
      } else {
        $this->registrarError("Error al anular ID: " . $item['id'] . ". Error: " . implode(", ", $query->errorInfo()));
        return "nok";
      }
    } catch (PDOException $e) {
      $this->registrarError("Excepción al anular ID: " . $item['id'] . ". Error: " . $e->getMessage());
      return "nok";
    }
  }

  function aprobar($item)
  {
    try {
      $query = $this->connect()->prepare("
        UPDATE sms 
        SET estado = 'aprobado'
        WHERE idsms = :id AND estado = 'pre_aprobado'
      ");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);

      if ($query->execute()) {
        $this->registrarLog("Aprobación exitosa para ID: " . $item['id']);
        return "ok";
      } else {
        $this->registrarError("Error al aprobar ID: " . $item['id'] . ". Error: " . implode(", ", $query->errorInfo()));
        return "nok";
      }
    } catch (PDOException $e) {
      $this->registrarError("Excepción al aprobar ID: " . $item['id'] . ". Error: " . $e->getMessage());
      return "nok";
    }
  }

  function rechazar($item)
  {
    try {
      $query = $this->connect()->prepare("
        UPDATE sms 
        SET estado = 'rechazado',
            observacion_rechazo = :comentario,
            fecha_rechazo = NOW()
        WHERE idsms = :id
      ");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);

      if ($query->execute()) {
        $this->registrarLog("Rechazo exitoso para ID: " . $item['id']);
        return "ok";
      } else {
        $this->registrarError("Error al rechazar ID: " . $item['id'] . ". Error: " . implode(", ", $query->errorInfo()));
        return "nok";
      }
    } catch (PDOException $e) {
      $this->registrarError("Excepción al rechazar ID: " . $item['id'] . ". Error: " . $e->getMessage());
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("
      SELECT * FROM contratacion 
      WHERE estado = 'pre_aprobado' 
      AND idcontratacion = :id
    ");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  private function registrarLog($mensaje) {}

  private function registrarError($mensaje) {}
}
