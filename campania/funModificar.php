<?php
include_once 'controlador.php';
$api = new ApiControlador();

$datosRecibidos = file_get_contents("php://input");
$datos = json_decode($datosRecibidos, true);

function convertirFecha($fecha)
{
    if (empty($fecha)) return null;
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
        return $fecha;
    }
    $fechaConvertida = DateTime::createFromFormat('d/m/Y', $fecha);
    if ($fechaConvertida) {
        return $fechaConvertida->format('Y-m-d');
    } else {
        return null;
    }
}

$item = array(
    'idcampanha' => $datos['idcampanha'],
    'fecha_creacion' => convertirFecha($datos['fecha_creacion']),
    'tipo_campaha' => $datos['tipo_campaha'],
    'descripcion' => $datos['descripcion'],
    'tipo_frecuencia' => $datos['tipo_frecuencia'],
    'frecuencia' => $datos['frecuencia'],
    'comentario' => $datos['comentario'],
    'fecha_desde' => convertirFecha($datos['fecha_desde']),
    'fecha_hasta' => convertirFecha($datos['fecha_hasta'])
);

$api->modificarApi($item);
