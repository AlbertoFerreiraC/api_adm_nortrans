<?php

include_once '../db.php';

class Sql extends DB{


    function listarHerramientas(){
        $query = $this->connect()->prepare("select 
        cen.idcentro_de_costo,
        cen.descripcion centro_de_costo,
        em.descripcion empresa 
    from centro_de_costo cen, empresa em 
    where cen.estado = 'activo' and cen.empresa = em.idempresa");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function verificar_existencia($item){
        $query = $this->connect()->prepare("select * from centro_de_costo where estado = 'activo' and 
        descripcion = :descripcion");
        $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function agregar($item){
        $query = $this->connect()->prepare("insert centro_de_costo(descripcion,empresa,estado) values(:descripcion,:empresa,'activo')");
        $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
        $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function obtenerDatosParaModificar($item){
      $query = $this->connect()->prepare("select 
        cen.idcentro_de_costo,
        cen.descripcion centro_de_costo,
        em.descripcion empresa,
        cen.empresa idempresa
    from centro_de_costo cen, empresa em 
    where cen.estado = 'activo' and cen.empresa = em.idempresa and cen.idcentro_de_costo = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function modificar($item){
      $query = $this->connect()->prepare("update centro_de_costo set descripcion = :descripcion, empresa = :empresa where idcentro_de_costo = :id and estado = 'activo'");
      $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
      $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function eliminar($item){
      $query = $this->connect()->prepare("update centro_de_costo set estado = 'inactivo' where idcentro_de_costo = :id and estado = 'activo'");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listadoDeCentroDeCostoPorEmpresa($item){
      $query = $this->connect()->prepare("select * from centro_de_costo where estado = 'activo' and empresa = :empresa");
      $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

       
}



?>