<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idDetalle' => $datos->idDetalle,
        'cantidad' => $datos->cantidad
    );
    $api -> actualizarCantidadApi($item);
?>