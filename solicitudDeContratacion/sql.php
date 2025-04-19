<?php

include_once '../db.php';

class Sql extends DB
{
  function listarHerramientas()
  {
    $query = $this->connect()->prepare("SELECT con.idcontratacion,
                                        emp.descripcion AS empresa,
                                        con.fecha_requerida,
                                        con.division,
                                        car.descripcion as cargo,
                                        con.cantidad_solicitada,
                                        con.estado,
                                        pre.nombre AS pre_aprueba,
                                        apr.nombre AS aprueba,
                                        cdc.descripcion AS centro_de_costo,
                                        con.tipo_contrato
                                        FROM contratacion con
                                        JOIN empresa emp ON emp.idempresa = con.empresa
                                        JOIN cargo car ON car.idcargo = con.cargo
                                        JOIN usuario pre ON pre.idusuario = con.pre_aprueba
                                        JOIN usuario apr ON apr.idusuario = con.aprueba
                                        JOIN centro_de_costo cdc ON cdc.idcentro_de_costo = con.centro_de_costo
                                        where con.estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }
}
