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
      $query = $this->connect()->prepare("select *,
      if(isnull((select contratacion from ficha_contrato where personal = :id and estado = 'contratado' limit 1)),'',
      (select contratacion from ficha_contrato where personal = :id and estado = 'contratado' limit 1)) id_contratacion 
      from personal where estado = 'activo' and idpersonal = :id");
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

    //********************************************

    function cargaAsignacionlaboral($item){
      $query = $this->connect()->prepare("insert into asignacion_laboral(personal,empresa,centro_de_costo,division,estado) values(:idEmpleado,:empresa,:centroDeCosto,:division,'activo')");
      $query->bindParam(":idEmpleado", $item['idEmpleado'], PDO::PARAM_STR);
      $query->bindParam(":division", $item['division'], PDO::PARAM_STR);
      $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
      $query->bindParam(":centroDeCosto", $item['centroDeCosto'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listaAsignacioneslaborales($item){
      $query = $this->connect()->prepare("select 
        asig.idasignacion_laboral,
        asig.division,
        em.descripcion empresa,
        cen.descripcion centro_de_costo
        from asignacion_laboral asig, empresa em, centro_de_costo cen
        where asig.estado = 'activo' and asig.empresa = em.idempresa and 
        asig.centro_de_costo = cen.idcentro_de_costo and asig.personal = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function eliminarAsignacionlaboral($item){
      $query = $this->connect()->prepare("update asignacion_laboral set estado = 'inactivo' where idasignacion_laboral = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function cargarDocumentoLaboral($item){
      $query = $this->connect()->prepare("insert into documentos_laborales(personal,documento,id_documento,fecha_vencimiento,contiene_adjunto,tipo_adjunto,estado) values(:idEmpleado,:documentoLaboral,:idDocumento,:fechaExpiracion,'si',:extension,'activo')");
      $query->bindParam(":idEmpleado", $item['idEmpleado'], PDO::PARAM_STR);
      $query->bindParam(":documentoLaboral", $item['documentoLaboral'], PDO::PARAM_STR);
      $query->bindParam(":idDocumento", $item['idDocumento'], PDO::PARAM_STR);
      $query->bindParam(":fechaExpiracion", $item['fechaExpiracion'], PDO::PARAM_STR);
      $query->bindParam(":extension", $item['extension'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listaDocumentoslaborales($item){
      $query = $this->connect()->prepare("select 
        docu.iddocumentos_laborales,
        doc.descripcion descripcion_documento,
        docu.id_documento id_docu,
        date_format(docu.fecha_vencimiento,'%d/%m/%Y') fecha_vencimiento,
        docu.tipo_adjunto,
        docu.personal id_personal,
        docu.documento id_documento
        from documentos_laborales docu, documento doc
        where docu.estado = 'activo' and docu.documento = doc.iddocumento and 
        docu.personal = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function eliminarDocumentoLaboral($item){
      $query = $this->connect()->prepare("update documentos_laborales set estado = 'inactivo' where iddocumentos_laborales = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function cargarEstudioCursado($item){
      $query = $this->connect()->prepare("insert into estudios(personal,tipo_de_estudio,estado_estudio,contiene_adjunto,tipo_adjunto,estado) values(:idEmpleado,:tipoEstudio,:estadoEstudio,'si',:extension,'activo')");
      $query->bindParam(":idEmpleado", $item['idEmpleado'], PDO::PARAM_STR);
      $query->bindParam(":tipoEstudio", $item['tipoEstudio'], PDO::PARAM_STR);
      $query->bindParam(":estadoEstudio", $item['estadoEstudio'], PDO::PARAM_STR);
      $query->bindParam(":extension", $item['extension'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listaEstudiosCursados($item){
      $query = $this->connect()->prepare("select
            es.idestudios,
            es.personal id_personal,
            es.tipo_de_estudio id_tipo_estudio,
            tip.descripcion descripcion_tipo_estudio,
            es.estado_estudio,
            es.tipo_adjunto
            from estudios es, tipo_de_estudio tip
            where es.estado = 'activo' and es.tipo_de_estudio = tip.idtipo_de_estudio and 
            es.personal = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function eliminarEstudiosCursados($item){
      $query = $this->connect()->prepare("update estudios set estado = 'inactivo' where idestudios = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function cargarTalla($item){
      $query = $this->connect()->prepare("insert into medidas(personal,tipo_epp,nro_talla,estado) values(:idEmpleado,:tipoEpp,:nroTalla,'activo')");
      $query->bindParam(":idEmpleado", $item['idEmpleado'], PDO::PARAM_STR);
      $query->bindParam(":tipoEpp", $item['tipoEpp'], PDO::PARAM_STR);
      $query->bindParam(":nroTalla", $item['nroTalla'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listarTallas($item){
      $query = $this->connect()->prepare("select 
          me.idmedidas,
          tipo.descripcion tipo_epp,
          me.nro_talla
          from medidas me, tipo_epp tipo 
          where me.estado = 'activo' and me.tipo_epp = tipo.idtipo_epp and 
          me.personal = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function eliminarTalla($item){
      $query = $this->connect()->prepare("update medidas set estado = 'inactivo' where idmedidas = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function cargarContactoEmergencia($item){
      $query = $this->connect()->prepare("insert into contacto_emergencia(personal,nombre,telefono,parentezco,estado) values(:idEmpleado,:nombre,:telefono,:parentesco,'activo')");
      $query->bindParam(":idEmpleado", $item['idEmpleado'], PDO::PARAM_STR);
      $query->bindParam(":nombre", $item['nombre'], PDO::PARAM_STR);
      $query->bindParam(":parentesco", $item['parentesco'], PDO::PARAM_STR);
      $query->bindParam(":telefono", $item['telefono'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listarContactosDeEmergencia($item){
      $query = $this->connect()->prepare("select 
          con.idcontacto_emergencia,
          con.nombre,
          con.telefono,
          con.parentezco
          from contacto_emergencia con
          where con.estado = 'activo' and con.personal = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function eliminarContactoDeEmergencia($item){
      $query = $this->connect()->prepare("update contacto_emergencia set estado = 'inactivo' where idcontacto_emergencia = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function cargarAntecedenteMedico($item){
      $query = $this->connect()->prepare("insert into antecedentes(antecedentes_medicos,personal,descripcion,estado) values(:antecedente,:idEmpleado,:descripcion,'activo')");
      $query->bindParam(":idEmpleado", $item['idEmpleado'], PDO::PARAM_STR);
      $query->bindParam(":antecedente", $item['antecedente'], PDO::PARAM_STR);
      $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listaAntecedentes($item){
      $query = $this->connect()->prepare("select 
        ant.idantecedentes,
        ante.descripcion,
        ant.descripcion detalle
        from antecedentes ant, antecedentes_medicos ante
        where ant.estado = 'activo' and 
        ant.antecedentes_medicos = ante.idantecedentes_medicos and 
        ant.personal =:id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function eliminarAntecedentesMedicos($item){
      $query = $this->connect()->prepare("update antecedentes set estado = 'inactivo' where idantecedentes = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listarSolicitudesDeContrato(){
      $query = $this->connect()->prepare("select con.idcontratacion, car.descripcion cargo, cen.descripcion centro, 
      DATE_FORMAT(con.fecha_requerida,'%d/%m/%Y') requerido
      from contratacion con, cargo car, centro_de_costo cen 
      where con.estado = 'aprobado' and con.cargo =car.idcargo and con.centro_de_costo = cen.idcentro_de_costo
      order by con.idcontratacion desc");
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function consultaFichaContrato($item){
      $query = $this->connect()->prepare("select * from ficha_contrato where personal = :idEmpleado and estado = 'contratado'");
      $query->bindParam(":idEmpleado", $item['idEmpleado'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function actualizarFichaContrato($item){
      $query = $this->connect()->prepare("update ficha_contrato set contratacion = :contratacion where idficha_contrato = :idFicha");
      $query->bindParam(":idFicha", $item['idFicha'], PDO::PARAM_STR);
      $query->bindParam(":contratacion", $item['contratacion'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }

    function listarDatosContratacion($item){
      $query = $this->connect()->prepare("select * from contratacion where idcontratacion = :idContratacion");
      $query->bindParam(":idContratacion", $item['idContratacion'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function cargarFichaContrato($item){
      $query = $this->connect()->prepare("insert into ficha_contrato(personal,contratacion,empresa,cargo,turnos_laborales,division,tipo_contrato,fecha_inicio,sueldo_liquido,estado) values(:personal,:contratacion,:empresa,:cargo,:turnos_laborales,:division,:tipo_contrato,curdate(),:sueldo_liquido,'contratado')");
      $query->bindParam(":personal", $item['personal'], PDO::PARAM_STR);
      $query->bindParam(":contratacion", $item['contratacion'], PDO::PARAM_STR);
      $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
      $query->bindParam(":cargo", $item['cargo'], PDO::PARAM_STR);
      $query->bindParam(":turnos_laborales", $item['turnos_laborales'], PDO::PARAM_STR);
      $query->bindParam(":division", $item['division'], PDO::PARAM_STR);
      $query->bindParam(":tipo_contrato", $item['tipo_contrato'], PDO::PARAM_STR);
      $query->bindParam(":sueldo_liquido", $item['sueldo_liquido'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }
       
}



?>