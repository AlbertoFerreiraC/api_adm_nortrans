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
    $query = $this->connect()->prepare("INSERT INTO contratacion (
      cargo, empresa, centro_de_costo, turnos_laborales, tipo_bus, 
      pre_aprueba, aprueba, division, cantidad_solicitada, 
      licencia_de_conducir, fecha_requerida, 
      fecha_termino, remuneracion, comentario_general, 
      estado, motivo, tipo_contrato, entrevista_psicolaboral, 
      entrevista_tecnica, entrevista_conduccion
  ) VALUES (
      :cargo, :empresa, :centro_de_costo, :turnos_laborales, :tipo_bus, 
      :pre_aprueba, :aprueba, :division, :cantidad_solicitada, 
      :licencia_de_conducir, :fecha_requerida, 
      :fecha_termino, :remuneracion, :comentario_general, 
      'activo', :motivo, :tipo_contrato, :entrevista_psicolaboral, 
      :entrevista_tecnica, :entrevista_conduccion

  )");

    $query->bindParam(":cargo", $item['cargo'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":centro_de_costo", $item['centro_de_costo'], PDO::PARAM_STR);
    $query->bindParam(":turnos_laborales", $item['turnos_laborales'], PDO::PARAM_STR);
    $query->bindParam(":tipo_bus", $item['tipo_bus'], PDO::PARAM_STR);
    $query->bindParam(":pre_aprueba", $item['pre_aprueba'], PDO::PARAM_STR);
    $query->bindParam(":aprueba", $item['aprueba'], PDO::PARAM_STR);
    $query->bindParam(":division", $item['division'], PDO::PARAM_STR);
    $query->bindParam(":cantidad_solicitada", $item['cantidad_solicitada'], PDO::PARAM_STR);
    $query->bindParam(":licencia_de_conducir", $item['licencia_de_conducir'], PDO::PARAM_STR);
    $query->bindParam(":fecha_requerida", $item['fecha_requerida'], PDO::PARAM_STR);
    $query->bindParam(":fecha_termino", $item['fecha_termino'], PDO::PARAM_STR);
    $query->bindParam(":remuneracion", $item['remuneracion'], PDO::PARAM_STR);
    $query->bindParam(":motivo", $item['motivo'], PDO::PARAM_STR);
    $query->bindParam(":tipo_contrato", $item['tipoContrato'], PDO::PARAM_STR); 
    $query->bindParam(":entrevista_psicolaboral", $item['observacionEntrevistaPsicolaboral'], PDO::PARAM_STR);
    $query->bindParam(":entrevista_tecnica", $item['observacionEntrevistaTecnica'], PDO::PARAM_STR);
    $query->bindParam(":entrevista_conduccion", $item['observacionPruebaConduccion'], PDO::PARAM_STR);
    $query->bindParam(":comentario_general", $item['comentarioGeneral'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from contratacion where estado = 'activo' and 
      idcontratacion = :id");
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
        centro_de_costo = :centroDeCosto, 
        turnos_laborales = :turnosLaborales, 
        tipo_bus = :tipoBus, 
        pre_aprueba = :preAprueba, 
        aprueba = :aprueba, 
        motivo = :motivo, 
        cantidad_solicitada = :cantidadSolicitada, 
        licencia_de_conducir = :licenciaDeConducir, 
        tipo_documento = :tipoDocumento, 
        fecha_requerida = :fechaRequerida, 
        fecha_termino = :fechaTermino, 
        remuneracion = :remuneracion, 
        comentario_general = :comentarioGeneral
        WHERE idcontratacion = :idcontratacion AND estado = 'activo';");

    $query->bindParam(":idcontratacion", $item['idcontratacion'], PDO::PARAM_INT);
    $query->bindParam(":cargo", $item['cargo'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":centroDeCosto", $item['centroDeCosto'], PDO::PARAM_STR);
    $query->bindParam(":turnosLaborales", $item['turnosLaborales'], PDO::PARAM_STR);
    $query->bindParam(":tipoBus", $item['tipoBus'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba", $item['pre_aprueba'], PDO::PARAM_STR);
    $query->bindParam(":aprueba", $item['aprueba'], PDO::PARAM_STR);
    $query->bindParam(":motivo", $item['motivo'], PDO::PARAM_STR);
    $query->bindParam(":cantidadSolicitada", $item['cantidad_solicitada'], PDO::PARAM_INT);
    $query->bindParam(":licenciaDeConducir", $item['licencia_de_conducir'], PDO::PARAM_STR);
    $query->bindParam(":tipoDocumento", $item['tipo_documento'], PDO::PARAM_STR);
    $query->bindParam(":fechaRequerida", $item['fecha_requerida'], PDO::PARAM_STR);
    $query->bindParam(":fechaTermino", $item['fecha_termino'], PDO::PARAM_STR);
    $query->bindParam(":remuneracion", $item['remuneracion'], PDO::PARAM_STR);
    $query->bindParam(":comentarioGeneral", $item['comentario_general'], PDO::PARAM_STR);

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
