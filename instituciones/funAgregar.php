<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'tipo_institucion' => $datos->tipo_institucion,
        'descripcion' => $datos->descripcion,
        'codigo_externo' => $datos->codigo_externo
    );
    $api -> agregarApi($item);
?>