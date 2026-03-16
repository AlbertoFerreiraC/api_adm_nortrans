<?php

include_once '../db.php';

$db = new DB();
$conn = $db->connect();

$id = $_GET['id'];

/* ======================
   CABECERA OT
====================== */

$queryCab = $conn->prepare("

SELECT

ot.idot_interna,
u.nombre AS usuario,
m.descripcion AS maquina,
cc.descripcion AS centro_de_costo,
ot.fecha,
ot.km_actual,
ot.estado

FROM ot_interna ot

LEFT JOIN usuario u
ON u.idusuario = ot.usuario

LEFT JOIN maquina m
ON m.idmaquina = ot.maquina

LEFT JOIN centro_de_costo cc
ON cc.idcentro_de_costo = ot.centro_de_costo

WHERE ot.idot_interna = :id
");

$queryCab->bindParam(":id", $id);
$queryCab->execute();

$cabecera = $queryCab->fetch(PDO::FETCH_ASSOC);


/* ======================
   TAREAS
====================== */

$queryTar = $conn->prepare("

SELECT

t.fecha,

pt.nombre AS tecnico,

tt.descripcion AS tipo_tarea,

sm.descripcion AS sistema,

ssm.descripcion AS sub_sistema,

t.observacion,
t.estado

FROM tareas_ot t

LEFT JOIN personal_tecnico pt
ON pt.idpersonal_tecnico = t.personal_tecnico

LEFT JOIN tipo_tarea_mantencion tt
ON tt.idtipo_tarea_mantencion = t.tipo_tarea_mantencion

LEFT JOIN sistema_maquina sm
ON sm.idsistema_maquina = t.sistema_maquina

LEFT JOIN sub_sistema_maquina ssm
ON ssm.idsub_sistema_maquina = t.sub_sistema_maquina

WHERE t.ot_interna = :id
");

$queryTar->bindParam(":id", $id);
$queryTar->execute();

$tareas = $queryTar->fetchAll(PDO::FETCH_ASSOC);


/* ======================
   CARGAR PLANTILLA
====================== */

include 'plantillaImpresionPreventiva.php';
