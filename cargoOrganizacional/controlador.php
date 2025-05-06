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
                    'idcargo_organizacional' => $valor['idcargo_organizacional'],
                    'area_negocio' => $valor['area_negocio'],
                    'area_dependencia' => $valor['area_dependencia'],
                    'nombre' => $valor['nombre'],
                    'division' => $valor['division'],
                    'solicitud_personal' => $valor['solicitud_personal'],
                    'autoriza_ms' => $valor['autoriza_ms'],
                    'autoriza_oc' => $valor['autoriza_oc'],
                    'aprueba_solicitud' => $valor['aprueba_solicitud'],
                    'estado' => $valor['estado'],
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function listarSolicitudesAPI()
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarSolicitudes();
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idcontratacion' => $valor['idcontratacion'],
                    'empresa' => $valor['empresa'],
                    'fecha_requerida' => $valor['fecha_requerida'],
                    'usuario' => $valor['realizado_por'],
                    'division' => $valor['division'],
                    'cargo' => $valor['cargo'],
                    'cantidad_solicitada' => $valor['cantidad_solicitada'],
                    'estado' => 'activo',
                    'cantidad_contratada' => $valor['cantidad_contratada']
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
            $guardar = $clasificacion->agregar($array);
            if ($guardar == "ok") {
                exito("ok");
            } else {
                exito("nok");
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

    function obtenerDatosParaModificarApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idcargo_organizacional' => $valor['idcargo_organizacional'],
                    'area_negocio' => $valor['area_negocio'],
                    'area_dependencia' => $valor['area_dependencia'],
                    'nombre' => $valor['nombre'],
                    'division' => $valor['division'],
                    'solicitud_personal' => $valor['solicitud_personal'],
                    'autoriza_ms' => $valor['autoriza_ms'],
                    'autoriza_oc' => $valor['autoriza_oc'],
                    'aprueba_solicitud' => $valor['aprueba_solicitud']
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
            $editar = $clasificacion->modificar($array);
            if ($editar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        } else {
            $idRecogido = $verificarExistencia[0]['idcargo_organizacional'];
            $idParaModificar = $array['idcargo_organizacional'];
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
