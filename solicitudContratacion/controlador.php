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
                    'idcontratacion' => $valor['idcontratacion'],
                    'cargo' => $valor['cargo'],
                    'empresa' => $valor['empresa'],
                    'centro_de_costo' => $valor['centroDeCosto'],
                    'turnos_laborales' => $valor['turnosLaborales'],
                    'tipo_bus' => $valor['tipoBus'],
                    'pre_aprueba' => $valor['preAprueba'],
                    'aprueba' => $valor['aprueba'],
                    'motivo' => $valor['motivo'],
                    'tipo_contrato' => $valor['tipoContrato'],
                    'division' => $valor['division'],
                    'cantidad_solicitada' => $valor['cantidadSolicitada'],
                    'licencia_de_conducir' => $valor['licenciaDeConducir'],
                    'tipo_documento' => $valor['tipoDocumento'],
                    'fecha_requerida' => $valor['fechaRequerida'],
                    'fecha_termino' => $valor['fechaTermino'],
                    'remuneracion' => $valor['remuneracion'],
                    'comentario_general' => $valor['comentarioGeneral']
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

    function obtenerDatosParaModificarApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idcontratacion' => $valor['idcontratacion'],
                    'cargo' => $valor['cargo'],
                    'empresa' => $valor['empresa'],
                    'centro_de_costo' => $valor['centroDeCosto'],
                    'turnos_laborales' => $valor['turnosLaborales'],
                    'tipo_bus' => $valor['tipoBus'],
                    'pre_aprueba' => $valor['preAprueba'],
                    'aprueba' => $valor['aprueba'],
                    'motivo' => $valor['motivo'],
                    'cantidad_solicitada' => $valor['cantidadSolicitada'],
                    'licencia_de_conducir' => $valor['licenciaDeConducir'],
                    'tipo_documento' => $valor['tipoDocumento'],
                    'fecha_requerida' => $valor['fechaRequerida'],
                    'fecha_termino' => $valor['fechaTermino'],
                    'remuneracion' => $valor['remuneracion'],
                    'comentario_general' => $valor['comentarioGeneral']
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
            $editar == "ok";
        } else {
            $idRecogido = $verificarExistencia[0]['idcontratacion'];
            $idParaModificar = $array['idcontratacion'];
            if ($idRecogido != $idParaModificar) {
                exito("repetido");
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
