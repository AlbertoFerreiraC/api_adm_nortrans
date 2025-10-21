<?php

include_once '../db.php';

class Sql extends DB{

  function listarSolicitudesAprobadas(){
    $query = $this->connect()->prepare("select idsms,concat('Nro: ',idsms,' - Carga: ',date_format(fecha_carga,'%d/%m/%Y')) descripcion from sms where estado = 'aprobado' order by fecha_carga desc");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregarCabecera($item){
    $query = $this->connect()->prepare("insert into generar_oc(fecha_creacion,empresa,proveedor,doc_proveedor,plazo_oc,pago_oc,pre_aprueba,pre_aprueba2,tipo_oc,num_doc_proveedor,plazo_entrega,tipo_documento_compra,sub_total,descuento_total,exento_total,neto_total,iva_total,retencion_total,total_general,referencia_adjunto,tipo_adjunto,estado) values(now(),:empresa,:proveedor,:tipoDocumentoProveedor,:plazo,:formaPago,:preAprueba,:preAprueba2,:tipoOc,:nroDocumentoProveedor,:plazoEntrega,:tipoDocumentoCompra,:subTotal,:descuento,:exento,:neto,:iva,:retencion,:total,:codigoAjunto,:extension,'activo')");
    $query->bindParam(":codigoAjunto", $item['codigoAjunto'], PDO::PARAM_STR);
    $query->bindParam(":extension", $item['extension'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":proveedor", $item['proveedor'], PDO::PARAM_STR);
    $query->bindParam(":tipoOc", $item['tipoOc'], PDO::PARAM_STR);
    $query->bindParam(":tipoDocumentoProveedor", $item['tipoDocumentoProveedor'], PDO::PARAM_STR);
    $query->bindParam(":nroDocumentoProveedor", $item['nroDocumentoProveedor'], PDO::PARAM_STR);
    $query->bindParam(":plazo", $item['plazo'], PDO::PARAM_STR);
    $query->bindParam(":formaPago", $item['formaPago'], PDO::PARAM_STR);
    $query->bindParam(":plazoEntrega", $item['plazoEntrega'], PDO::PARAM_STR);
    $query->bindParam(":tipoDocumentoCompra", $item['tipoDocumentoCompra'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba", $item['preAprueba'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba2", $item['preAprueba2'], PDO::PARAM_STR);
    $query->bindParam(":subTotal", $item['subTotal'], PDO::PARAM_STR);
    $query->bindParam(":descuento", $item['descuento'], PDO::PARAM_STR);
    $query->bindParam(":exento", $item['exento'], PDO::PARAM_STR);
    $query->bindParam(":neto", $item['neto'], PDO::PARAM_STR);
    $query->bindParam(":iva", $item['iva'], PDO::PARAM_STR);
    $query->bindParam(":retencion", $item['retencion'], PDO::PARAM_STR);
    $query->bindParam(":total", $item['total'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function modificarCabeceraCompleto($item){
    $query = $this->connect()->prepare("update generar_oc 
        set 
            empresa = :empresa,
            proveedor = :proveedor,
            doc_proveedor = :tipoDocumentoProveedor,
            plazo_oc = :plazo,
            pago_oc = :formaPago,
            pre_aprueba = :preAprueba,
            pre_aprueba2 = :preAprueba2,
            tipo_oc = :tipoOc,
            num_doc_proveedor = :nroDocumentoProveedor,
            plazo_entrega = :plazoEntrega,
            tipo_documento_compra = :tipoDocumentoCompra,
            sub_total = :subTotal,
            descuento_total = :descuento,
            exento_total = :exento,
            neto_total = :neto,
            iva_total = :iva,
            retencion_total = :retencion,
            total_general = :total,
            referencia_adjunto = :codigoAjunto,
            tipo_adjunto = :extension
        where idgenerar_oc = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    $query->bindParam(":codigoAjunto", $item['codigoAjunto'], PDO::PARAM_STR);
    $query->bindParam(":extension", $item['extension'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":proveedor", $item['proveedor'], PDO::PARAM_STR);
    $query->bindParam(":tipoOc", $item['tipoOc'], PDO::PARAM_STR);
    $query->bindParam(":tipoDocumentoProveedor", $item['tipoDocumentoProveedor'], PDO::PARAM_STR);
    $query->bindParam(":nroDocumentoProveedor", $item['nroDocumentoProveedor'], PDO::PARAM_STR);
    $query->bindParam(":plazo", $item['plazo'], PDO::PARAM_STR);
    $query->bindParam(":formaPago", $item['formaPago'], PDO::PARAM_STR);
    $query->bindParam(":plazoEntrega", $item['plazoEntrega'], PDO::PARAM_STR);
    $query->bindParam(":tipoDocumentoCompra", $item['tipoDocumentoCompra'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba", $item['preAprueba'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba2", $item['preAprueba2'], PDO::PARAM_STR);
    $query->bindParam(":subTotal", $item['subTotal'], PDO::PARAM_STR);
    $query->bindParam(":descuento", $item['descuento'], PDO::PARAM_STR);
    $query->bindParam(":exento", $item['exento'], PDO::PARAM_STR);
    $query->bindParam(":neto", $item['neto'], PDO::PARAM_STR);
    $query->bindParam(":iva", $item['iva'], PDO::PARAM_STR);
    $query->bindParam(":retencion", $item['retencion'], PDO::PARAM_STR);
    $query->bindParam(":total", $item['total'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function modificarCabeceraSinImagen($item){
    $query = $this->connect()->prepare("update generar_oc 
        set 
            empresa = :empresa,
            proveedor = :proveedor,
            doc_proveedor = :tipoDocumentoProveedor,
            plazo_oc = :plazo,
            pago_oc = :formaPago,
            pre_aprueba = :preAprueba,
            pre_aprueba2 = :preAprueba2,
            tipo_oc = :tipoOc,
            num_doc_proveedor = :nroDocumentoProveedor,
            plazo_entrega = :plazoEntrega,
            tipo_documento_compra = :tipoDocumentoCompra,
            sub_total = :subTotal,
            descuento_total = :descuento,
            exento_total = :exento,
            neto_total = :neto,
            iva_total = :iva,
            retencion_total = :retencion,
            total_general = :total
        where idgenerar_oc = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    $query->bindParam(":empresa", $item['empresa'], PDO::PARAM_STR);
    $query->bindParam(":proveedor", $item['proveedor'], PDO::PARAM_STR);
    $query->bindParam(":tipoOc", $item['tipoOc'], PDO::PARAM_STR);
    $query->bindParam(":tipoDocumentoProveedor", $item['tipoDocumentoProveedor'], PDO::PARAM_STR);
    $query->bindParam(":nroDocumentoProveedor", $item['nroDocumentoProveedor'], PDO::PARAM_STR);
    $query->bindParam(":plazo", $item['plazo'], PDO::PARAM_STR);
    $query->bindParam(":formaPago", $item['formaPago'], PDO::PARAM_STR);
    $query->bindParam(":plazoEntrega", $item['plazoEntrega'], PDO::PARAM_STR);
    $query->bindParam(":tipoDocumentoCompra", $item['tipoDocumentoCompra'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba", $item['preAprueba'], PDO::PARAM_STR);
    $query->bindParam(":preAprueba2", $item['preAprueba2'], PDO::PARAM_STR);
    $query->bindParam(":subTotal", $item['subTotal'], PDO::PARAM_STR);
    $query->bindParam(":descuento", $item['descuento'], PDO::PARAM_STR);
    $query->bindParam(":exento", $item['exento'], PDO::PARAM_STR);
    $query->bindParam(":neto", $item['neto'], PDO::PARAM_STR);
    $query->bindParam(":iva", $item['iva'], PDO::PARAM_STR);
    $query->bindParam(":retencion", $item['retencion'], PDO::PARAM_STR);
    $query->bindParam(":total", $item['total'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function verificarCabecera($item){
    $query = $this->connect()->prepare("select * from generar_oc where estado = 'activo' and 
        referencia_adjunto = :codigoAjunto");
    $query->bindParam(":codigoAjunto", $item['codigoAjunto'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function agregarDetalle($item){
    $query = $this->connect()->prepare("insert into detalle_oc(generar_oc,sms,detalle_sms,nro_item,aplicacion,tipo_producto,glosa,unidad_de_medida,cantidad,costo_unitario,tipo_descuento,valor_descuento,sub_total,estado) values(:nroOc,:nroSms,:nroSmsDetalle,:itemSms,:aplicacion,:tipoProducto,:glosa,:unidadDeMedida,:cantidad,:costoUnitario,:tipoDescuento,:valorDescuento,:subTotal,:estado)");
    $query->bindParam(":nroOc", $item['nroOc'], PDO::PARAM_STR);
    $query->bindParam(":nroSms", $item['nroSms'], PDO::PARAM_STR);
    $query->bindParam(":nroSmsDetalle", $item['nroSmsDetalle'], PDO::PARAM_STR);
    $query->bindParam(":itemSms", $item['itemSms'], PDO::PARAM_STR);
    $query->bindParam(":aplicacion", $item['aplicacion'], PDO::PARAM_STR);
    $query->bindParam(":tipoProducto", $item['tipoProducto'], PDO::PARAM_STR);
    $query->bindParam(":glosa", $item['glosa'], PDO::PARAM_STR);
    $query->bindParam(":unidadDeMedida", $item['unidadDeMedida'], PDO::PARAM_STR);
    $query->bindParam(":cantidad", $item['cantidad'], PDO::PARAM_STR);
    $query->bindParam(":costoUnitario", $item['costoUnitario'], PDO::PARAM_STR);
    $query->bindParam(":tipoDescuento", $item['tipoDescuento'], PDO::PARAM_STR);
    $query->bindParam(":valorDescuento", $item['valorDescuento'], PDO::PARAM_STR);
    $query->bindParam(":subTotal", $item['subTotal'], PDO::PARAM_STR);
    $query->bindParam(":estado", $item['estado'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }


  //**********************************************
  function listarHerramientas(){
    $query = $this->connect()->prepare("select * from generar_oc where estado = 'activo'");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function verificar_existencia($item)
  {
    $query = $this->connect()->prepare("select * from clase_bus where estado = 'activo' and 
        descripcion = :descripcion");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }  

  function obtenerDatosParaModificar($item)
  {
    $query = $this->connect()->prepare("select * from generar_oc where estado = 'activo' and 
      idgenerar_oc = :id");
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function modificar($item)
  {
    $query = $this->connect()->prepare("update clase_bus set descripcion = :descripcion where idclase_bus = :id and estado = 'activo'");
    $query->bindParam(":descripcion", $item['descripcion'], PDO::PARAM_STR);
    $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function eliminarDetalle($item){
    $query = $this->connect()->prepare("delete from detalle_oc where generar_oc = :idOc");
    $query->bindParam(":idOc", $item['idOc'], PDO::PARAM_STR);
    if ($query->execute()) {
      return "ok";
    } else {
      return "nok";
    }
  }

  function aprobar($item)
  {
    try {
      $query = $this->connect()->prepare("
            UPDATE generar_oc 
            SET estado = 'aprobado',
                observacion_aprueba = :comentario,
                fecha_aprobacion = NOW()
            WHERE idgenerar_oc = :id AND estado = 'activo'
        ");
      $query->bindParam(":id", $item['id'], PDO::PARAM_INT);
      $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);

      if ($query->execute()) {
        return "ok";
      } else {
        return "nok";
      }
    } catch (PDOException $e) {
      return "nok";
    }
  }

  function rechazar($item)
  {
    try {
      $query = $this->connect()->prepare("
            UPDATE generar_oc 
            SET estado = 'rechazado',
                observacion_aprueba = :comentario,
                fecha_aprobacion = NOW()
            WHERE idgenerar_oc = :id
              AND estado = 'activo'
        ");
      $query->bindParam(":id", $item['id'], PDO::PARAM_INT);
      $query->bindParam(":comentario", $item['comentario'], PDO::PARAM_STR);

      if ($query->execute()) {
        return $query->rowCount() > 0 ? "ok" : "nok";
      } else {
        return "nok";
      }
    } catch (PDOException $e) {
      return "nok";
    }
  }

  function listarOCActivas(){
    $query = $this->connect()->prepare("select 
      oc.idgenerar_oc,
      date_format(oc.fecha_creacion,'%d/%m/%Y %H:%i') fecha_creacion,
      em.descripcion empresa,
      pro.descripcion proveedor,
      oc.tipo_oc,
      oc.plazo_entrega,
      oc.total_general
      from generar_oc oc, empresa em, proveedor pro 
      where oc.estado = 'activo' and oc.empresa = em.idempresa and oc.proveedor = pro.idproveedor");
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

  function listarDetalleOCParaEditar($item){
    $query = $this->connect()->prepare("select * from detalle_oc where generar_oc = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
    if ($query->execute()) {
      return $query->fetchAll();
    } else {
      return null;
    }
  }

}
