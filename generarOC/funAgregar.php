<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'empresa' => $datos->empresa,
        'proveedor' => $datos->proveedor,
        'solicitud_ms' => $datos->solicitud_ms,
        'doc_proveedor' => $datos->doc_proveedor,
        'num_doc_proveedor' => $datos->num_doc_proveedor,
        'plazo_oc' => $datos->plazo_oc,
        'pago_oc' => $datos->pago_oc,
        'plazo_entrega' => $datos->plazo_entrega,
        'tipo_doc_compra' => $datos->tipo_doc_compra,
        'pre_aprueba' => $datos->pre_aprueba,
        'nro_oc' => $datos->nro_oc,
        'fecha_creacion' => $datos->fecha_creacion
    );
    $api -> agregarApi($item);
?>