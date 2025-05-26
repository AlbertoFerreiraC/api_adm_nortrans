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
        idmaquina = :idmaquina");
    $query->bindParam(":idmaquina", $item['idmaquina'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregar($item)
  {
    $query = $this->connect()->prepare("INSERT INTO maquina (patente, numero_interno_maquina, tipo_maquina, anho_maquina, capacidad_estanque, secuencia_mantenimiento, numero_asientos, numero_puertas, centro_de_costo, padron, estado VALUES (:patente, :numero_interno_maquina, :tipo_maquina, :anho_maquina, :capacidad_estanque, :secuencia_mantenimiento, :numero_asientos, :numero_puertas, :padron, 'activo');");

    $query->bindParam(":patente", $item['patente'], PDO::PARAM_STR);
    $query->bindParam(":numero_interno_maquina", $item['numero_interno_maquina'], PDO::PARAM_STR);
    $query->bindParam(":tipo_maquina", $item['tipo_maquina'], PDO::PARAM_STR);
    $query->bindParam(":anho_maquina", $item['anho_maquina'], PDO::PARAM_STR);
    $query->bindParam(":capacidad_estanque", $item['capacidad_estanque'], PDO::PARAM_STR);
    $query->bindParam(":secuencia_mantenimiento", $item['secuencia_mantenimiento'], PDO::PARAM_STR);
    $query->bindParam(":numero_asientos", $item['numero_asientos'], PDO::PARAM_STR);
    $query->bindParam(":numero_puertas", $item['numero_puertas'], PDO::PARAM_STR);
    $query->bindParam(":centro_de_costo", $item['centro_de_costo'], PDO::PARAM_STR);
    $query->bindParam(":padron", $item['padron'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return $query;
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from maquina where estado = 'activo' and 
      idmaquina = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("UPDATE contratacion SET 
        cargo = :cargo, 
        empresa = :empresa, 
        centro_de_costo = :centro_de_costo, 
        turnos_laborales = :turnos_laborales, 
        tipo_bus = :tipo_bus, 
        pre_aprueba = :pre_aprueba, 
        aprueba = :aprueba, 
        division = :division, 
        cantidad_solicitada = :cantidad_solicitada, 
        licencia_de_conducir = :licencia_de_conducir, 
        fecha_requerida = :fecha_requerida, 
        fecha_termino = :fecha_termino, 
        remuneracion = :remuneracion, 
        comentario_general = :comentario_general, 
        motivo = :motivo, 
        tipo_contrato = :tipo_contrato,        
        observacion_pre_aprobacion = :observacion_pre_aprobacion,
        fecha_pre_aperobacion = :fecha_pre_aperobacion,
        fecha_aprobacion = :fecha_aprobacion,
        observacion_aprobacion = :observacion_aprobacion
    WHERE idcontratacion = :idcontratacion AND estado = 'activo';");

    $query->bindParam(":idcontratacion", $item['idcontratacion'], PDO::PARAM_INT);
    $query->bindParam(":cargo", $item['cargo'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":centro_de_costo", $item['centro_de_costo'], PDO::PARAM_STR);
    $query->bindParam(":turnos_laborales", $item['turnos_laborales'], PDO::PARAM_STR);
    $query->bindParam(":tipo_bus", $item['tipo_bus'], PDO::PARAM_STR);
    $query->bindParam(":pre_aprueba", $item['pre_aprueba'], PDO::PARAM_STR);
    $query->bindParam(":aprueba", $item['aprueba'], PDO::PARAM_STR);
    $query->bindParam(":division", $item['division'], PDO::PARAM_STR);
    $query->bindParam(":cantidad_solicitada", $item['cantidad_solicitada'], PDO::PARAM_INT);
    $query->bindParam(":licencia_de_conducir", $item['licencia_de_conducir'], PDO::PARAM_STR);
    $query->bindParam(":fecha_requerida", $item['fecha_requerida'], PDO::PARAM_STR);
    $query->bindParam(":fecha_termino", $item['fecha_termino'], PDO::PARAM_STR);
    $query->bindParam(":remuneracion", $item['remuneracion'], PDO::PARAM_STR);
    $query->bindParam(":comentario_general", $item['comentario_general'], PDO::PARAM_STR);
    $query->bindParam(":motivo", $item['motivo'], PDO::PARAM_STR);
    $query->bindParam(":tipo_contrato", $item['tipo_contrato'], PDO::PARAM_STR);
    $query->bindParam(":observacion_pre_aprobacion", $item['observacion_pre_aprobacion'], PDO::PARAM_STR);
    $query->bindParam(":fecha_pre_aperobacion", $item['fecha_pre_aperobacion'], PDO::PARAM_STR);
    $query->bindParam(":observacion_aprobacion", $item['observacion_aprobacion'], PDO::PARAM_STR);
    $query->bindParam(":fecha_aprobacion", $item['fecha_aprobacion'], PDO::PARAM_STR);

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
