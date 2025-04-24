<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idEmpleado' => $_POST['idEmpleado'],
        'nombre' => $_POST['nombre'],
        'parentesco' => $_POST['parentesco'],
        'telefono' => $_POST['telefono']
    );
    $api -> cargarContactoEmergencia($item);
?>