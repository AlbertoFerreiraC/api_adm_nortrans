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
                    'centro_de_costo' => $valor['centro_de_costo'],
                    'turnos_laborales' => $valor['turnos_laborales'],
                    'tipo_bus' => $valor['tipo_bus'],
                    'pre_aprueba' => $valor['pre_aprueba'],
                    'aprueba' => $valor['aprueba'],
                    'motivo' => $valor['motivo'],
                    'tipo_contrato' => $valor['tipo_contrato'],
                    'division' => $valor['division'],
                    'cantidad_solicitada' => $valor['cantidad_solicitada'],
                    'licencia_de_conducir' => $valor['licencia_de_conducir'],
                    'fecha_requerida' => $valor['fecha_requerida'],
                    'fecha_termino' => $valor['fecha_termino'],
                    'remuneracion' => $valor['remuneracion'],
                    'comentario_general' => $valor['comentario_general'],
                    'estado' => 'activo',
                    'cantidad_contratada' => $valor['cantidad_contratada'],
                    'usuario' => $valor['usuario'],
                    'fecha_inicio_laboral' => $valor['fecha_inicio_laboral']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function listarRequisitoContratacionApi()
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarRequisitoContratacion();
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idrequisito_de_seleccion'],
                    'descripcion' => $valor['descripcion']
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
                $idGenerado = $clasificacion->obtenerID();
                foreach ($array['tabla'] as $clave => $valor) {
                    $datosDetalle = array(
                        'contratacion' => $idGenerado[0]['id'],
                        'requisito' => $valor->requisito,
                        'observacion' => $valor->observacion
                    );
                    //printJSON($datosDetalle);
                    $clasificacion->agregarDetalle($datosDetalle);
                }
                exito("ok");
            } else {
                exito("nok");
                //  return printJSON($guardar);
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

                // 🔹 Eliminamos los valores nulos, vacíos o con cadena "null"
                $filtrado = array_filter($valor, function ($v) {
                    return !is_null($v) && $v !== '' && strtolower($v) !== 'null';
                });

                // 🔹 Renombramos las claves según tu estructura original (solo si existen)
                $item = array(
                    'idcontratacion' => $filtrado['idcontratacion'] ?? null,
                    'cargo' => $filtrado['cargo'] ?? null,
                    'empresa' => $filtrado['empresa'] ?? null,
                    'division' => $filtrado['division'] ?? null,
                    'centroDeCosto' => $filtrado['centro_de_costo'] ?? null,
                    'turnosLaborales' => $filtrado['turnos_laborales'] ?? null,
                    'tipoBus' => $filtrado['tipo_bus'] ?? null,
                    'preaprueba' => $filtrado['pre_aprueba'] ?? null,
                    'aprueba' => $filtrado['aprueba'] ?? null,
                    'motivo' => $filtrado['motivo'] ?? null,
                    'cantidad_solicitada' => $filtrado['cantidad_solicitada'] ?? null,
                    'licenciaDeConducir' => $filtrado['licencia_de_conducir'] ?? null,
                    'tipo_contrato' => $filtrado['tipo_contrato'] ?? null,
                    'fecha_requerida' => $filtrado['fecha_requerida'] ?? null,
                    'fecha_termino' => $filtrado['fecha_termino'] ?? null,
                    'remuneracion' => $filtrado['remuneracion'] ?? null,
                    'comentario_general' => $filtrado['comentario_general'] ?? null,
                    'observacion_pre_aprobacion' => $filtrado['observacion_pre_aprobacion'] ?? null,
                    'fecha_pre_aperobacion' => $filtrado['fecha_pre_aperobacion'] ?? null,
                    'fecha_aprobacion' => $filtrado['fecha_aprobacion'] ?? null,
                    'observacion_aprobacion' => $filtrado['observacion_aprobacion'] ?? null,
                    'cantidad_contratada' => $filtrado['cantidad_contratada'] ?? null,
                    'usuario' => $filtrado['usuario'] ?? null,
                    'fecha_inicio_laboral' => $filtrado['fecha_inicio_laboral'] ?? null
                );

                // 🔹 Eliminamos del item final los valores null
                $item = array_filter($item, fn($v) => !is_null($v) && $v !== '' && strtolower($v) !== 'null');

                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function listarRequisitosPorContratacion($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarRequisitos($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idContratacion' => $valor['contratacion'],
                    'idDetalle' => $valor['iddetalle_contratacion'],
                    'requisito' => $valor['requisito'],
                    'observacion' => $valor['observacion']
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
            $idRecogido = $verificarExistencia[0]['idcontratacion'];
            $idParaModificar = $array['idcontratacion'];
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

    function agregarRequisitoDetalleApi($array)
    {
        $clasificacion = new Sql();
        $eliminar = $clasificacion->agregarDetalle($array);
        if ($eliminar == "ok") {
            exito("ok");
        } else {
            exito("nok");
        }
    }

    function eliminarDetalleRequisitoApi($array)
    {
        $clasificacion = new Sql();
        $eliminar = $clasificacion->eliminarDetalle($array);
        if ($eliminar == "ok") {
            exito("ok");
        } else {
            exito("nok");
        }
    }

    function listarDatosContratoPorConfirmarApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarDatosContratoPorConfirmar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'motivo' => $valor['motivo'],
                    'division' => $valor['division'],
                    'cargo' => $valor['cargo'],
                    'empresa' => $valor['empresa'],
                    'centro' => $valor['centro'],
                    'cantidad_solicitada' => $valor['cantidad_solicitada'],
                    'licencia_de_conducir' => $valor['licencia_de_conducir'],
                    'turno' => $valor['turno'],
                    'tipo_contrato' => $valor['tipo_contrato'],
                    'fecha_requerida' => $valor['fecha_requerida'],
                    'fecha_termino' => $valor['fecha_termino'],
                    'remuneracion' => $valor['remuneracion'],
                    'comentario_general' => $valor['comentario_general'],
                    'observacion_pre_aprobacion' => $valor['observacion_pre_aprobacion'],
                    'observacion_aprobacion' => $valor['observacion_aprobacion'],
                    'tipo_bus' => $valor['tipo_bus'],
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
