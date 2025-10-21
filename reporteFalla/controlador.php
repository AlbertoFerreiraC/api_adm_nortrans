<?php
include_once 'sql.php';

class ApiControlador
{
    /* =======================================================
       LISTAR REPORTES (cabecera)
    ======================================================= */
    function listarReporteApi()
    {
        file_put_contents('debug_reporte.log', "===> Entrando a listarReporteApi()\n", FILE_APPEND);
        $reporte = new Sql();
        $lista = $reporte->listarReportes();
        $listaArr = array();

        if (!empty($lista)) {
            file_put_contents('debug_reporte.log', "✅ Se obtuvieron " . count($lista) . " registros de reporte_falla\n", FILE_APPEND);
            foreach ($lista as $valor) {
                $listaArr[] = array(
                    'idreporte_falla' => $valor['idreporte_falla'],
                    'usuario'         => $valor['usuario'],
                    'dependencia'     => $valor['dependencia'],
                    'maquina'         => $valor['maquina'],
                    'conductor'       => $valor['conductor'],
                    'km_reportado'    => $valor['km_reportado'],
                    'fecha'           => $valor['fecha'],
                    'estado'          => $valor['estado']
                );
            }
            printJSON($listaArr);
        } else {
            file_put_contents('debug_reporte.log', "⚠️ No se encontraron reportes activos\n", FILE_APPEND);
            printJSON([]); // ✅ Enviar array vacío en lugar de 401
        }
    }


    /* =======================================================
       AGREGAR REPORTE (cabecera)
    ======================================================= */
    function agregarApi($array)
    {
        file_put_contents('debug_reporte.log', "===> Entrando a agregarApi()\n", FILE_APPEND);
        file_put_contents('debug_reporte.log', "Datos recibidos CABECERA: " . json_encode($array) . "\n", FILE_APPEND);

        $reporte = new Sql();

        $cabecera = array(
            'usuario'      => isset($array['usuario']) ? intval($array['usuario']) : 0,
            'dependencia'  => 1,
            'maquina'      => intval($array['maquina']),
            'conductor'    => intval($array['conductor']),
            'km_reportado' => $array['km_reportado'],
            'fecha'        => date("Y-m-d H:i:s"),
            'estado'       => 'activo'
        );

        $idCabecera = $reporte->agregarCabecera($cabecera);
        file_put_contents('debug_reporte.log', "Resultado insertar CABECERA → ID generado: {$idCabecera}\n", FILE_APPEND);

        if ($idCabecera > 0) {
            echo json_encode(['mensaje' => 'ok', 'idreporte_falla' => $idCabecera]);
        } else {
            file_put_contents('debug_reporte.log', "❌ Error al insertar la cabecera en reporte_falla\n", FILE_APPEND);
            echo json_encode(['mensaje' => 'nok']);
        }
    }

    /* =======================================================
       AGREGAR DETALLES DEL REPORTE
    ======================================================= */
    function agregarDetalleApi($idReporte, $detalles)
    {
        file_put_contents('debug_detalle_sql.log', "\n===> Entrando a agregarDetalleApi()\nID REPORTE: {$idReporte}\nDETALLES:\n" . json_encode($detalles) . "\n", FILE_APPEND);

        $reporte = new Sql();
        $todoOk = true;

        foreach ($detalles as $fila) {
            $item = array(
                'reporte_falla'       => intval($idReporte),
                'sistema_maquina'     => !empty($fila['sistema']) ? intval($fila['sistema']) : null,
                'sub_sistema_maquina' => !empty($fila['sub_sistema']) ? intval($fila['sub_sistema']) : null,
                'observacion'         => $fila['observacion']
            );

            file_put_contents('debug_detalle_sql.log', "➡️ Insertando detalle:\n" . json_encode($item) . "\n", FILE_APPEND);

            $res = $reporte->agregarDetalle($item);
            file_put_contents('debug_detalle_sql.log', "↪️ Resultado insertar detalle: {$res}\n", FILE_APPEND);

            if ($res !== "ok") {
                $todoOk = false;
                break;
            }
        }

        $final = $todoOk ? "ok" : "nok";
        file_put_contents('debug_detalle_sql.log', "✅ Resultado final agregarDetalleApi(): {$final}\n", FILE_APPEND);

        return $final;
    }

    /* =======================================================
       ELIMINAR REPORTE Y SUS DETALLES
    ======================================================= */
    function eliminarApi($array)
    {
        file_put_contents('debug_reporte.log', "===> Entrando a eliminarApi()\n", FILE_APPEND);
        file_put_contents('debug_reporte.log', "Datos recibidos ELIMINAR: " . json_encode($array) . "\n", FILE_APPEND);

        $reporte = new Sql();
        $eliminar = $reporte->eliminar($array);

        if ($eliminar == "ok") {
            file_put_contents('debug_reporte.log', "✅ Eliminación exitosa del reporte\n", FILE_APPEND);
            exito("ok");
        } else {
            file_put_contents('debug_reporte.log', "❌ Error al eliminar el reporte\n", FILE_APPEND);
            exito("nok");
        }
    }
}

/* =======================================================
   FUNCIONES AUXILIARES
======================================================= */
function error($mensaje)
{
    file_put_contents('debug_reporte.log', "⚠️ ERROR: {$mensaje}\n", FILE_APPEND);
    echo json_encode(array('mensaje' => $mensaje));
}

function exito($mensaje)
{
    file_put_contents('debug_reporte.log', "✅ ÉXITO: {$mensaje}\n", FILE_APPEND);
    echo json_encode(array('mensaje' => $mensaje));
}

function printJSON($array)
{
    file_put_contents('debug_reporte.log', "📦 OUTPUT JSON: " . json_encode($array) . "\n", FILE_APPEND);
    echo json_encode($array);
}
