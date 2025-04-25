<?php

include_once '../db.php';

class Sql extends DB
{

    function cambiarEstadoContrato($item){
        $query = $this->connect()->prepare("update ficha_contrato set estado = 'anulado' where idficha_contrato = :idcontratacion");
            $query->bindParam(":idcontratacion", $item['idcontratacion'], PDO::PARAM_STR);
            if ($query->execute()) {
            return "ok";
            } else {
            return "nok";
            }
    }

    function listarContratado(){
        $query = $this->connect()->prepare("SELECT con.idcontratacion,
        usu.nombre realizado_por, 
        car.descripcion cargo,
        em.descripcion empresa,
        cen.descripcion centro_de_costo,
        tur.descripcion turnos_laborales,
        pre_aprueba.nombre pre_aprueba,
        aprueba.nombre aprueba,
        con.division,
        con.cantidad_solicitada,
        con.licencia_de_conducir,
        if(ISNULL(con.fecha_requerida),'',DATE_FORMAT(con.fecha_requerida,'%d/%m/%y')) fecha_requerida,
        con.fecha_termino,
        con.remuneracion,
        con.comentario_general,
        con.motivo,
        con.estado,
        con.tipo_contrato,
        con.entrevista_psicolaboral,
        con.entrevista_tecnica,
        con.entrevista_conduccion,
        if(ISNULL(con.fecha_pre_aperobacion),'',DATE_FORMAT(con.fecha_pre_aperobacion,'%d/%m/%y')) fecha_pre_aperobacion,
        if(ISNULL(con.observacion_aprobacion),'',con.observacion_aprobacion) observacion_aprobacion,
        con.fecha_inicio_laboral,
        con.cantidad_contratada,
        tip.descripcion tipo_bus,
        fi.idficha_contrato
        FROM contratacion con, usuario usu,cargo car, empresa em,centro_de_costo cen,
        turnos_laborales tur, usuario pre_aprueba, usuario aprueba, tipo_bus tip, ficha_contrato fi
        WHERE fi.contratacion = con.idcontratacion and  fi.estado = 'contratado' AND con.usuario = usu.idusuario AND 
        con.cargo = car.idcargo AND con.empresa = em.idempresa AND 
        con.centro_de_costo = cen.idcentro_de_costo AND con.turnos_laborales =tur.idturnos_laborales AND con.pre_aprueba = pre_aprueba.idusuario AND 
        con.aprueba = aprueba.idusuario AND con.tipo_bus = tip.idtipo_bus");
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function verificar_existencia($item){
        $query = $this->connect()->prepare("SELECT * FROM contratacion WHERE estado = 'activo' AND 
        idcontratacion = :idcontratacion");
        $query->bindParam(":idcontratacion", $item['idcontratacion'], PDO::PARAM_INT);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function modificar($item){
        $query = $this->connect()->prepare("UPDATE contratacion SET
        cargo = :cargo, 
        empresa = :empresa, 
        division = :division, 
        centro_de_costo = :centro_de_costo, 
        turnos_laborales = :turnos_laborales, 
        tipo_bus = :tipo_bus, 
        pre_aprueba = :pre_aprueba, 
        aprueba = :aprueba, 
        motivo = :motivo, 
        cantidad_solicitada = :cantidad_solicitada, 
        licencia_de_conducir = :licencia_de_conducir, 
        tipo_contrato = :tipo_contrato, 
        fecha_requerida = :fecha_requerida, 
        fecha_termino = :fecha_termino, 
        remuneracion = :remuneracion, 
        comentario_general = :comentario_general,
        entrevista_psicolaboral = :entrevista_psicolaboral,
        entrevista_tecnica = :entrevista_tecnica,
        entrevista_conduccion = :entrevista_conduccion,
        observacion_pre_aprobacion = :observacion_pre_aprobacion,
        fecha_pre_aperobacion = :fecha_pre_aperobacion
        WHERE
        idcontratacion = :idcontratacion AND estado = 'contratado';");

        $query->bindParam(":idcontratacion", $item['idcontratacion'], PDO::PARAM_INT);
        $query->bindParam(":cargo", $item['cargo'], PDO::PARAM_STR);
        $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
        $query->bindParam(":division", $item['division'], PDO::PARAM_STR);
        $query->bindParam(":centro_de_costo", $item['centro_de_costo'], PDO::PARAM_STR);
        $query->bindParam(":turnos_laborales", $item['turnos_laborales'], PDO::PARAM_STR);
        $query->bindParam(":tipo_bus", $item['tipo_bus'], PDO::PARAM_STR);
        $query->bindParam(":pre_aprueba", $item['pre_aprueba'], PDO::PARAM_STR);
        $query->bindParam(":aprueba", $item['aprueba'], PDO::PARAM_STR);
        $query->bindParam(":motivo", $item['motivo'], PDO::PARAM_STR);
        $query->bindParam(":cantidad_solicitada", $item['cantidad_solicitada'], PDO::PARAM_STR);
        $query->bindParam(":licencia_de_conducir", $item['licencia_de_conducir'], PDO::PARAM_STR);
        $query->bindParam(":tipo_contrato", $item['tipo_contrato'], PDO::PARAM_STR);
        $query->bindParam(":fecha_requerida", $item['fecha_requerida'], PDO::PARAM_STR);
        $query->bindParam(":fecha_termino", $item['fecha_termino'], PDO::PARAM_STR);
        $query->bindParam(":remuneracion", $item['remuneracion'], PDO::PARAM_STR);
        $query->bindParam(":comentario_general", $item['comentario_general'], PDO::PARAM_STR);
        $query->bindParam(":entrevista_psicolaboral", $item['entrevista_psicolaboral'], PDO::PARAM_STR);
        $query->bindParam(":entrevista_tecnica", $item['entrevista_tecnica'], PDO::PARAM_STR);
        $query->bindParam(":entrevista_conduccion", $item['entrevista_conduccion'], PDO::PARAM_STR);
        $query->bindParam(":observacion_pre_aprobacion", $item['observacion_pre_aprobacion'], PDO::PARAM_STR);
        $query->bindParam(":fecha_pre_aperobacion", $item['fecha_pre_aperobacion'], PDO::PARAM_STR);

        if ($query->execute()) {
            return "ok";
        } else {
            return "nok";
        }
    }

    function obtenerDatosParaModificar($item){
        $query = $this->connect()->prepare("select 
            per.rut,
            concat(per.nombre,' ',per.apellido) nombre_completo,
            per.telefono_propio,
            fic.idficha_contrato,
            fic.contratacion,
            em.descripcion descripcion_empresa,
            em.idempresa id_empresa,
            fic.division,
            car.descripcion cargo,
            fic.tipo_contrato,
            tur.descripcion turno,
            fic.fecha_inicio,
            fic.sueldo_liquido,
            if(isnull(fic.documento_contrato),'vacio',fic.documento_contrato) documento_contrato,
            fic.tipo_documento_contrato
            from ficha_contrato fic, personal per,empresa em, cargo car, turnos_laborales tur
            where fic.idficha_contrato = :id and fic.personal = per.idpersonal and fic.cargo = car.idcargo and 
            fic.turnos_laborales = tur.idturnos_laborales and fic.empresa = em.idempresa");

        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    //-----------------------------------------------------------------
    function actualizarDatosFichaContrato($item){
        $query = $this->connect()->prepare("update ficha_contrato set empresa = :empresa, fecha_inicio = :fechaInicio, sueldo_liquido = :sueldo where idficha_contrato = :idFicha");
        $query->bindParam(":idFicha", $item['idFicha'], PDO::PARAM_INT);
        $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
        $query->bindParam(":fechaInicio", $item['fechaInicio'], PDO::PARAM_STR);
        $query->bindParam(":sueldo", $item['sueldo'], PDO::PARAM_STR);

        if ($query->execute()) {
            return "ok";
        } else {
            return "nok";
        }
    }

    function actualizarDocumentosContrato($item){
        $query = $this->connect()->prepare("update ficha_contrato set documento_contrato = 'si', tipo_documento_contrato = :extension where idficha_contrato = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_INT);
        $query->bindParam(":extension", $item['extension'], PDO::PARAM_STR);
        if ($query->execute()) {
            return "ok";
        } else {
            return "nok";
        }
    }

    function cargarRequisito($item){
        $query = $this->connect()->prepare("insert into detalle_ficha_contrato(ficha_contrato,requisito_de_seleccion,observacion,contine_adjunto,tipo_adjunto,estado) values(:ficha,:requisito,:comentario,'si',:extension,'activo')");
        $query->bindParam(":ficha", $item['ficha'], PDO::PARAM_INT);
        $query->bindParam(":requisito", $item['requisito'], PDO::PARAM_STR);
        $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);
        $query->bindParam(":extension", $item['extension'], PDO::PARAM_STR);
        if ($query->execute()) {
            return "ok";
        } else {
            return "nok";
        }
    }

    function listarRequisitosDeFicha($item){
        $query = $this->connect()->prepare("select 
            det.iddetalle_ficha_contrato id_detalle,
            det.ficha_contrato id_ficha,
            det.requisito_de_seleccion id_requisito,
            red.descripcion requisito,
            det.observacion,
            det.tipo_adjunto
            from detalle_ficha_contrato det, requisito_de_seleccion red
            where det.estado = 'activo' and det.requisito_de_seleccion = red.idrequisito_de_seleccion and 
            det.ficha_contrato = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function eliminarRequisito($item){
        $query = $this->connect()->prepare("update detalle_ficha_contrato set estado = 'anulado' where iddetalle_ficha_contrato = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_INT);
        if ($query->execute()) {
            return "ok";
        } else {
            return "nok";
        }
    }

    function cargarAnexo($item){
        $query = $this->connect()->prepare("insert into anexos(ficha_contrato,tipo_anexo,fecha,observacion,contine_adjunto,tipo_adjunto,estado) values(:ficha,:anexo,:fecha,:comentario,'si',:extension,'activo')");
        $query->bindParam(":ficha", $item['ficha'], PDO::PARAM_STR);
        $query->bindParam(":anexo", $item['anexo'], PDO::PARAM_STR);
        $query->bindParam(":fecha", $item['fecha'], PDO::PARAM_STR);
        $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);
        $query->bindParam(":extension", $item['extension'], PDO::PARAM_STR);
        if ($query->execute()) {
            return "ok";
        } else {
            return "nok";
        }
    }

    function listarAnexosDeFicha($item){
        $query = $this->connect()->prepare("select
            ane.idanexos id_detalle,
            ane.tipo_anexo idtipo_anexo,
            ane.ficha_contrato id_ficha,
            tip.descripcion descripcion_anexo,
            ane.fecha,
            ane.observacion,
            ane.tipo_adjunto
            from anexos ane, tipo_anexo tip
            where ane.estado = 'activo' and ane.tipo_anexo = tip.idtipo_anexo and 
            ane.ficha_contrato = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function eliminarAnexo($item){
        $query = $this->connect()->prepare("update anexos set estado = 'anulado' where idanexos = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_INT);
        if ($query->execute()) {
            return "ok";
        } else {
            return "nok";
        }
    }
}
