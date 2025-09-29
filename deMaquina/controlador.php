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
                    'idmaquina' => $valor['idmaquina'],
                    'patente' => $valor['patente'],
                    'numero_interno_maquina' => $valor['numero_interno_maquina'],
                    'anho_maquina' => $valor['anho_maquina'],
                    'capacidad_estanque' => $valor['capacidad_estanque'],
                    'secuencia_mantenimiento' => $valor['secuencia_mantenimiento'],
                    'numero_asientos' => $valor['numero_asientos'],
                    'numero_puertas' => $valor['numero_puertas'],
                    'centro_de_costo' => $valor['centro_de_costo'],
                    'padron' => $valor['padron']
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
                    'idmaquina' => $valor['idmaquina'],
                    'patente' => $valor['patente'],
                    'numero_interno_maquina' => $valor['numero_interno_maquina'],
                    'anho_maquina' => $valor['anho_maquina'],
                    'capacidad_estanque' => $valor['capacidad_estanque'],
                    'secuencia_mantenimiento' => $valor['secuencia_mantenimiento'],
                    'numero_asientos' => $valor['numero_asientos'],
                    'numero_puertas' => $valor['numero_puertas'],
                    'centro_de_costo' => $valor['centro_de_costo'],
                    'padron' => $valor['padron']
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
            $idRecogido = $verificarExistencia[0]['idmaquina'];
            $idParaModificar = $array['idmaquina'];
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
