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
                    'id' => $valor['idtipo_piso_bus'],
                    'nro_piso' => $valor['nro_piso'],
                    'clase_piso' => $valor['clase_piso'],
                    'clase_piso_2' => $valor['clase_piso_2'],
                    'asiento_1' => $valor['asiento_1'],
                    'asiento_2' => $valor['asiento_2'],
                    'estado' => $valor['estado']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function agregarApi($array)
    {
        $clasificacion = new Sql();
        //********************************************************************    
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if (empty($verificarExistencia)) {
            $datos = array(
                'nro_piso' => $array['nro_piso'],
                'clase_piso' => $array['clase_piso'],
                'asiento_1' => $array['asiento_1'],
                'clase_piso_2' => $array['clase_piso_2'],
                'asiento_2' => $array['asiento_2']
            );
            $guardar = $clasificacion->agregar($datos);
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
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idtipo_piso_bus'],
                    'nro_piso' => $valor['nro_piso'],
                    'clase_piso' => $valor['clase_piso'],
                    'asiento_1' => $valor['asiento_1'],
                    'clase_piso_2' => $valor['clase_piso_2'],
                    'asiento_2' => $valor['asiento_2'],
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
        //********************************************************************    
        $verificarExistencia = $clasificacion->verificar_existencia($array);
        if (empty($verificarExistencia)) {
            $datos = array(
                'nro_piso' => $array['nro_piso'],
                'clase_piso' => $array['clase_piso'],
                'clase_piso_2' => $array['clase_piso_2'],
                'asiento_1' => $array['asiento_1'],
                'asiento_2' => $array['asiento_2'],
                'idtipo_piso_bus' => $array['idtipo_piso_bus']
            );
            $editar = $clasificacion->modificar($datos);
            if ($editar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            $idRecogido = $verificarExistencia[0]['idtipo_epp'];
            $idParaModificar = $array['id'];
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
        //********************************************************************    
        $eliminar = $clasificacion->eliminar($array);
        if ($eliminar == "ok") {
            exito("ok");
        } else {
            exito("nok");
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
