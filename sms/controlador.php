<?php

include_once 'sql.php';

class ApiControlador
{

    function listarApruebaApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarApruebaApi($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idsms'],
                    'usuario' => $valor['usuario'],
                    'bodega' => $valor['bodega'],
                    'empresa' => $valor['empresa'],
                    'maquina' => $valor['maquina'],
                    'pre_aprueba' => $valor['pre_aprueba'],
                    'tipo' => $valor['tipo'],
                    'observacion' => $valor['observacion'],
                    'fecha_carga' => $valor['fecha_carga'],
                    'estado' => $valor['estado'],
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function listarAnularApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarAnularApi($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idsms'],
                    'usuario' => $valor['usuario'],
                    'bodega' => $valor['bodega'],
                    'empresa' => $valor['empresa'],
                    'maquina' => $valor['maquina'],
                    'pre_aprueba' => $valor['pre_aprueba'],
                    'tipo' => $valor['tipo'],
                    'observacion' => $valor['observacion'],
                    'fecha_carga' => $valor['fecha_carga'],
                    'estado' => $valor['estado'],
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function listarPreApruebaApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarPreApruebaApi($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idsms'],
                    'usuario' => $valor['usuario'],
                    'bodega' => $valor['bodega'],
                    'empresa' => $valor['empresa'],
                    'maquina' => $valor['maquina'],
                    'pre_aprueba' => $valor['pre_aprueba'],
                    'tipo' => $valor['tipo'],
                    'observacion' => $valor['observacion'],
                    'fecha_carga' => $valor['fecha_carga'],
                    'estado' => $valor['estado'],
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function PreAprobarApi($array)
    {
        $clasificacion = new Sql();

        if (!isset($array['id']) || empty($array['id']) || !isset($array['comentario']) || empty($array['comentario'])) {
            exito("nok");
            return;
        }

        $editar = $clasificacion->preAprobar($array);
        if ($editar == "ok") {
            exito("ok");
        } else {
            exito("nok", "No se pudo completar la pre-aprobación");
        }
    }

    function AnularApi($array)
    {
        $clasificacion = new Sql();

        if (!isset($array['id']) || empty($array['id']) || !isset($array['comentario']) || empty($array['comentario'])) {
            exito("nok");
            return;
        }

        $editar = $clasificacion->anular($array);
        if ($editar == "ok") {
            exito("ok");
        } else {
            exito("nok", "No se pudo completar la anulación");
        }
    }

    function aprobarApi($array)
    {
        $clasificacion = new Sql();

        if (!isset($array['id']) || empty($array['id']) || !isset($array['comentario']) || empty($array['comentario'])) {
            exito("nok");
            return;
        }

        $editar = $clasificacion->aprobar($array);
        if ($editar == "ok") {
            exito("ok");
        } else {
            exito("nok", "No se pudo completar la aprobación");
        }
    }

    function rechazarApi($array)
    {
        $clasificacion = new Sql();

        if (!isset($array['id']) || empty($array['id']) || !isset($array['comentario']) || empty($array['comentario'])) {
            exito("nok");
            return;
        }

        $editar = $clasificacion->rechazar($array);
        if ($editar == "ok") {
            exito("ok");
        } else {
            exito("nok", "No se pudo completar el rechazo");
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
