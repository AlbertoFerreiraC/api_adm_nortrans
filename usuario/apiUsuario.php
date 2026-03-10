<?php

include_once 'usuario.php';

class ApiUsuario
{

    function listarApi()
    {
        $objeto = new Usuario();
        $lista = $objeto->listar();
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idusuario' => $valor['idusuario'],
                    'rol' => $valor['descripcionRol'],
                    'cedula' => $valor['cedula'],
                    'nombre' => $valor['nombre'],
                    'nic' => $valor['nic'],
                    'telefono' => $valor['telefono'],
                    'correo' => $valor['correo'],
                    'preApruebaSolContratacion' => $valor['pre_aprueba_sol_contratacion'],
                    'apruebaSolContratacion' => $valor['aprueba_sol_contratacion'],
                    'preApruebaAsigFondoFijo' => $valor['pre_aprueba_asig_fondo_fijo'],
                    'apruebaAsigFondoFijo' => $valor['aprueba_asig_fondo_fijo'],
                    'preApruebaGenerarOc' => $valor['pre_aprueba_generar_oc'],
                    'apruebaGenerarOc' => $valor['aprueba_generar_oc'],
                    'preApruebaGenerarSms' => $valor['pre_aprueba_generar_sms'],
                    'apruebaGenerarSms' => $valor['aprueba_generar_sms']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function listarApruebaApi()
    {
        $objeto = new Usuario();
        $lista = $objeto->listar();
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'nombre' => $valor['nombre']
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
        $objeto = new Usuario();
        //********************************************************************    
        $verificarExistenciacedula = $objeto->verificar_existencia_cedula($array);
        if (empty($verificarExistenciacedula)) {
            $verificarExistenciaNic = $objeto->verificar_existencia_nic($array);
            if (empty($verificarExistenciaNic)) {
                $guardar = $objeto->agregar($array);
                if ($guardar == "ok") {
                    exito("ok");
                } else {
                    exito("nok");
                }
            } else {
                error("registro_existente");
            }
        } else {
            error("registro_existente");
        }
    }

    function obtenerDatosParaModificarApi($array)
    {
        $objeto = new Usuario();
        $lista = $objeto->obtenerDatosParaModificar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idusuario'],
                    'rol' => $valor['descripcionRol'],
                    'idroles' => $valor['idroles'],
                    'cedula' => $valor['cedula'],
                    'nombre' => $valor['nombre'],
                    'nic' => $valor['nic'],
                    'telefono' => $valor['telefono'],
                    'correo' => $valor['correo'],
                    'preApruebaSolContratacion' => $valor['pre_aprueba_sol_contratacion'],
                    'apruebaSolContratacion' => $valor['aprueba_sol_contratacion'],
                    'preApruebaAsigFondoFijo' => $valor['pre_aprueba_asig_fondo_fijo'],
                    'apruebaAsigFondoFijo' => $valor['aprueba_asig_fondo_fijo'],
                    'preApruebaGenerarOc' => $valor['pre_aprueba_generar_oc'],
                    'apruebaGenerarOc' => $valor['aprueba_generar_oc'],
                    'preApruebaGenerarSms' => $valor['pre_aprueba_generar_sms'],
                    'apruebaGenerarSms' => $valor['aprueba_generar_sms']
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
        $objeto = new Usuario();
        //******************************************************************** 
        $controlActualizacion = 1;

        $verificarExistenciaCedula = $objeto->verificar_existencia_cedula($array);
        if (!empty($verificarExistenciaCedula)) {
            $idRecogido = $verificarExistenciaCedula[0]['idusuario'];
            $idParaModificar = $array['id'];
            if ($idRecogido != $idParaModificar) {
                $controlActualizacion = 2;
            }
        }

        $verificarExistenciaNic = $objeto->verificar_existencia_nic($array);
        if (!empty($verificarExistenciaNic)) {
            $idRecogido = $verificarExistenciaNic[0]['idusuario'];
            $idParaModificar = $array['id'];
            if ($idRecogido != $idParaModificar) {
                $controlActualizacion = 3;
            }
        }

        if ($controlActualizacion == 1) {
            $datos = array(
                'id' => $array['id'],
                'rol' => $array['rol'],
                'cedula' => $array['cedula'],
                'nombre' => $array['nombre'],
                'nic' => $array['nic'],
                'telefono' => $array['telefono'],
                'correo' => $array['correo'],
                'solicitudContratacionAprueba' => $array['solicitudContratacionAprueba'],
                'solicitudContratacionPreAprueba' => $array['solicitudContratacionPreAprueba'],
                'fondoFijoAprueba' => $array['fondoFijoAprueba'],
                'fondoFijoPreAprueba' => $array['fondoFijoPreAprueba'],
                'generarOCAprueba' => $array['generarOCAprueba'],
                'generarOCPreAprueba' => $array['generarOCPreAprueba'],
                'generarSMSAprueba' => $array['generarSMSAprueba'],
                'generarSMSPreAprueba' => $array['generarSMSPreAprueba']
            );
            $editar = $objeto->modificar($datos);
            if ($editar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        }

        if ($controlActualizacion == 2) {
            exito("registro_existente");
        }

        if ($controlActualizacion == 3) {
            exito("registro_existente");
        }
    }

    function eliminarApi($array)
    {
        $objeto = new Usuario();
        //********************************************************************    
        $eliminar = $objeto->eliminar($array);
        if ($eliminar == "ok") {
            exito("ok");
        } else {
            exito("nok");
        }
    }

    function resetearPassApi($array)
    {
        $objeto = new Usuario();
        //********************************************************************    
        $eliminar = $objeto->resetearPass($array);
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
