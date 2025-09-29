<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idSms' => $datos->idSms,
        'producto' => $datos->producto,
        'tipo' => $datos->tipo,
        'unidadDeMedida' => $datos->unidadDeMedida,
        'centroDeCosto' => $datos->centroDeCosto,
        'cantidad' => $datos->cantidad,
        'aplicacion' => $datos->aplicacion
    );
    $api -> agregarItemModificar($item);
?>