<?php

include_once '../db.php';

class Sql extends DB{

    function listarFecha(){
          $query = $this->connect()->prepare("select date_format(curdate(),'%d/%m/%Y') fecha");
          if($query->execute()){
            return $query->fetchAll();
          }else{
            return null;		
          }
    }

    function listarCentroDeCosto(){
          $query = $this->connect()->prepare("select cen.descripcion, cen.idcentro_de_costo
          from centro_de_costo cen, empresa em
          where em.estado = 'activo' and em.idempresa = cen.empresa and cen.estado = 'activo'");
          if($query->execute()){
            return $query->fetchAll();
          }else{
            return null;		
          }
    }

    function listarMisRendiciones($item){
        $query = $this->connect()->prepare("select ren.idrendiciones, usu.nombre usuario, car.nombre dependendia, ren.saldo_inicial, ren.monto_rendido, ren.saldo,
        ren.comentario_adicional, upper(ren.estado) estado, date_format(ren.fecha_operacion,'%d/%m/%Y') fecha, ren.contiene_adjunto, ren.tipo_adjunto   
        from rendiciones ren, usuario car, usuario usu
        where ren.estado <> 'anulado' and ren.dependiente = car.idusuario and ren.usuario = usu.idusuario and ren.usuario = :id order by ren.idrendiciones desc");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function listarRendiciones($item){
        $query = $this->connect()->prepare("select ren.idrendiciones, usu.nombre usuario, car.nombre dependendia, ren.saldo_inicial, ren.monto_rendido, ren.saldo,
        ren.comentario_adicional, upper(ren.estado) estado, date_format(ren.fecha_operacion,'%d/%m/%Y') fecha, ren.contiene_adjunto, ren.tipo_adjunto    
        from rendiciones ren, usuario car, usuario usu
        where ren.estado <> 'anulado' and ren.dependiente = car.idusuario and ren.usuario = usu.idusuario and ren.dependiente = :usuario ".$item['estado']." order by ren.idrendiciones desc");
        $query->bindParam(":usuario", $item['usuario'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function listarCabeceraRendicion($item){
        $query = $this->connect()->prepare("select ren.idrendiciones, usu.nombre usuario, car.nombre dependendia, car.idusuario iddependencia, ren.saldo_inicial, ren.monto_rendido, ren.saldo,
        ren.comentario_adicional, upper(ren.estado) estado, date_format(ren.fecha_operacion,'%d/%m/%Y') fecha, if(isnull(ren.comentario_revision),'-',ren.comentario_revision) comentario_revision, ren.contiene_adjunto, ren.tipo_adjunto   
        from rendiciones ren, usuario car, usuario usu
        where ren.estado <> 'anulado' and ren.dependiente = car.idusuario and ren.usuario = usu.idusuario and ren.idrendiciones = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function listarDetalleRendicion($item){
        $query = $this->connect()->prepare("select det.iddetalle_rendicion, pro.descripcion proveedor, cen.descripcion centro_de_costo, det.fecha,
        det.tipo, det.nro_documento, det.monto, det.detalle, det.maquina
        from detalle_rendicion det, proveedor pro, centro_de_costo cen
        where det.proveedor = pro.idproveedor and det.centro_de_costo = cen.idcentro_de_costo and 
        det.rendiciones = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function agregarCabecera($item){
        $query = $this->connect()->prepare("insert rendiciones(usuario,dependiente,fecha_operacion,saldo_inicial,monto_rendido,saldo,comentario_adicional,estado) values(:usuario,:cargo,curdate(),:saldo_inicial,:monto_rendido,:saldo,:comentario_adicional,'pendiente')");
        $query->bindParam(":usuario", $item['usuario'], PDO::PARAM_STR);
        $query->bindParam(":cargo", $item['cargo'], PDO::PARAM_STR);
        $query->bindParam(":saldo_inicial", $item['saldo_inicial'], PDO::PARAM_STR);
        $query->bindParam(":monto_rendido", $item['monto_rendido'], PDO::PARAM_STR);
        $query->bindParam(":saldo", $item['saldo'], PDO::PARAM_STR);
        $query->bindParam(":comentario_adicional", $item['comentario_adicional'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function cargaDocumentoRendicion($item){
        $query = $this->connect()->prepare("update rendiciones set contiene_adjunto = 'si', tipo_adjunto = :extension where idrendiciones = :idRendicion");
        $query->bindParam(":idRendicion", $item['idRendicion'], PDO::PARAM_STR);
        $query->bindParam(":extension", $item['extension'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function idproveedor($item){
        $query = $this->connect()->prepare("select idproveedor from proveedor where descripcion  = :proveedor and estado = 'activo'");
        $query->bindParam(":proveedor", $item['proveedor'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function idcentro($item){
        $query = $this->connect()->prepare("select idcentro_de_costo from centro_de_costo where descripcion  = :centroDeCosto and estado = 'activo'");
        $query->bindParam(":centroDeCosto", $item['centroDeCosto'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function idRendicion(){
        $query = $this->connect()->prepare("select max(idrendiciones) id from rendiciones");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function agregarDetalle($item){
        $query = $this->connect()->prepare("insert detalle_rendicion(rendiciones,proveedor,centro_de_costo,fecha,tipo,nro_documento,monto,detalle,maquina) values(:idRendicion,:proveedor,:centroDeCosto,:fecha,:tipo,:nroDocumento,:monto,:detalle,:maquina)");
        $query->bindParam(":fecha", $item['fecha'], PDO::PARAM_STR);
        $query->bindParam(":tipo", $item['tipo'], PDO::PARAM_STR);
        $query->bindParam(":nroDocumento", $item['nroDocumento'], PDO::PARAM_STR);
        $query->bindParam(":monto", $item['monto'], PDO::PARAM_STR);
        $query->bindParam(":detalle", $item['detalle'], PDO::PARAM_STR);
        $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_STR);
        $query->bindParam(":centroDeCosto", $item['centroDeCosto'], PDO::PARAM_STR);
        $query->bindParam(":proveedor", $item['proveedor'], PDO::PARAM_STR);
        $query->bindParam(":idRendicion", $item['idRendicion'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function agregarItemRendicion($item){
        $query = $this->connect()->prepare("insert detalle_rendicion(rendiciones,proveedor,centro_de_costo,fecha,tipo,nro_documento,monto,detalle,maquina) values(:idRendicion,:proveedor,:centroDeCosto,:fecha,:tipo,:nroDocumento,:monto,:detalle,:maquina)");
        $query->bindParam(":fecha", $item['fecha'], PDO::PARAM_STR);
        $query->bindParam(":tipo", $item['tipo'], PDO::PARAM_STR);
        $query->bindParam(":nroDocumento", $item['nroDocumento'], PDO::PARAM_STR);
        $query->bindParam(":monto", $item['monto'], PDO::PARAM_STR);
        $query->bindParam(":detalle", $item['detalle'], PDO::PARAM_STR);
        $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_STR);
        $query->bindParam(":centroDeCosto", $item['centroDeCosto'], PDO::PARAM_STR);
        $query->bindParam(":proveedor", $item['proveedor'], PDO::PARAM_STR);
        $query->bindParam(":idRendicion", $item['id'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

     function actualizarCabeceraRendicion($item){
        $query = $this->connect()->prepare("update rendiciones set monto_rendido = :monto_rendido, saldo = :saldo where idrendiciones = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        $query->bindParam(":monto_rendido", $item['monto_rendido'], PDO::PARAM_STR);
        $query->bindParam(":saldo", $item['saldo'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function actualizarEstadoRendicion($item){
        $query = $this->connect()->prepare("update rendiciones set estado = :estado, comentario_revision = :comentario where idrendiciones = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        $query->bindParam(":estado", $item['estado'], PDO::PARAM_STR);
        $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function eliminarItemRendicion($item){
        $query = $this->connect()->prepare("delete from detalle_rendicion where iddetalle_rendicion = :idDetalle");
        $query->bindParam(":idDetalle", $item['idDetalle'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function listarMontoRendido($item){
      $query = $this->connect()->prepare("select sum(monto) monto from detalle_rendicion where rendiciones = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function obtenerDatosParaModificar($item){
      $query = $this->connect()->prepare("select * from tipo_epp where estado = 'activo' and 
      idtipo_epp = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function modificar($item){
      $query = $this->connect()->prepare("update tipo_epp set descripcion = :descripcion where idtipo_epp = :id and estado = 'activo'");
      $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function eliminar($item){
      $query = $this->connect()->prepare("update tipo_epp set estado = 'inactivo' where idtipo_epp = :id and estado = 'activo'");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function consultarNroFactura($item){
      $query = $this->connect()->prepare("select det.* 
        from detalle_rendicion det, rendiciones ren
        where ren.estado <> 'anulado' and ren.idrendiciones = det.rendiciones and 
        det.nro_documento = :nroDocumento");
      $query->bindParam(":nroDocumento", $item['nroDocumento'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

       
}



?>