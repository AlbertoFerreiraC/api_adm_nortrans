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
                    'nro_chasis' => $valor['nro_chasis'],
                    'tipo_documento_maquina' => $valor['tipo_documento_maquina'],
                    'tipo_equipamiento_maquina' => $valor['tipo_equipamiento_maquina'],
                    'tipo_poliza_seguro' => $valor['tipo_poliza_seguro'],
                    'centro_de_costo' => $valor['centro_de_costo'],
                    'clase_bus' => $valor['clase_bus'],
                    'tipo_piso_bus' => $valor['tipo_piso_bus'],
                    'marca_carroceria' => $valor['marca_carroceria'],
                    'modelo_carroceria' => $valor['modelo_carroceria'],
                    'modelo_chasis' => $valor['modelo_chasis'],
                    'marca_chasis' => $valor['marca_chasis'],
                    'tipo_patente' => $valor['tipo_patente'],
                    'patente' => $valor['patente'],
                    'numero_interno_maquina' => $valor['numero_interno_maquina'],
                    'anho_maquina' => $valor['anho_maquina'],
                    'capacidad_estanque' => $valor['capacidad_estanque'],
                    'secuencia_mantenimiento' => $valor['secuencia_mantenimiento'],
                    'numero_asientos' => $valor['numero_asientos'],
                    'numero_puertas' => $valor['numero_puertas'],
                    'padron' => $valor['padron'],
                    'numero_motor' => $valor['numero_motor'],
                    'numero_carroceria' => $valor['numero_carroceria'],
                    'tipo_compra' => $valor['tipo_compra'],
                    'propietario' => $valor['propietario'],
                    'proveedor' => $valor['proveedor'],
                    'nro_operacion' => $valor['nro_operacion'],
                    'fecha_inicio' => $valor['fecha_inicio'],
                    'numero_cuota' => $valor['numero_cuota'],
                    'estado' => $valor['estado']
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
                    'nro_chasis' => $valor['nro_chasis'],
                    'tipo_documento_maquina' => $valor['tipo_documento_maquina'],
                    'tipo_equipamiento_maquina' => $valor['tipo_equipamiento_maquina'],
                    'tipo_poliza_seguro' => $valor['tipo_poliza_seguro'],
                    'centro_de_costo' => $valor['centro_de_costo'],
                    'clase_bus' => $valor['clase_bus'],
                    'tipo_piso_bus' => $valor['tipo_piso_bus'],
                    'marca_carroceria' => $valor['marca_carroceria'],
                    'modelo_carroceria' => $valor['modelo_carroceria'],
                    'modelo_chasis' => $valor['modelo_chasis'],
                    'marca_chasis' => $valor['marca_chasis'],
                    'tipo_patente' => $valor['tipo_patente'],
                    'patente' => $valor['patente'],
                    'numero_interno_maquina' => $valor['numero_interno_maquina'],
                    'anho_maquina' => $valor['anho_maquina'],
                    'capacidad_estanque' => $valor['capacidad_estanque'],
                    'secuencia_mantenimiento' => $valor['secuencia_mantenimiento'],
                    'numero_asientos' => $valor['numero_asientos'],
                    'numero_puertas' => $valor['numero_puertas'],
                    'padron' => $valor['padron'],
                    'numero_motor' => $valor['numero_motor'],
                    'numero_carroceria' => $valor['numero_carroceria'],
                    'tipo_compra' => $valor['tipo_compra'],
                    'propietario' => $valor['propietario'],
                    'proveedor' => $valor['proveedor'],
                    'nro_operacion' => $valor['nro_operacion'],
                    'fecha_inicio' => $valor['fecha_inicio'],
                    'numero_cuota' => $valor['numero_cuota'],
                    'estado' => $valor['estado']
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
