<?php

include_once '../db.php';

class Sql extends DB
{

  function listarHerramientas($item)
  {
    $query = $this->connect()->prepare("SELECT * FROM contratacion WHERE estado = 'activo' and aprueba = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarApruebaApi($item)
  {
    $query = $this->connect()->prepare("SELECT con.idcontratacion,
        con.division,
        emp.descripcion empresa,
        car.descripcion cargo,
        cdc.descripcion centro_de_costo,
        usu.nombre aprueba,
        usu.nombre as usuario
        FROM contratacion con
        JOIN empresa emp ON emp.idempresa = con.empresa
        JOIN cargo car ON car.idcargo = con.cargo
        JOIN centro_de_costo cdc ON cdc.idcentro_de_costo = con.centro_de_costo
        JOIN usuario usu ON usu.idusuario = con.usuario
        WHERE con.estado = 'pre_aprobado'
        AND con.aprueba = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarPorUsuario($id_usuario)
  {
    $query = $this->connect()->prepare("SELECT * FROM contratacion WHERE pre_aprueba = :id_usuario AND estado = 'activo'");
    $query->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);

    if ($query->execute()) {
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
      return null;
    }
  }

  function aprobar($item)
  {
    try {
      $query = $this->connect()->prepare("UPDATE contratacion SET estado = 'aprobado' WHERE idcontratacion = :id AND estado = 'pre_aprobado'");
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
      $query = $this->connect()->prepare("UPDATE contratacion SET estado = 'no_aprobado' WHERE idcontratacion = :id AND estado = 'pre_aprobado'");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);

      if ($query->execute()) {
        // Registrar la acción en un log si es necesario
        $this->registrarLog("Rechazo exitoso para ID: " . $item['id']);
        return "ok";
      } else {
        // Registrar el error en un log
        $this->registrarError("Error al aprobar ID: " . $item['id'] . ". Error: " . implode(", ", $query->errorInfo()));
        return "nok";
      }
    } catch (PDOException $e) {
      // Registrar la excepción en un log
      $this->registrarError("Excepción al aprobar ID: " . $item['id'] . ". Error: " . $e->getMessage());
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from contratacion where estado = 'pre_aprobado' and 
      idcontratacion = :id");
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
