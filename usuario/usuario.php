<?php

include_once '../db.php';

class Usuario extends DB{


    function listar(){
        $query = $this->connect()->prepare("select usu.*,ro.descripcionRol from usuario usu,roles ro where usu.estado = 'activo' and usu.roles = ro.idroles");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }


    function verificar_existencia_cedula($item){
        $query = $this->connect()->prepare("select * from usuario where estado = 'activo' and 
        cedula = :cedula");
        $query->bindParam(":cedula", $item['cedula'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function verificar_existencia_nic($item){
      $query = $this->connect()->prepare("select * from usuario where estado = 'activo' and 
      nic = :nic");
      $query->bindParam(":nic", $item['nic'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
  }

    function agregar($item){
        $query = $this->connect()->prepare("insert into usuario(
            roles, 
            cedula, 
            nombre, 
            telefono, 
            correo, 
            nic, 
            pass, 
            estado, 
            fecha_creacion,
            aprueba_sol_contratacion,
            pre_aprueba_sol_contratacion,
            aprueba_asig_fondo_fijo,
            pre_aprueba_asig_fondo_fijo,
            aprueba_generar_oc,
            pre_aprueba_generar_oc,
            aprueba_generar_sms,
            pre_aprueba_generar_sms
        ) values(
            :rol,
            :cedula,
            :nombre,
            :telefono,
            :correo,
            :nic,
            'MTIzNDU=',
            'activo',
            now(),
            :solicitudContratacionAprueba,
            :solicitudContratacionPreAprueba,
            :fondoFijoAprueba,
            :fondoFijoPreAprueba,
            :generarOCAprueba,
            :generarOCPreAprueba,
            :generarSMSAprueba,
            :generarSMSPreAprueba
        )");
        
        $query->bindParam(":rol", $item['rol'], PDO::PARAM_STR);
        $query->bindParam(":cedula", $item['cedula'], PDO::PARAM_STR);
        $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
        $query->bindParam(":nic", $item['nic'], PDO::PARAM_STR);
        $query->bindParam(":telefono", $item['telefono'], PDO::PARAM_STR);
        $query->bindParam(":correo", $item['correo'], PDO::PARAM_STR);
        
        // Nuevos parámetros de permisos por módulo
        $query->bindParam(":solicitudContratacionAprueba", $item['solicitudContratacionAprueba'], PDO::PARAM_STR);
        $query->bindParam(":solicitudContratacionPreAprueba", $item['solicitudContratacionPreAprueba'], PDO::PARAM_STR);
        $query->bindParam(":fondoFijoAprueba", $item['fondoFijoAprueba'], PDO::PARAM_STR);
        $query->bindParam(":fondoFijoPreAprueba", $item['fondoFijoPreAprueba'], PDO::PARAM_STR);
        $query->bindParam(":generarOCAprueba", $item['generarOCAprueba'], PDO::PARAM_STR);
        $query->bindParam(":generarOCPreAprueba", $item['generarOCPreAprueba'], PDO::PARAM_STR);
        $query->bindParam(":generarSMSAprueba", $item['generarSMSAprueba'], PDO::PARAM_STR);
        $query->bindParam(":generarSMSPreAprueba", $item['generarSMSPreAprueba'], PDO::PARAM_STR);

        if($query->execute()){
            return "ok";
        }else{
            return "nok";		
        }
    }

    function obtenerDatosParaModificar($item){
      $query = $this->connect()->prepare("select usu.*,ro.descripcionRol,ro.idroles from usuario usu,roles ro where usu.estado = 'activo' and usu.roles = ro.idroles and usu.idusuario = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function modificar($item){
        $query = $this->connect()->prepare("update usuario set 
            roles = :rol,   
            cedula = :cedula, 
            nombre = :nombre,
            nic = :nic,
            telefono = :telefono,
            correo = :correo,
            fecha_modificacion = now(),
            aprueba_sol_contratacion = :solicitudContratacionAprueba,
            pre_aprueba_sol_contratacion = :solicitudContratacionPreAprueba,
            aprueba_asig_fondo_fijo = :fondoFijoAprueba,
            pre_aprueba_asig_fondo_fijo = :fondoFijoPreAprueba,
            aprueba_generar_oc = :generarOCAprueba,
            pre_aprueba_generar_oc = :generarOCPreAprueba,
            aprueba_generar_sms = :generarSMSAprueba,
            pre_aprueba_generar_sms = :generarSMSPreAprueba
            where idusuario = :id and estado = 'activo'");
        
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        $query->bindParam(":rol", $item['rol'], PDO::PARAM_STR);
        $query->bindParam(":cedula", $item['cedula'], PDO::PARAM_STR);
        $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
        $query->bindParam(":nic", $item['nic'], PDO::PARAM_STR);
        $query->bindParam(":telefono", $item['telefono'], PDO::PARAM_STR);
        $query->bindParam(":correo", $item['correo'], PDO::PARAM_STR);
        
        // Nuevos parámetros de permisos por módulo
        $query->bindParam(":solicitudContratacionAprueba", $item['solicitudContratacionAprueba'], PDO::PARAM_STR);
        $query->bindParam(":solicitudContratacionPreAprueba", $item['solicitudContratacionPreAprueba'], PDO::PARAM_STR);
        $query->bindParam(":fondoFijoAprueba", $item['fondoFijoAprueba'], PDO::PARAM_STR);
        $query->bindParam(":fondoFijoPreAprueba", $item['fondoFijoPreAprueba'], PDO::PARAM_STR);
        $query->bindParam(":generarOCAprueba", $item['generarOCAprueba'], PDO::PARAM_STR);
        $query->bindParam(":generarOCPreAprueba", $item['generarOCPreAprueba'], PDO::PARAM_STR);
        $query->bindParam(":generarSMSAprueba", $item['generarSMSAprueba'], PDO::PARAM_STR);
        $query->bindParam(":generarSMSPreAprueba", $item['generarSMSPreAprueba'], PDO::PARAM_STR);
        
        if($query->execute()){
            return "ok";
        }else{
            return "nok";		
        }
    }

    function eliminar($item){
      $query = $this->connect()->prepare("update usuario set estado = 'inactivo' where idusuario = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function resetearPass($item){
      $query = $this->connect()->prepare("update usuario set pass = 'MTIzNDU=' where idusuario = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

       
}



?>