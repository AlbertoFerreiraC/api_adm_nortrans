<?php

include_once '../db.php';

class Sql extends DB
{

    function cambiarEstadoContrato($item)
    {
        try {
            $query = $this->connect()->prepare("UPDATE contratacion SET 
            estado = :estado
            WHERE idcontratacion = :idcontratacion");

            $query->bindParam(":estado", $item['estado'], PDO::PARAM_STR);
            $query->bindParam(":idcontratacion", $item['idcontratacion'], PDO::PARAM_INT);

            return $query->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    function listarContratado()
    {
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
        tip.descripcion tipo_bus
        FROM contratacion con, usuario usu,cargo car, empresa em,centro_de_costo cen,
        turnos_laborales tur, usuario pre_aprueba, usuario aprueba, tipo_bus tip
        WHERE con.estado = 'contratado' AND con.usuario = usu.idusuario AND 
        con.cargo = car.idcargo AND con.empresa = em.idempresa AND 
        con.centro_de_costo = cen.idcentro_de_costo AND con.turnos_laborales =tur.idturnos_laborales AND con.pre_aprueba = pre_aprueba.idusuario AND 
        con.aprueba = aprueba.idusuario AND con.tipo_bus = tip.idtipo_bus");
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function verificar_existencia($item)
    {
        $query = $this->connect()->prepare("SELECT * FROM contratacion WHERE estado = 'activo' AND 
        idcontratacion = :idcontratacion");
        $query->bindParam(":idcontratacion", $item['idcontratacion'], PDO::PARAM_INT);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function modificar($item)
    {
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

    function obtenerDatosParaModificar($item)
    {
        $query = $this->connect()->prepare("select * from ficha_contrato where estado = 'contratado' and 
        contratacion = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }
}
