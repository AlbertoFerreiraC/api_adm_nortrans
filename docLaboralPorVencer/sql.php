<?php

include_once '../db.php';

class Sql extends DB
{
  function listarHerramientas()
  {
    $query = $this->connect()->prepare("SELECT per.rut AS rut,
                                        CONCAT(per.nombre,' ',per.apellido) AS personal,
                                        doc.descripcion AS tipo_documento,
                                        dl.fecha_vencimiento AS fecha_expiracion
                                        FROM documentos_laborales dl
                                        JOIN personal per ON per.idpersonal = dl.personal_idpersonal
                                        JOIN documento doc ON doc.iddocumento = dl.documento_iddocumento");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }
}
