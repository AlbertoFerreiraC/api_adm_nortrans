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
        $query = $this->connect()->prepare("select * from ficha_contrato where estado = 'activo' and 
        idficha_contrato = :idficha_contrato");
        $query->bindParam(":idficha_contrato", $item['idficha_contrato'], PDO::PARAM_STR);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }

    function modificar($item)
    {
        $query = $this->connect()->prepare("UPDATE ficha_contrato SET
            idficha_contrato = :idficha_contrato , 
            contratacion = :contratacion , 
            empresa = :empresa , 
            division = :division , 
            cargo = :cargo , 
            tipo_contrato = :tipo_contrato , 
            turnos_laborales = :turnos_laborales , 
            fecha_inicio = :fecha_inicio , 
            fecha_fin = :fecha_fin, 
            sueldo_liquido = :sueldo_liquido , 
            personal = :personal , 
            tipo_anexo = :tipo_anexo , 
            fecha_anexo = :fecha_anexo
            WHERE
            idficha_contrato = :idficha_contrato AND estado = 'activo';");

        $query->bindParam(":idficha_contrato", $item['idficha_contrato'], PDO::PARAM_INT);
        $query->bindParam(":contratacion", $item['contratacion'], PDO::PARAM_STR);
        $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
        $query->bindParam(":division", $item['division'], PDO::PARAM_STR);
        $query->bindParam(":cargo", $item['cargo'], PDO::PARAM_STR);
        $query->bindParam(":tipo_contrato", $item['tipo_contrato'], PDO::PARAM_STR);
        $query->bindParam(":turnos_laborales", $item['turnos_laborales'], PDO::PARAM_STR);
        $query->bindParam(":fecha_inicio", $item['fecha_inicio'], PDO::PARAM_STR);
        $query->bindParam(":fecha_fin", $item['fecha_fin'], PDO::PARAM_STR);
        $query->bindParam(":personal", $item['personal'], PDO::PARAM_STR);
        $query->bindParam(":tipo_anexo", $item['tipo_anexo'], PDO::PARAM_STR);
        $query->bindParam(":fecha_anexo", $item['fecha_anexo'], PDO::PARAM_STR);
        if ($query->execute()) {
            return "ok";
        } else {
            return "nok";
        }
    }

    function obtenerDatosParaModificar($item)
    {
        $query = $this->connect()->prepare("select * from ficha_contrato where estado = 'activo' and 
        contratacion = :id");
        $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
        if ($query->execute()) {
            return $query->fetchAll();
        } else {
            return null;
        }
    }
}
