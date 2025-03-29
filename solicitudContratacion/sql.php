<?php

include_once '../db.php';

class Sql extends DB
{


  function listarHerramientas(){
    $query = $this->connect()->prepare("select * from contratacion where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarRequisitoContratacion(){
    $query = $this->connect()->prepare("select * from requisito_de_seleccion where estado = 'activo'");
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
      usuario, cargo, empresa, centro_de_costo, turnos_laborales, tipo_bus, 
      pre_aprueba, aprueba, division, cantidad_solicitada, 
      licencia_de_conducir, fecha_requerida, 
      fecha_termino, remuneracion, comentario_general, 
      estado, motivo, tipo_contrato
  ) VALUES (
      :usuario,:cargo, :empresa, :centro_de_costo, :turnos_laborales, :tipo_bus, 
      :pre_aprueba, :aprueba, :division, :cantidad_solicitada, 
      :licencia_de_conducir, :fecha_requerida, 
      :fecha_termino, :remuneracion, :comentario_general, 
      'activo', :motivo, :tipo_contrato
)");
    $query->bindParam(":usuario", $item['usuario'], PDO::PARAM_STR);
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
    $query->bindParam(":comentario_general", $item['comentarioGeneral'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return $query;
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
    $query = $this->connect()->prepare("update contratacion set estado = 'inactivo' where idcontratacion = :id and estado = 'activo'");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerID(){
    $query = $this->connect()->prepare("select max(idcontratacion) id from contratacion");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregarDetalle($item)
  {
    $query = $this->connect()->prepare("insert into detalle_contratacion(contratacion,requisito_de_seleccion,observacion,estado) values(:contratacion,:requisito,:observacion,'activo')");
    $query->bindParam(":contratacion", $item['contratacion'], PDO::PARAM_STR);
    $query->bindParam(":requisito", $item['requisito'], PDO::PARAM_STR);
    $query->bindParam(":observacion", $item['observacion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function listarRequisitos($item)
  {
      $query = $this->connect()->prepare("select det.contratacion, det.iddetalle_contratacion, re.descripcion requisito, det.observacion
        from detalle_contratacion det, requisito_de_seleccion re
        where det.estado = 'activo' and det.requisito_de_seleccion = re.idrequisito_de_seleccion and 
        det.contratacion = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if ($query->execute()) {      
        return $query->fetchAll();
      } else {
        return null;
      }
    }

    function eliminarDetalle($item)
    {
      $query = $this->connect()->prepare("update detalle_contratacion set estado = 'inactivo' where iddetalle_contratacion = :contratacion");
      $query->bindParam(":contratacion", $item['contratacion'], PDO::PARAM_STR);
      if ($query->execute()) {
        return "ok";
      } else {
        return "nok";
      }
    }

  }

  

