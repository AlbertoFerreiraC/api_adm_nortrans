<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
    'idtipo_piso_bus' => !empty($datos->idtipo_piso_bus) ? $datos->idtipo_piso_bus : $datos->id,
    'nro_piso'        => $datos->nro_piso,
    'clase_piso'      => $datos->clase_piso,
    'clase_piso_2'    => $datos->clase_piso_2,
    'asiento_1'       => $datos->asiento_1,
    'asiento_2'       => $datos->asiento_2
);
    $api -> modificarApi($item);
?>