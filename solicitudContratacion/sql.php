<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas()
  {
    $query = $this->connect()->prepare("select * from contratacion where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
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

  function agregar($item)
  {
    $query = $this->connect()->prepare("INSERT INTO contratacion (cargo, empresa, centro_de_costo, turnos_laborales, tipo_bus, pre_aprueba, aprueba, motivo, cantidad_solicitada, licencia_de_conducir, tipo_documento, fecha_requerida, fecha_termino, remuneracion, comentario_general, estado) VALUES(:cargo, :empresa, :centro_de_costo, :turnos_laborales, :tipo_bus, :pre_aprueba, :aprueba, :motivo, :cantidad_solicitada, :licencia_de_conducir, :tipo_documento, :fecha_requerida, :fecha_termino, :remuneracion, :comentario_general, 'activo');");
    $query->bindParam(":cargo", $item['cargo'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":centro_de_costo", $item['centroDeCosto'], PDO::PARAM_STR);
    $query->bindParam(":turnos_laborales", $item['turnosLaborales'], PDO::PARAM_STR);
    $query->bindParam(":tipo_bus", $item['tipoBus'], PDO::PARAM_STR);
    $query->bindParam(":pre_aprueba", $item['preAprueba'], PDO::PARAM_STR);
    $query->bindParam(":aprueba", $item['aprueba'], PDO::PARAM_STR);
    $query->bindParam(":motivo", $item['motivo'], PDO::PARAM_STR);
    $query->bindParam(":cantiad_solicitada", $item['cantiadSolicitada'], PDO::PARAM_STR);
    $query->bindParam(":licencia_de_conducir", $item['licenciaDeConducir'], PDO::PARAM_STR);
    $query->bindParam(":tipo_documento", $item['tipoDocumento'], PDO::PARAM_STR);
    $query->bindParam(":fecha_requerida", $item['fechaRequerida'], PDO::PARAM_STR);
    $query->bindParam(":fecha_termino", $item['fechaTermino'], PDO::PARAM_STR);
    $query->bindParam(":remuneracion", $item['remuneracion'], PDO::PARAM_STR);
    $query->bindParam(":comentario_general", $item['comentarioGeneral'], PDO::PARAM_STR);
    $query->bindParam(":estado", $item['estado'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
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
	cargo = :cargo , 
	empresa = :empresa , 
	centro_de_costo = :centroDeCosto , 
	turnos_laborales = :turnosLaborales , 
	tipo_bus = :tipoBus , 
	pre_aprueba = :preAprueba , 
	aprueba = :aprueba , 
	motivo = :motivo , 
	cantidad_solicitada = :cantidadSolicitada , 
	licencia_de_conducir = :licenciaDeConducir , 
	tipo_documento = :tipoDocumento , 
	fecha_requerida = :fechaRequerida , 
	fecha_termino = :fechaTermino , 
	remuneracion = :remuneracion , 
	comentario_general = :comentarioGeneral:
	WHERE
	idcontratacion = :idcontratacion AND estado = 'Activo';");
    $query->bindParam(":cargo", $item['cargo'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":centro_de_costo", $item['centroDeCosto'], PDO::PARAM_STR);
    $query->bindParam(":turnos_laborales", $item['turnosLaborales'], PDO::PARAM_STR);
    $query->bindParam(":tipo_bus", $item['tipoBus'], PDO::PARAM_STR);
    $query->bindParam(":pre_aprueba", $item['preAprueba'], PDO::PARAM_STR);
    $query->bindParam(":aprueba", $item['aprueba'], PDO::PARAM_STR);
    $query->bindParam(":motivo", $item['motivo'], PDO::PARAM_STR);
    $query->bindParam(":cantiad_solicitada", $item['cantiadSolicitada'], PDO::PARAM_STR);
    $query->bindParam(":licencia_de_conducir", $item['licenciadeConducir'], PDO::PARAM_STR);
    $query->bindParam(":tipo_documento", $item['tipoDocumento'], PDO::PARAM_STR);
    $query->bindParam(":fecha_requerida", $item['fechaRequerida'], PDO::PARAM_STR);
    $query->bindParam(":fecha_termino", $item['fechaTermino'], PDO::PARAM_STR);
    $query->bindParam(":remuneracion", $item['remuneracion'], PDO::PARAM_STR);
    $query->bindParam(":comentario_general", $item['comentarioGeneral'], PDO::PARAM_STR);
    $query->bindParam(":estado", $item['estado'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminar($item)
  {
    $query = $this->connect()->prepare("update contratacion set estado = 'inactivo' where idcontratacion = :idcontratacion and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
