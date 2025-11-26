<?php
include_once 'controlador.php';

$api = new ApiControlador();

$item = array(
    'patente' => $_POST['patente'] ?? '',
    'numero_interno_maquina' => $_POST['numero_interno_maquina'] ?? '',
    'tipo_maquina' => $_POST['tipo_maquina'] ?? '',
    'anho_maquina' => $_POST['anho_maquina'] ?? '',
    'capacidad_estanque' => $_POST['capacidad_estanque'] ?? '',
    'secuencia_mantenimiento' => $_POST['secuencia_mantenimiento'] ?? '',
    'numero_asientos' => $_POST['numero_asientos'] ?? '',
    'numero_puertas' => $_POST['numero_puertas'] ?? '',
    'centro_de_costo' => $_POST['centro_de_costo'] ?? '',
    'padron' => $_POST['padron'] ?? ''
);

$api->agregarApi($item);
