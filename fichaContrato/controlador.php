<?php

include_once 'sql.php';

class ApiControlador
{

    function listarContratadoApi()
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->listarContratado();
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
                    'observacionEntrevistaPsicolaboral' => $valor['entrevista_psicolaboral'],
                    'observacionEntrevistaTecnica' => $valor['entrevista_tecnica'],
                    'observacionPruebaConduccion' => $valor['entrevista_conduccion'],
                    'cantidad_contratada' => $valor['cantidad_contratada'],
                    'usuario' => $valor['realizado_por'],
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

    function cambiarEstadoContratoApi($array)
    {
        $contratacion = new Sql();
        $array['estado'] = 'inactivo';
        $resultado = $contratacion->cambiarEstadoContrato($array);

        if ($resultado) {
            $response = array(
                'status' => 'success',
                'message' => 'Contrato inactivado correctamente'
            );
            printJSON($response);
        } else {
            header("HTTP/1.1 500 Internal Server Error");
            $response = array(
                'status' => 'error',
                'message' => 'Error al inactivar el contrato'
            );
            printJSON($response);
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

    function obtenerDatosParaModificarApi($array)
    {
        $clasificacion = new Sql();
        $lista = $clasificacion->obtenerDatosParaModificar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idficha_contrato' => $valor['idficha_contrato'],
                    'contratacion' => $valor['contratacion'],
                    'empresa' => $valor['empresa'],
                    'division' => $valor['division'],
                    'cargo' => $valor['cargo'],
                    'tipo_contrato' => $valor['tipo_contrato'],
                    'turnos_laborales' => $valor['turnos_laborales'],
                    'fecha_inicio' => $valor['fecha_inicio'],
                    'fecha_fin' => $valor['fecha_fin'],
                    'sueldo_liquido' => $valor['sueldo_liquido'],
                    'personal' => $valor['personal'],
                    'tipo_anexo' => $valor['tipo_anexo'],
                    'fecha_anexo' => $valor['fecha_anexo'],
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
