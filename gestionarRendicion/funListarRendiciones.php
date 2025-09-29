<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'estado' => $datos->estado,
        'usuario' => $datos->usuario
    );
    $api -> listarRendiciones($item);
?>