<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    $item = array(
        'idEmpleado' => $_POST['idEmpleado'],
        'idContratacion' => $_POST['idContratacion']
    );
    $api -> actualizarContratoApi($item);
?>