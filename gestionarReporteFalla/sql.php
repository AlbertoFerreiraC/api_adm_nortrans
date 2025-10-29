<?php

include_once '../db.php';

class Sql extends DB{


    function listarConductores(){
        $query = $this->connect()->prepare("select * from conductor where estado = 'activo'");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function idReporte(){
        $query = $this->connect()->prepare("select max(idreporte_falla) id from reporte_falla");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function procesarCabecera($item){
        $query = $this->connect()->prepare("insert reporte_falla(usuario,conductor,maquina,km_reportado,fecha,estado) values(:idUsuario,:conductor,:maquina,:kmActual,curdate(),'activo')");
        $query->bindParam(":idUsuario", $item['idUsuario'], PDO::PARAM_STR);
        $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_STR);
        $query->bindParam(":kmActual", $item['kmActual'], PDO::PARAM_STR);
        $query->bindParam(":conductor", $item['conductor'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function procesarDetalle($item){
        $query = $this->connect()->prepare("insert detalle_reporte_falla(reporte_falla,sistema_maquina,sub_sistema_maquina,observacion) values(:idFalla,:sistema,:subSistema,:observacion)");
        $query->bindParam(":idFalla", $item['idFalla'], PDO::PARAM_STR);
        $query->bindParam(":sistema", $item['sistema'], PDO::PARAM_STR);
        $query->bindParam(":subSistema", $item['subSistema'], PDO::PARAM_STR);
        $query->bindParam(":observacion", $item['observacion'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function listaReporteFalla(){
        $query = $this->connect()->prepare("select report.idreporte_falla, 
              con.nombre conductor, 
              ma.descripcion maquina, 
              report.km_reportado, 
              date_format(report.fecha,'%d/%m/%Y') fecha
          from reporte_falla report, conductor con, maquina ma
          where report.estado = 'activo' and report.conductor = con.idconductor and 
          report.maquina = ma.idmaquina");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function obtenerDatosParaModificar($item){
      $query = $this->connect()->prepare("select * from reporte_falla where idreporte_falla = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function obtenerDetalleFallas($item){
      $query = $this->connect()->prepare("select det.iddetalle_reporte_falla, sis.descripcion sistema, sub.descripcion sub_sistema,det.observacion  
      from detalle_reporte_falla det, sistema_maquina sis, sub_sistema_maquina sub 
      where det.reporte_falla = :id and det.sistema_maquina = sis.idsistema_maquina and 
      det.sub_sistema_maquina = sub.idsub_sistema_maquina");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function modificar($item){
      $query = $this->connect()->prepare("update reporte_falla set maquina = :maquina,conductor = :conductor, km_reportado = :kmActual where idreporte_falla = :id and estado = 'activo'");      
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_STR);
      $query->bindParam(":kmActual", $item['kmActual'], PDO::PARAM_STR);
      $query->bindParam(":conductor", $item['conductor'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function eliminar($item){
      $query = $this->connect()->prepare("update reporte_falla set estado = 'inactivo' where idreporte_falla = :id and estado = 'activo'");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function eliminarFalla($item){
      $query = $this->connect()->prepare("delete from detalle_reporte_falla where iddetalle_reporte_falla = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

       
}



?>