<?php

include_once '../db.php';

class Sql extends DB
{
  function listarHerramientas()
  {
      $query = $this->connect()->prepare("SELECT per.rut AS rut, 
                                          CONCAT(per.nombre,' ',per.apellido) AS personal,
                                          dl.fecha_vencimiento AS fecha_expiracion,
                                          doc.descripcion AS tipo_documento,
                                          con.centro_de_costo 
                                          FROM documentos_laborales dl
                                          JOIN personal per ON per.idpersonal = dl.personal
                                          JOIN documento doc ON doc.iddocumento = dl.documento
                                          JOIN ficha_contrato fc ON fc.personal = per.idpersonal
                                          JOIN contratacion con ON con.idcontratacion = fc.contratacion
                                          WHERE per.estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }
}
