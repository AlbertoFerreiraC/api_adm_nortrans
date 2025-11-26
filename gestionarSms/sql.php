<?php

include_once '../db.php';

class Sql extends DB
{


  function listarBodegas(){
    $query = $this->connect()->prepare("select * from de_bodega where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarServicios(){
    $query = $this->connect()->prepare("select pro.idproducto id, 
          pro.descripcion, 
        uni.descripcion unidad_de_medida, 
        pro.unidad_medida cantidad_por_unidad, 
        '0' cantidad_en_bodega 
    from producto pro, unidad_de_medida uni
    where pro.estado = 'activo' and pro.unidad_de_medida = uni.idunidad_de_medida and pro.tipo_producto = 'Servicios'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarEpp(){
    $query = $this->connect()->prepare("select pro.idproducto id, 
          pro.descripcion, 
        uni.descripcion unidad_de_medida, 
        pro.unidad_medida cantidad_por_unidad, 
        '0' cantidad_en_bodega 
    from producto pro, unidad_de_medida uni
    where pro.estado = 'activo' and pro.unidad_de_medida = uni.idunidad_de_medida and pro.tipo_producto = 'EPP'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarInsumos(){
    $query = $this->connect()->prepare("select pro.idproducto id, 
          pro.descripcion, 
        uni.descripcion unidad_de_medida, 
        pro.unidad_medida cantidad_por_unidad, 
        '0' cantidad_en_bodega 
    from producto pro, unidad_de_medida uni
    where pro.estado = 'activo' and pro.unidad_de_medida = uni.idunidad_de_medida and pro.tipo_producto = 'Insumos'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarRepuestos(){
    $query = $this->connect()->prepare("select idrepuestos id, 
          descripcion, 
        '1' cantidad_por_unidad,
        'UNIDAD' unidad_de_medida,
        '0' cantidad_en_bodega 
    from repuestos where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarDatosEspecificosProductos($item){
    $query = $this->connect()->prepare("select pro.idproducto id, 
          pro.descripcion, 
        uni.descripcion unidad_de_medida, 
        pro.unidad_medida cantidad_por_unidad, 
        '0' cantidad_en_bodega 
    from producto pro, unidad_de_medida uni
    where pro.estado = 'activo' and pro.unidad_de_medida = uni.idunidad_de_medida and pro.tipo_producto = :tipo and pro.idproducto = :valor");
    $query->bindParam(":tipo", $item['tipo'], PDO::PARAM_STR);
    $query->bindParam(":valor", $item['valor'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarDatosEspecificosRepuestos($item){
    $query = $this->connect()->prepare("select idrepuestos id, 
          descripcion, 
        '1' cantidad_por_unidad,
        'UNIDAD' unidad_de_medida,
        '0' cantidad_en_bodega 
    from repuestos where estado = 'activo' and idrepuestos = :valor");
    $query->bindParam(":valor", $item['valor'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregarCabecera($item){
    $query = $this->connect()->prepare("insert sms(usuario,bodega,empresa,maquina,pre_aprueba,observacion,fecha_carga,estado,tipo) values(:usuario,:bodega,:empresa,:maquina,:preAprueba,:observacion,now(),'activo',:tipoSolicitud)");
    $query->bindParam(":usuario", $item['usuario'], PDO::PARAM_STR);
    $query->bindParam(":bodega", $item['bodega'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":tipoSolicitud", $item['tipoSolicitud'], PDO::PARAM_STR);
    $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba", $item['preAprueba'], PDO::PARAM_STR);
    $query->bindParam(":observacion", $item['observacion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function agregarCabeceraSinMaquina($item){
    $query = $this->connect()->prepare("insert sms(usuario,bodega,empresa,pre_aprueba,observacion,fecha_carga,estado,tipo) values(:usuario,:bodega,:empresa,:preAprueba,:observacion,now(),'activo',:tipoSolicitud)");
    $query->bindParam(":usuario", $item['usuario'], PDO::PARAM_STR);
    $query->bindParam(":bodega", $item['bodega'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":tipoSolicitud", $item['tipoSolicitud'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba", $item['preAprueba'], PDO::PARAM_STR);
    $query->bindParam(":observacion", $item['observacion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function maxIdSolicitud(){
    $query = $this->connect()->prepare("select max(idsms) id from sms");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregarDetalleSinRepuesto($item){
    $query = $this->connect()->prepare("insert detalle_sms(sms,centro_de_costo,repuestos,insumos,tipo,unidad_de_medida,cantidad,aplicacion) values(:idSolicitud,:centroDeCosto,null,:producto,:tipo,:unidadDeMedida,:cantidad,:aplicacion)");
    $query->bindParam(":producto", $item['producto'], PDO::PARAM_STR);
    $query->bindParam(":tipo", $item['tipo'], PDO::PARAM_STR);
    $query->bindParam(":unidadDeMedida", $item['unidadDeMedida'], PDO::PARAM_STR);
    $query->bindParam(":centroDeCosto", $item['centroDeCosto'], PDO::PARAM_STR);
    $query->bindParam(":cantidad", $item['cantidad'], PDO::PARAM_STR);
    $query->bindParam(":aplicacion", $item['aplicacion'], PDO::PARAM_STR);
    $query->bindParam(":idSolicitud", $item['idSolicitud'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function agregarDetalleSinProducto($item){
    $query = $this->connect()->prepare("insert detalle_sms(sms,centro_de_costo,repuestos,insumos,tipo,unidad_de_medida,cantidad,aplicacion) values(:idSolicitud,:centroDeCosto,:repuesto,null,:tipo,:unidadDeMedida,:cantidad,:aplicacion)");
    $query->bindParam(":repuesto", $item['repuesto'], PDO::PARAM_STR);
    $query->bindParam(":tipo", $item['tipo'], PDO::PARAM_STR);
    $query->bindParam(":unidadDeMedida", $item['unidadDeMedida'], PDO::PARAM_STR);
    $query->bindParam(":centroDeCosto", $item['centroDeCosto'], PDO::PARAM_STR);
    $query->bindParam(":cantidad", $item['cantidad'], PDO::PARAM_STR);
    $query->bindParam(":aplicacion", $item['aplicacion'], PDO::PARAM_STR);
    $query->bindParam(":idSolicitud", $item['idSolicitud'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function listarSolicitudesActivas(){
    $query = $this->connect()->prepare("select sm.idsms,em.descripcion empresa, bo.descripcion bodga, pre_aprueba.nombre pre_aprueba, date_format(sm.fecha_carga,'%d/%m/%Y') fecha,
    sm.tipo,sm.observacion, usu.nombre realizado
    from sms sm, empresa em, de_bodega bo,usuario pre_aprueba, usuario usu
    where sm.estado = 'activo' and sm.empresa = em.idempresa and sm.bodega = bo.idde_bodega and sm.pre_aprueba = pre_aprueba.idusuario and 
    sm.usuario = usu.idusuario");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarDatosDeSms($item){
    $query = $this->connect()->prepare("select * from sms where idsms = :idSolicitud");
    $query->bindParam(":idSolicitud", $item['idSolicitud'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarDatosDetalleSms($item){
    $query = $this->connect()->prepare("select det.*, 
		 cen.descripcion nombre_centro_de_costo, 
		 if(isnull(det.repuestos),'-',(select descripcion from repuestos where idrepuestos = det.repuestos)) descripcion_repuestos,
		 if(isnull(det.insumos),'-',(select descripcion from producto where idproducto = det.insumos)) descripcion_insumos
      from detalle_sms det, centro_de_costo cen
      where det.centro_de_costo = cen.idcentro_de_costo and det.sms =:idSolicitud");
    $query->bindParam(":idSolicitud", $item['idSolicitud'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function actualizarCantidadProducto($item){
    $query = $this->connect()->prepare("update detalle_sms set cantidad = :cantidad where iddetalle_sms = :idDetalle");
    $query->bindParam(":idDetalle", $item['idDetalle'], PDO::PARAM_STR);
    $query->bindParam(":cantidad", $item['cantidad'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminarProducto($item){
    $query = $this->connect()->prepare("delete from detalle_sms where iddetalle_sms = :idDetalle");
    $query->bindParam(":idDetalle", $item['idDetalle'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function actualizarCabecera($item){
    $query = $this->connect()->prepare("update sms set 
              bodega = :bodega,
              empresa = :empresa,
              maquina = :maquina,
              pre_aprueba = :preAprueba,
              tipo = :tipoSolicitud,
              observacion = :observacion 
              where idsms = :idSolicitud");
    $query->bindParam(":idSolicitud", $item['idSolicitud'], PDO::PARAM_STR);
    $query->bindParam(":bodega", $item['bodega'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":tipoSolicitud", $item['tipoSolicitud'], PDO::PARAM_STR);
    $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba", $item['preAprueba'], PDO::PARAM_STR);
    $query->bindParam(":observacion", $item['observacion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function actualizarCabeceraSinMaquina($item){
    $query = $this->connect()->prepare("update sms set 
              bodega = :bodega,
              empresa = :empresa,
              pre_aprueba = :preAprueba,
              tipo = :tipoSolicitud,
              observacion = :observacion 
              where idsms = :idSolicitud");
    $query->bindParam(":idSolicitud", $item['idSolicitud'], PDO::PARAM_STR);
    $query->bindParam(":bodega", $item['bodega'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":tipoSolicitud", $item['tipoSolicitud'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba", $item['preAprueba'], PDO::PARAM_STR);
    $query->bindParam(":observacion", $item['observacion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function controlVistaDetalleSms($item){
    $query = $this->connect()->prepare("SELECT det.*
        FROM detalle_oc det
        JOIN generar_oc gen ON gen.idgenerar_oc = det.generar_oc
        WHERE gen.estado NOT IN ('anulado', 'rechazado')
          AND det.detalle_sms = :idDetalle
          AND det.estado = 'ACTIVO'");
    $query->bindParam(":idDetalle", $item['idDetalle'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }



 
}
