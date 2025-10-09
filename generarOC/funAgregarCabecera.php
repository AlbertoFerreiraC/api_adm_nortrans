<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    if ( empty($_FILES['documento']['tmp_name']) != 1) {
        $tipo = $_FILES['documento']['type'];
        $extension = "";
        if($tipo == "image/jpeg"){ $extension = ".jpeg"; }
        if($tipo == "image/png"){ $extension = ".png"; }
        if($tipo == "text/plain"){ $extension = ".txt"; }        
        if($tipo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){ $extension = ".xlsx"; }
        if($tipo == "application/vnd.ms-excel"){ $extension = ".xls"; }
        if($tipo == "text/csv"){ $extension = ".csv"; }
        if($tipo == "application/pdf"){ $extension = ".pdf"; }
        if($tipo == "application/msword"){ $extension = ".doc"; }
        if($tipo == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"){ $extension = ".docx"; }
        if($extension != ""){
            $ahora = new DateTime("now", new DateTimeZone('America/Asuncion'));
            $codigoAdjunto =  $ahora->format("YmdHis");

            $archivo =  file_get_contents($_FILES['documento']['tmp_name']);
            $filename =  $codigoAdjunto."_documentoOrdenDeCompra".$extension; 
            $bytes = file_put_contents('../../adm-nortrans/vistas/img/general/'.$filename, $archivo);

            $item = array(
                'codigoAjunto' =>  $codigoAdjunto,
                'extension' => $extension,
                'empresa' => $_POST['empresa'],
                'proveedor' => $_POST['proveedor'],
                'tipoOc' => $_POST['tipoOc'],
                'tipoDocumentoProveedor' => $_POST['tipoDocumentoProveedor'],
                'nroDocumentoProveedor' => $_POST['nroDocumentoProveedor'],
                'plazo' => $_POST['plazo'],
                'formaPago' => $_POST['formaPago'],
                'plazoEntrega' => $_POST['plazoEntrega'],
                'tipoDocumentoCompra' => $_POST['tipoDocumentoCompra'],
                'preAprueba' => $_POST['preAprueba'],
                'preAprueba2' => $_POST['preAprueba2'],
                'subTotal' => $_POST['subTotal'],
                'descuento' => $_POST['descuento'],
                'exento' => $_POST['exento'],
                'neto' => $_POST['neto'],
                'iva' => $_POST['iva'],
                'retencion' => $_POST['retencion'],
                'total' => $_POST['total']
            );
            $api -> agregarCabeceraApi($item);
        }else{
            echo json_encode(array('mensaje' => "invalido"));
        }
    }else{
        echo json_encode(array('mensaje' => "vacio"));
    }
?>