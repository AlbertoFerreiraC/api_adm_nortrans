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
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idmaquina'],
                    'centro_de_costo' => $valor['centro_de_costo'],
                    'tipo_bus' => $valor['tipo_bus'],
                    'descripcion' => $valor['descripcion'],
                    'km_anterior' => $valor['km_anterior'],
                    'fecha_km' => $valor['fecha_km'],
                    'km_actual' => $valor['km_actual']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
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
                'descripcion'     => $array['descripcion'],
                'km_anterior'     => $array['km_anterior'],
                'fecha_km'        => $array['fecha_km'],
                'km_actual'       => $array['km_actual'],
                'idmaquina'       => $array['idmaquina']
            );
            $editar = $clasificacion->modificar($datos);
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
} //FIN API SESIONES

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
