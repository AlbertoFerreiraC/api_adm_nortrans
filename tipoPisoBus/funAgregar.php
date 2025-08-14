<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'nro_piso' => $datos->nro_piso,
        'clase_piso' => $datos->clase_piso,
        'asiento_1' => $datos->asiento_1,
        'clase_piso_2' => !empty($datos->clase_piso_2) ? $datos->clase_piso_2 : 0,
        'asiento_2' => !empty($datos->asiento_2) ? $datos->asiento_2 : 0
    );
    $api -> agregarApi($item);
?>