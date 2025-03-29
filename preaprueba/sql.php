<?php

include_once '../db.php';

class Sql extends DB
{

  function listarHerramientas($item)
  {
    $query = $this->connect()->prepare("SELECT * FROM contratacion WHERE estado = 'activo' and pre_aprueba = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarPreApruebaApi($item)
  {
    $query = $this->connect()->prepare("SELECT con.idcontratacion,
        con.division,
        emp.descripcion empresa,
        car.descripcion cargo,
        cdc.descripcion centro_de_costo,
        usu.nombre pre_aprueba
        FROM contratacion con
        JOIN empresa emp ON emp.idempresa = con.empresa
        JOIN cargo car ON car.idcargo = con.cargo
        JOIN centro_de_costo cdc ON cdc.idcentro_de_costo = con.centro_de_costo
        JOIN usuario usu ON usu.idusuario = con.usuario
        WHERE con.estado = 'activo'
        AND con.pre_aprueba = :id");
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

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from contratacion where estado = 'activo' and 
        idcontratacion = :idcontratacion");
    $query->bindParam(":idcontratacion", $item['idcontratacion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("UPDATE contratacion SET
        observacion_pre_aprobacion = :observacion_pre_aprobacion,
        fecha_pre_aperobacion = :fecha_pre_aperobacion
        WHERE
        idcontratacion = :idcontratacion AND estado = 'activo';");

    $query->bindParam(":idcontratacion", $item['idcontratacion'], PDO::PARAM_INT);
    $query->bindParam(":cargo", $item['cargo'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":division", $item['division'], PDO::PARAM_STR);
    $query->bindParam(":centro_de_costo", $item['centro_de_costo'], PDO::PARAM_STR);
    $query->bindParam(":turnos_laborales", $item['turnos_laborales'], PDO::PARAM_STR);
    $query->bindParam(":tipo_bus", $item['tipo_bus'], PDO::PARAM_STR);
    $query->bindParam(":pre_aprueba", $item['pre_aprueba'], PDO::PARAM_STR);
    $query->bindParam(":aprueba", $item['aprueba'], PDO::PARAM_STR);
    $query->bindParam(":motivo", $item['motivo'], PDO::PARAM_STR);
    $query->bindParam(":cantidad_solicitada", $item['cantidad_solicitada'], PDO::PARAM_STR);
    $query->bindParam(":licencia_de_conducir", $item['licencia_de_conducir'], PDO::PARAM_STR);
    $query->bindParam(":tipo_contrato", $item['tipo_contrato'], PDO::PARAM_STR);
    $query->bindParam(":fecha_requerida", $item['fecha_requerida'], PDO::PARAM_STR);
    $query->bindParam(":fecha_termino", $item['fecha_termino'], PDO::PARAM_STR);
    $query->bindParam(":remuneracion", $item['remuneracion'], PDO::PARAM_STR);
    $query->bindParam(":observacion_pre_aprobacion", $item['observacion_pre_aprobacion'], PDO::PARAM_STR);
    $query->bindParam(":fecha_pre_aperobacion", $item['fecha_pre_aperobacion'], PDO::PARAM_STR);

    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function rechazar($item)
  {
    $query = $this->connect()->prepare("update contratacion set estado = 'no_pre_aprobado' where idcontratacion = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
