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
                    'idregistro_km'     => $valor['idregistro_km'],
                    'centro_de_costo'   => $valor['centro_de_costo'],
                    'tipo_bus'          => $valor['tipo_bus'],
                    'maquina'           => $valor['maquina'],
                    'descripcion'       => $valor['descripcion'],
                    'km_anterior'       => $valor['km_anterior'],
                    'fecha_km'          => $valor['fecha_km'],
                    'km_actual'         => $valor['km_actual']
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

        // Verificar último registro de la máquina
        $ultimoRegistro = $clasificacion->verificar_existencia($array);

        if (empty($ultimoRegistro) || $array['km_actual'] > $ultimoRegistro['km_actual']) {
            // Permitir guardar si no hay registros previos o si el nuevo km es mayor
            $datos = array(
                'centro_de_costo' => $array['centro_de_costo'],
                'tipo_bus'        => $array['tipo_bus'],
                'maquina'         => $array['maquina'],
                'descripcion'     => $array['descripcion'],
                'km_anterior'     => $array['km_anterior'],
                'fecha_km'        => $array['fecha_km'],
                'km_actual'       => $array['km_actual']
            );

            $guardar = $clasificacion->agregar($datos);

            if ($guardar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            // Si el nuevo km es menor o igual, rechazar
            exito("menor_o_igual");
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
                    'idregistro_km'     => $valor['idregistro_km'],
                    'centro_de_costo'   => $valor['centro_de_costo'],
                    'tipo_bus'          => $valor['tipo_bus'],
                    'maquina'           => $valor['maquina'],
                    'descripcion'       => $valor['descripcion'],
                    'km_anterior'       => $valor['km_anterior'],
                    'km_actual'         => $valor['km_actual'],
                    'fecha_km'          => $valor['fecha_km']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(["mensaje" => "No se encontraron datos para modificar."]);
        }
    }

    function modificarApi($array)
    {
        $clasificacion = new Sql();
        $verificarExistencia = $clasificacion->verificar_existencia($array);

        if (empty($verificarExistencia)) {
            $datos = array(
                'centro_de_costo' => $array['centro_de_costo'],
                'tipo_bus'        => $array['tipo_bus'],
                'maquina'         => $array['maquina'],
                'descripcion'     => $array['descripcion'],
                'km_anterior'     => $array['km_anterior'],
                'fecha_km'        => $array['fecha_km'],
                'km_actual'       => $array['km_actual'],
                'idregistro_km'   => $array['idregistro_km']
            );
            $editar = $clasificacion->modificar($datos);
            if ($editar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            $idRecogido = $verificarExistencia[0]['idregistro_km'];
            $idParaModificar = $array['idregistro_km'];
            if ($idRecogido != $idParaModificar) {
                exito("duplicado");
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
} // FIN CLASE

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
