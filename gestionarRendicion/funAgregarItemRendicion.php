<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'id' => $datos->id,
        'fecha' => $datos->fecha,
        'tipo' => $datos->tipo,
        'nroDocumento' => $datos->nroDocumento,
        'monto' => $datos->monto,
        'detalle' => $datos->detalle,
        'maquina' => $datos->maquina,
        'centroDeCosto' => $datos->centroDeCosto,
        'proveedor' => $datos->proveedor
    );
    $api -> agregarItemApi($item);
?>