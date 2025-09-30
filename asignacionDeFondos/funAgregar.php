<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idUsuario' => $datos->idUsuario,
        'montoSolicitado' => $datos->montoSolicitado,
        'otorgar' => $datos->otorgar,
        'motivo' => $datos->motivo,
        'preAprueba' => $datos->preAprueba,
        'aprueba' => $datos->aprueba
    );
    $api -> agregarApi($item);
?>