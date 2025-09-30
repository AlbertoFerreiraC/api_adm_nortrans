<?php

include_once '../db.php';

class Sql extends DB{


  function listar(){
    $query = $this->connect()->prepare("select 
    fon.idfondo_para_rendicion,
    date_format(fon.fecha_carga,'%d/%m/%Y') fecha_carga,
    usu.nombre realizado_por,
    otorgado.nombre otorgado_a,
    fon.monto,
    if(isnull(fon.pre_aprueba),'-',pre_aprueba.nombre) pre_aprueba,
    if(isnull(fon.aprueba),'-',aprueba.nombre) aprueba,
    if(isnull(fon.fecha_pre_aprobacion),'-',fon.fecha_pre_aprobacion) fecha_pre_aprobacion,
    if(isnull(fon.fecha_aprobacion),'-',fon.fecha_aprobacion) fecha_aprobacion,
    if(isnull(fon.motivo),'',fon.motivo) motivo,
    if(isnull(fon.observacion_pre_aprobacion),'',fon.observacion_pre_aprobacion) observacion_pre_aprobacion,
    if(isnull(fon.observacion_aprobacion),'',fon.observacion_aprobacion) observacion_aprobacion,
    if(isnull(fon.motivo_baja),'',fon.motivo_baja) motivo_baja, fon.estado
    from usuario usu, usuario otorgado, usuario pre_aprueba, usuario aprueba, fondo_para_rendicion fon
    where fon.usuario = usu.idusuario and fon.pre_aprueba = pre_aprueba.idusuario and fon.aprueba = aprueba.idusuario and 
    fon.asignar_a = otorgado.idusuario");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarPreAprobaciones($item){
    $query = $this->connect()->prepare("select 
    fon.idfondo_para_rendicion,
    date_format(fon.fecha_carga,'%d/%m/%Y') fecha_carga,
    usu.nombre realizado_por,
    otorgado.nombre otorgado_a,
    fon.monto,
    if(isnull(fon.pre_aprueba),'-',pre_aprueba.nombre) pre_aprueba,
    if(isnull(fon.aprueba),'-',aprueba.nombre) aprueba,
    if(isnull(fon.fecha_pre_aprobacion),'-',fon.fecha_pre_aprobacion) fecha_pre_aprobacion,
    if(isnull(fon.fecha_aprobacion),'-',fon.fecha_aprobacion) fecha_aprobacion,
    if(isnull(fon.motivo),'',fon.motivo) motivo,
    if(isnull(fon.observacion_pre_aprobacion),'',fon.observacion_pre_aprobacion) observacion_pre_aprobacion,
    if(isnull(fon.observacion_aprobacion),'',fon.observacion_aprobacion) observacion_aprobacion,
    if(isnull(fon.motivo_baja),'',fon.motivo_baja) motivo_baja, fon.estado
    from usuario usu, usuario otorgado, usuario pre_aprueba, usuario aprueba, fondo_para_rendicion fon
    where fon.usuario = usu.idusuario and fon.pre_aprueba = pre_aprueba.idusuario and fon.aprueba = aprueba.idusuario and 
    fon.asignar_a = otorgado.idusuario and fon.pre_aprueba = :usuario");
    $query->bindParam(":usuario", $item['usuario'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarAprobaciones($item){
    $query = $this->connect()->prepare("select 
      fon.idfondo_para_rendicion,
      date_format(fon.fecha_carga,'%d/%m/%Y') fecha_carga,
      usu.nombre realizado_por,
      otorgado.nombre otorgado_a,
      fon.monto,
      if(isnull(fon.pre_aprueba),'-',pre_aprueba.nombre) pre_aprueba,
      if(isnull(fon.aprueba),'-',aprueba.nombre) aprueba,
      if(isnull(fon.fecha_pre_aprobacion),'-',fon.fecha_pre_aprobacion) fecha_pre_aprobacion,
      if(isnull(fon.fecha_aprobacion),'-',fon.fecha_aprobacion) fecha_aprobacion,
      if(isnull(fon.motivo),'',fon.motivo) motivo,
      if(isnull(fon.observacion_pre_aprobacion),'',fon.observacion_pre_aprobacion) observacion_pre_aprobacion,
      if(isnull(fon.observacion_aprobacion),'',fon.observacion_aprobacion) observacion_aprobacion,
      if(isnull(fon.motivo_baja),'',fon.motivo_baja) motivo_baja, fon.estado
      from usuario usu, usuario otorgado, usuario pre_aprueba, usuario aprueba, fondo_para_rendicion fon
      where fon.usuario = usu.idusuario and fon.pre_aprueba = pre_aprueba.idusuario and fon.aprueba = aprueba.idusuario and 
      fon.asignar_a = otorgado.idusuario and fon.aprueba = :usuario");
    $query->bindParam(":usuario", $item['usuario'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from fondo_para_rendicion where estado = 'aprobado' and 
        asignar_a = :otorgar");
    $query->bindParam(":otorgar", $item['otorgar'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregar($item)
  {
    $query = $this->connect()->prepare("insert fondo_para_rendicion(usuario,asignar_a,pre_aprueba,aprueba,monto,fecha_carga,motivo,estado) values(:idUsuario,:otorgar,:preAprueba,:aprueba,:montoSolicitado,curdate(),:motivo,'pendiente')");
    $query->bindParam(":idUsuario", $item['idUsuario'], PDO::PARAM_STR);
    $query->bindParam(":montoSolicitado", $item['montoSolicitado'], PDO::PARAM_STR);
    $query->bindParam(":otorgar", $item['otorgar'], PDO::PARAM_STR);
    $query->bindParam(":motivo", $item['motivo'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba", $item['preAprueba'], PDO::PARAM_STR);
    $query->bindParam(":aprueba", $item['aprueba'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select 
      fon.idfondo_para_rendicion,
      date_format(fon.fecha_carga,'%d/%m/%Y') fecha_carga,
      usu.nombre realizado_por,
      otorgado.nombre otorgado_a,
      fon.monto,
      if(isnull(fon.pre_aprueba),'-',pre_aprueba.nombre) pre_aprueba,
      if(isnull(fon.aprueba),'-',aprueba.nombre) aprueba,
      if(isnull(fon.fecha_pre_aprobacion),'-',date_format(fon.fecha_pre_aprobacion,'%d/%m/%Y')) fecha_pre_aprobacion,
      if(isnull(fon.fecha_aprobacion),'-',date_format(fon.fecha_aprobacion,'%d/%m/%Y')) fecha_aprobacion,
      if(isnull(fon.motivo),'',fon.motivo) motivo,
      if(isnull(fon.observacion_pre_aprobacion),'',fon.observacion_pre_aprobacion) observacion_pre_aprobacion,
      if(isnull(fon.observacion_aprobacion),'',fon.observacion_aprobacion) observacion_aprobacion,
      if(isnull(fon.motivo_baja),'',fon.motivo_baja) motivo_baja, fon.estado
      from usuario usu, usuario otorgado, usuario pre_aprueba, usuario aprueba, fondo_para_rendicion fon
      where fon.usuario = usu.idusuario and fon.pre_aprueba = pre_aprueba.idusuario and fon.aprueba = aprueba.idusuario and 
      fon.asignar_a = otorgado.idusuario and fon.idfondo_para_rendicion = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("update cargo set descripcion = :descripcion where idcargo = :id and estado = 'activo'");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function actualizarEstadoFondo($item){
    $query = $this->connect()->prepare("update fondo_para_rendicion set estado = :estado, motivo_baja = :comentario 
    where idfondo_para_rendicion = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    $query->bindParam(":estado", $item['estado'], PDO::PARAM_STR);
    $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function actualizarPreAprobacion($item){
    $query = $this->connect()->prepare("update fondo_para_rendicion set estado = :estado, observacion_pre_aprobacion = :comentario 
    where idfondo_para_rendicion = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    $query->bindParam(":estado", $item['estado'], PDO::PARAM_STR);
    $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function actualizarAprobacion($item){
    $query = $this->connect()->prepare("update fondo_para_rendicion set estado = :estado, observacion_aprobacion = :comentario 
    where idfondo_para_rendicion = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    $query->bindParam(":estado", $item['estado'], PDO::PARAM_STR);
    $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function listarMontoRendicion($item){
    $query = $this->connect()->prepare("select if(isnull((select monto from fondo_para_rendicion where asignar_a = :id and estado = 'aprobado')),0,
    (select monto from fondo_para_rendicion where asignar_a = :id and estado = 'aprobado')) monto");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

}
