<?php

    include_once 'apiUsuario.php';
    $api = new ApiUsuario();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'id' => $datos->id,
        'rol' => $datos->rol,
        'cedula' => $datos->cedula,
        'nombre' => $datos->nombre,
        'nic' => $datos->nic,
        'telefono' => $datos->telefono,       
        'correo' => $datos->correo,
        'solicitudContratacionAprueba' => $datos->solicitudContratacionAprueba,
        'solicitudContratacionPreAprueba' => $datos->solicitudContratacionPreAprueba,
        'fondoFijoAprueba' => $datos->fondoFijoAprueba,
        'fondoFijoPreAprueba' => $datos->fondoFijoPreAprueba,
        'generarOCAprueba' => $datos->generarOCAprueba,
        'generarOCPreAprueba' => $datos->generarOCPreAprueba,
        'generarSMSAprueba' => $datos->generarSMSAprueba,
        'generarSMSPreAprueba' => $datos->generarSMSPreAprueba
    );
    $api -> modificarApi($item);
?>