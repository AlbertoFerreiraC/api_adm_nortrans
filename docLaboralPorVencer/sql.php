<?php

include_once '../db.php';

class Sql extends DB
{
  function listarHerramientas()
  {
    $query = $this->connect()->prepare("SELECT per.rut AS rut, CONCAT(per.nombre,' ',per.apellido) AS personal,
                                        doc.descripcion AS tipo_documento,
                                        dl.fecha_vencimiento AS fecha_expiracion,
                                        con.centro_de_costo
                                        FROM documentos_laborales dl
                                        JOIN personal per ON per.idpersonal = dl.personal_idpersonal
                                        JOIN documento doc ON doc.iddocumento = dl.id_documento
                                        JOIN ficha_contrato fc ON fc.personal = per.idpersonal
                                        JOIN contratacion con ON con.idcontratacion = fc.contratacion
                                        WHERE fc.estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }
}
