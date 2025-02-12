<?php

include_once '../db.php';

class Sql extends DB{


    function listarHerramientas(){
        $query = $this->connect()->prepare("select * from personal where estado = 'activo'");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function verificar_existencia($item){
        $query = $this->connect()->prepare("select * from personal where estado = 'activo' and 
        rut = :rut");
        $query->bindParam(":rut", $item['rut'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function agregar($item){
        $query = $this->connect()->prepare("insert into personal(nacionalidad,comuna,afp,salud,empresa,centro_de_costo,turnos_laborales,rut,nombre,apellido,estado_civil,fecha_nacimiento,genero,direccion,telefono_empresa,telefono_propio,email,email_empresa,fecha_carga,contiene_foto_perfil,nombre_foto_perfil,estado) values(:nacionalidad, :comuna, :afp, :salud, :empresa, :centro, :turno, :rut, :nombre, :apellido, :estadoCivil, :fechaNacimiento, :genero, :direccion, :telefonoEmpresa, :telefonoPropio, :emailPersonal, :emailEmpresa, now(), :contieneImagen, :nombreImagen, 'activo')");
        $query->bindParam(":rut", $item['rut'], PDO::PARAM_STR);
        $query->bindParam(":fechaNacimiento", $item['fechaNacimiento'], PDO::PARAM_STR);
        $query->bindParam(":genero", $item['genero'], PDO::PARAM_STR);
        $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
        $query->bindParam(":apellido", $item['apellido'], PDO::PARAM_STR);
        $query->bindParam(":nacionalidad", $item['nacionalidad'], PDO::PARAM_STR);
        $query->bindParam(":estadoCivil", $item['estadoCivil'], PDO::PARAM_STR);
        $query->bindParam(":comuna", $item['comuna'], PDO::PARAM_STR);
        $query->bindParam(":direccion", $item['direccion'], PDO::PARAM_STR);
        $query->bindParam(":telefonoEmpresa", $item['telefonoEmpresa'], PDO::PARAM_STR);
        $query->bindParam(":emailEmpresa", $item['emailEmpresa'], PDO::PARAM_STR);
        $query->bindParam(":telefonoPropio", $item['telefonoPropio'], PDO::PARAM_STR);
        $query->bindParam(":emailPersonal", $item['emailPersonal'], PDO::PARAM_STR);
        $query->bindParam(":afp", $item['afp'], PDO::PARAM_STR);
        $query->bindParam(":salud", $item['salud'], PDO::PARAM_STR);
        $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
        $query->bindParam(":centro", $item['centro'], PDO::PARAM_STR);
        $query->bindParam(":turno", $item['turno'], PDO::PARAM_STR);
        $query->bindParam(":contieneImagen", $item['contieneImagen'], PDO::PARAM_STR);
        $query->bindParam(":nombreImagen", $item['nombreImagen'], PDO::PARAM_STR);
        if($query->execute()){
            return "ok";
          }else{
            return "nok";		
          }
    }

    function obtenerDatosParaModificar($item){
      $query = $this->connect()->prepare("select * from personal where estado = 'activo' and 
      idpersonal = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function modificar($item){
      $query = $this->connect()->prepare("update personal set 
      rut = :rut,
      fecha_nacimiento = :fechaNacimiento,
      genero = :genero,
      nombre = :nombre,
      apellido = :apellido,
      nacionalidad = :nacionalidad,
      estado_civil = :estadoCivil,
      comuna = :comuna,
      direccion = :direccion,
      telefono_empresa = :telefonoEmpresa,
      email_empresa = :emailEmpresa,
      telefono_propio = :telefonoPropio,
      email = :emailPersonal,
      afp = :afp,
      salud = :salud,
      empresa = :empresa,
      centro_de_costo = :centro,
      turnos_laborales = :turno
      where idpersonal = :id and estado = 'activo'");      
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        $query->bindParam(":rut", $item['rut'], PDO::PARAM_STR);
        $query->bindParam(":fechaNacimiento", $item['fechaNacimiento'], PDO::PARAM_STR);
        $query->bindParam(":genero", $item['genero'], PDO::PARAM_STR);
        $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
        $query->bindParam(":apellido", $item['apellido'], PDO::PARAM_STR);
        $query->bindParam(":nacionalidad", $item['nacionalidad'], PDO::PARAM_STR);
        $query->bindParam(":estadoCivil", $item['estadoCivil'], PDO::PARAM_STR);
        $query->bindParam(":comuna", $item['comuna'], PDO::PARAM_STR);
        $query->bindParam(":direccion", $item['direccion'], PDO::PARAM_STR);
        $query->bindParam(":telefonoEmpresa", $item['telefonoEmpresa'], PDO::PARAM_STR);
        $query->bindParam(":emailEmpresa", $item['emailEmpresa'], PDO::PARAM_STR);
        $query->bindParam(":telefonoPropio", $item['telefonoPropio'], PDO::PARAM_STR);
        $query->bindParam(":emailPersonal", $item['emailPersonal'], PDO::PARAM_STR);
        $query->bindParam(":afp", $item['afp'], PDO::PARAM_STR);
        $query->bindParam(":salud", $item['salud'], PDO::PARAM_STR);
        $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
        $query->bindParam(":centro", $item['centro'], PDO::PARAM_STR);
        $query->bindParam(":turno", $item['turno'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function actualizarImagen($item){
      $query = $this->connect()->prepare("update personal set 
      nombre_foto_perfil = :nombre_foto_perfil,
      contiene_foto_perfil = 'si'
      where idpersonal = :id and estado = 'activo'");      
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        $query->bindParam(":nombre_foto_perfil", $item['nombre_foto_perfil'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function eliminar($item){
      $query = $this->connect()->prepare("update personal set estado = 'inactivo' where idpersonal = :id and estado = 'activo'");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

       
}



?>