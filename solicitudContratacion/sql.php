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

  function listarContratado()
  {
    $query = $this->connect()->prepare("SELECT con.idcontratacion,
        usu.nombre realizado_por, 
        car.descripcion cargo,
        em.descripcion empresa,
        cen.descripcion centro_de_costo,
        tur.descripcion turnos_laborales,
        pre_aprueba.nombre pre_aprueba,
        aprueba.nombre aprueba,
        con.division,
        con.cantidad_solicitada,
        con.licencia_de_conducir,
        if(ISNULL(con.fecha_requerida),'',DATE_FORMAT(con.fecha_requerida,'%d/%m/%y')) fecha_requerida,
        con.fecha_termino,
        con.remuneracion,
        con.comentario_general,
        con.motivo,
        con.estado,
        con.tipo_contrato,
        con.entrevista_psicolaboral,
        con.entrevista_tecnica,
        con.entrevista_conduccion,
        if(ISNULL(con.fecha_pre_aperobacion),'',DATE_FORMAT(con.fecha_pre_aperobacion,'%d/%m/%y')) fecha_pre_aperobacion,
        if(ISNULL(con.observacion_aprobacion),'',con.observacion_aprobacion) observacion_aprobacion,
        con.fecha_inicio_laboral,
        con.cantidad_contratada,
        tip.descripcion tipo_bus
        FROM contratacion con, usuario usu,cargo car, empresa em,centro_de_costo cen,
        turnos_laborales tur, usuario pre_aprueba, usuario aprueba, tipo_bus tip
        WHERE con.estado = 'contratado' AND con.usuario = usu.idusuario AND 
        con.cargo = car.idcargo AND con.empresa = em.idempresa AND 
        con.centro_de_costo = cen.idcentro_de_costo AND con.turnos_laborales =tur.idturnos_laborales AND con.pre_aprueba = pre_aprueba.idusuario AND 
        con.aprueba = aprueba.idusuario AND con.tipo_bus = tip.idtipo_bus");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarSolicitudes()
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
    $query->bindParam(":tipo_contrato", $item['tipo_contrato'], PDO::PARAM_STR);
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
        entrevista_psicolaboral = :entrevista_psicolaboral, 
        entrevista_tecnica = :entrevista_tecnica, 
        entrevista_conduccion = :entrevista_conduccion,
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
    $query->bindParam(":entrevista_psicolaboral", $item['entrevista_psicolaboral'], PDO::PARAM_STR);
    $query->bindParam(":entrevista_tecnica", $item['entrevista_tecnica'], PDO::PARAM_STR);
    $query->bindParam(":entrevista_conduccion", $item['entrevista_conduccion'], PDO::PARAM_STR);
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
    $query = $this->connect()->prepare("update contratacion set estado = 'inactivo' where idcontratacion = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }
}
