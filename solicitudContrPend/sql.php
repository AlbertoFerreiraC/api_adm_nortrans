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
                                        apr.nombre AS aprueba
                                        FROM contratacion con
                                        JOIN empresa emp ON emp.idempresa = con.empresa
                                        JOIN cargo car ON car.idcargo = con.cargo
                                        JOIN usuario pre ON pre.idusuario = con.pre_aprueba
                                        JOIN usuario apr ON apr.idusuario = con.aprueba
                                        WHERE con.estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }
}
