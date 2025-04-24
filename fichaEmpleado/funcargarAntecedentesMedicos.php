<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $datosRecibidos = file_get_contents("php://input");
    $datos = json_decode($datosRecibidos);
    $item = array(
        'idEmpleado' => $_POST['idEmpleado'],
        'antecedente' => $_POST['antecedente'],
        'descripcion' => $_POST['descripcion']
    );
    $api -> cargarAntecedenteMedicoApi($item);
?>