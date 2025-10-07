<?php

include_once 'sql.php';

class ApiControlador
{

    function listarOTApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarOTApi($array);
        $listaArr = array();

        if (!empty($lista)) {
            foreach ($lista as $valor) {
                $item = array(
                    'idsms' => $valor['idsms'],
                    'iddetalle_sms' => $valor['iddetalle_sms'],
                    'tipo' => $valor['tipo_producto'],
                    'idproducto' => $valor['idproducto'],
                    'cantidad' => $valor['cantidad'],
                    'bodega' => $valor['bodega'],
                    'empresa' => $valor['empresa'],
                    'maquina' => $valor['maquina']
                );
                $listaArr[] = $item;
            }
            printJSON($listaArr);
        } else {
            header("HTTP/1.1 204 No Content");
        }
    }
} //FIN API SESIONES

function error($mensaje)
{
    echo json_encode(array('mensaje' => $mensaje));
}

function exito($mensaje, $detalle = "")
{
    echo json_encode(array(
        'mensaje' => $mensaje,
        'detalle' => $detalle
    ));
}

function printJSON($array)
{
    echo json_encode($array);
}
