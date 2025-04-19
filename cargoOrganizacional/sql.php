<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    $query = $this->connect()->prepare("select * from cargo_organizacional where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarCargos()
  {
    $query = $this->connect()->prepare("SELECT con.idcontratacion,
        em.descripcion empresa,
        if(ISNULL(con.fecha_requerida),'', DATE_FORMAT(con.fecha_requerida,'%d/%m/%y')) fecha_requerida,
        usu.nombre realizado_por,
        con.division,
        car.descripcion cargo,
        con.cantidad_solicitada,
        con.cantidad_contratada
        FROM contratacion con, usuario usu,cargo car, empresa em,
        usuario pre_aprueba, usuario aprueba
        WHERE con.estado = 'activo' AND con.usuario = usu.idusuario AND 
        con.cargo = car.idcargo AND con.empresa = em.idempresa  AND  con.pre_aprueba = pre_aprueba.idusuario AND 
        con.aprueba = aprueba.idusuario");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from cargo_organizacional where estado = 'activo' and 
        idcargo_organizacional = :idcargo_organizacional");
    $query->bindParam(":idcargo_organizacional", $item['idcargo_organizacional'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregar($item)
  {
    $query = $this->connect()->prepare("INSERT INTO cargo_organizacional (area_negocio, area_dependencia, nombre, division, solicitud_personal, autoriza_ms, autoriza_oc, aprueba_solicitud, estado) VALUES  (:area_negocio, :area_dependencia, :nombre, :division, :solicitud_personal, :autoriza_ms, :autoriza_oc, :aprueba_solicitud,'activo');");

    $query->bindParam(":area_negocio", $item['area_negocio'], PDO::PARAM_STR);
    $query->bindParam(":area_dependencia", $item['area_dependencia'], PDO::PARAM_STR);
    $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
    $query->bindParam(":division", $item['division'], PDO::PARAM_STR);
    $query->bindParam(":solicitud_personal", $item['solicitud_personal'], PDO::PARAM_STR);
    $query->bindParam(":autoriza_ms", $item['autoriza_ms'], PDO::PARAM_STR);
    $query->bindParam(":autoriza_oc", $item['autoriza_oc'], PDO::PARAM_STR);
    $query->bindParam(":aprueba_solicitud", $item['aprueba_solicitud'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("update cargo_organizacional set estado = 'inactivo' where idcargo_organizacional = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from cargo_organizacional where estado = 'activo' and 
      idcargo_organizacional = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("UPDATE cargo_organizacional
                                        SET
                                        area_negocio = :area_negocio, 
                                        area_dependencia = :area_dependencia, 
                                        nombre = :nombre, 
                                        division = :division, 
                                        solicitud_personal = :solicitud_personal, 
                                        autoriza_ms = :autoriza_ms , 
                                        autoriza_oc = :autoriza_oc, 
                                        aprueba_solicitud = :aprueba_solicitud
                                        WHERE idcargo_organizacional = :idcargo_organizacional 
                                        and estado = 'activo';");
    $query->bindParam(":idcargo_organizacional", $item['idcargo_organizacional'], PDO::PARAM_STR);
    $query->bindParam(":area_negocio", $item['area_negocio'], PDO::PARAM_STR);
    $query->bindParam(":area_dependencia", $item['area_dependencia'], PDO::PARAM_STR);
    $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
    $query->bindParam(":division", $item['division'], PDO::PARAM_STR);
    $query->bindParam(":solicitud_personal", $item['solicitud_personal'], PDO::PARAM_STR);
    $query->bindParam(":autoriza_ms", $item['autoriza_ms'], PDO::PARAM_STR);
    $query->bindParam(":autoriza_oc", $item['autoriza_oc'], PDO::PARAM_STR);
    $query->bindParam(":aprueba_solicitud", $item['aprueba_solicitud'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
