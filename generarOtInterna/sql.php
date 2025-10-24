<?php

include_once '../db.php';

class Sql extends DB{


    function listarMaquinas(){
        $query = $this->connect()->prepare("select * from maquina where estado = 'activo'");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function listarTipoTarea(){
        $query = $this->connect()->prepare("select * from tipo_tarea_mantencion where estado = 'activo'");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function listarSistema(){
        $query = $this->connect()->prepare("select * from sistema_maquina where estado = 'activo'");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function listarSubSistema(){
        $query = $this->connect()->prepare("select * from sub_sistema_maquina where estado = 'activo'");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function listarPersonalTecnico(){
        $query = $this->connect()->prepare("select idpersonal_tecnico, nombre from personal_tecnico where estado = 'activo'");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function listarRepuestos(){
        $query = $this->connect()->prepare("select idrepuestos, descripcion from repuestos where estado = 'activo'");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }


    function verificar_existencia($item){
        $query = $this->connect()->prepare("select * from tipo_epp where estado = 'activo' and 
        descripcion = :descripcion");
        $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function procesarCabecera($item){
        $query = $this->connect()->prepare("
            INSERT INTO ot_interna (usuario, maquina, centro_de_costo, fecha, km_actual, estado)
            VALUES (:usuario, :maquina, :centro_de_costo, :fecha, :km_actual, 'activo')");
        $query->bindParam(":usuario", $item['idUsuario'], PDO::PARAM_INT);
        $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_INT);
        $query->bindParam(":centro_de_costo", $item['centroCosto'], PDO::PARAM_INT);
        $query->bindParam(":fecha", $item['fecha'], PDO::PARAM_STR);
        $query->bindParam(":km_actual", $item['kmActual'], PDO::PARAM_INT);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function procesarDetalleTarea($item){
        $query = $this->connect()->prepare("insert into tareas_ot (
              ot_interna,
              personal_tecnico,
              tipo_tarea_mantencion,
              sistema_maquina,
              sub_sistema_maquina,
              fecha,
              observacion,
              estado
          ) values (
              :ot_interna,
              :personal_tecnico,
              :tipo_tarea_mantencion,
              :sistema_maquina,
              :sub_sistema_maquina,
              :fecha,
              :observacion,
              'activo'
          )
      ");
      $query->bindParam(":ot_interna", $item['idOt'], PDO::PARAM_INT);
      $query->bindParam(":personal_tecnico", $item['tecnico'], PDO::PARAM_INT);
      $query->bindParam(":tipo_tarea_mantencion", $item['tipoTarea'], PDO::PARAM_INT);
      $query->bindParam(":sistema_maquina", $item['sistema'], PDO::PARAM_INT);
      $query->bindParam(":sub_sistema_maquina", $item['subSistema'], PDO::PARAM_INT);
      $query->bindParam(":fecha", $item['fechaHoraTarea'], PDO::PARAM_STR);
      $query->bindParam(":observacion", $item['observacion'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function procesarDetalleRepuesto($item){
        $query = $this->connect()->prepare("
            INSERT INTO repuestos_solicitados (ot_interna, repuestos, cantidad, estado)
            VALUES (:idOt, :repuesto, :cantidadRepuesto, 'activo')");
        $query->bindParam(":idOt", $item['idOt'], PDO::PARAM_INT);
        $query->bindParam(":repuesto", $item['repuesto'], PDO::PARAM_INT);
        $query->bindParam(":cantidadRepuesto", $item['cantidadRepuesto'], PDO::PARAM_INT);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function ultimoId(){
        $query = $this->connect()->prepare("select max(idot_interna) id from ot_interna");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function listarOtsGeneradas(){
        $query = $this->connect()->prepare("select idot_interna,date_format(fecha,'%d/%m/%Y') fecha 
          from ot_interna 
          where estado = 'activo' order by idot_interna desc");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }



    function obtenerDatosCabecera($item){
      $query = $this->connect()->prepare("select * from ot_interna where idot_interna = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function modificarCabecera($item){
      $query = $this->connect()->prepare("update ot_interna set 
            fecha = :fecha,
            km_actual = :kmActual,
            maquina = :maquina,
            centro_de_costo = :centroCosto
           where idot_interna = :idOt");
        $query->bindParam(":idOt", $item['idOt'], PDO::PARAM_STR);
        $query->bindParam(":fecha", $item['fecha'], PDO::PARAM_STR);
        $query->bindParam(":kmActual", $item['kmActual'], PDO::PARAM_STR);
        $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_STR);
        $query->bindParam(":centroCosto", $item['centroCosto'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listarTareasDeOt($item){
      $query = $this->connect()->prepare("select tarea.*, per.nombre personal_nombre, tip.descripcion tipo_nombre, sis.descripcion sistema_nombre, sub.descripcion sub_nombre 
      from 
      tareas_ot tarea,
      personal_tecnico per,
      tipo_tarea_mantencion tip,
      sistema_maquina sis, 
      sub_sistema_maquina sub
      where tarea.ot_interna = :id and tarea.estado = 'activo' and tarea.personal_tecnico = per.idpersonal_tecnico and 
      tarea.tipo_tarea_mantencion = tip.idtipo_tarea_mantencion and tarea.sistema_maquina = sis.idsistema_maquina and 
      tarea.sub_sistema_maquina = sub.idsub_sistema_maquina");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function eliminarTarea($item){
      $query = $this->connect()->prepare("update tareas_ot set estado = 'inactivo' where idtareas_ot = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listarRepuestosOt($item){
      $query = $this->connect()->prepare("select re.idrepuestos_solicitados, repu.descripcion, re.cantidad
      from repuestos_solicitados re, repuestos repu
      where re.estado = 'activo' and re.repuestos = repu.idrepuestos and re.ot_interna = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function eliminarRepuesto($item){
      $query = $this->connect()->prepare("update repuestos_solicitados set estado = 'inactivo' where idrepuestos_solicitados = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

       
}



?>