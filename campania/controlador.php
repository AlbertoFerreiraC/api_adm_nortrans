<?php

include_once 'sql.php';

class ApiControlador
{

    function listarHerramientasApi()
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarHerramientas();
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $valor) {
                $item = array(
                    'idcampanha' => $valor['idcampanha'],
                    'fecha_creacion' => $valor['fecha_creacion'],
                    'tipo_campaha' => $valor['tipo_campaha'],
                    'descripcion' => $valor['descripcion'],
                    'tipo_frecuencia' => $valor['tipo_frecuencia'],
                    'frecuencia' => $valor['frecuencia'],
                    'comentario' => $valor['comentario'],
                    'fecha_desde' => $valor['fecha_desde'],
                    'fecha_hasta' => $valor['fecha_hasta']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function agregarApi($array)
    {
        $clasificacion = new Sql();
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if (empty($verificarExistencia)) {
            $guardar = $clasificacion->agregar($array);
            if ($guardar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            error("registro_existente");
        }
    }

    function obtenerDatosParaModificarApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $valor) {
                $item = array(
                    'idcampanha' => $valor['idcampanha'],
                    'fecha_creacion' => $valor['fecha_creacion'],
                    'tipo_campaha' => $valor['tipo_campaha'],
                    'descripcion' => $valor['descripcion'],
                    'tipo_frecuencia' => $valor['tipo_frecuencia'],
                    'frecuencia' => $valor['frecuencia'],
                    'comentario' => $valor['comentario'],
                    'fecha_desde' => $valor['fecha_desde'],
                    'fecha_hasta' => $valor['fecha_hasta']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function modificarApi($array)
    {
        $clasificacion = new Sql();
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if (empty($verificarExistencia)) {
            $editar = $clasificacion->modificar($array);
            if ($editar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            $idRecogido = $verificarExistencia[0]['idcampanha'];
            $idParaModificar = $array['idcampanha'];
            if ($idRecogido != $idParaModificar) {
                exito("repetido");
            } else {
                $editar = $clasificacion->modificar($array);
                if ($editar == "ok") {
                    exito("ok");
                } else {
                    exito("nok");
                }
            }
        }
    }

    function eliminarApi($array)
    {
        $clasificacion = new Sql();
        $eliminar = $clasificacion->eliminar($array);
        if ($eliminar == "ok") {
            exito("ok");
        } else {
            exito("nok");
        }
    }
} //FIN API

function error($mensaje)
{
    echo json_encode(array('mensaje' => $mensaje));
}

function exito($mensaje)
{
    echo json_encode(array('mensaje' => $mensaje));
}

function printJSON($array)
{
    echo json_encode($array);
}
