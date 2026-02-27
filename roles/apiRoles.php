<?php


include_once 'roles.php';

class ApiRoles{

    function listarApi(){
        $objeto = new Roles();
        $lista = $objeto->listar();
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'idroles' => $valor['idroles'],
                    'descripcionRol' => $valor['descripcionRol']
                );
                array_push($listaArr, $item);
            }
            printJSON($listaArr);
        } else {
            //error("error");
            header("HTTP/1.1 401 Unauthorized");
        }
    }


    function agregarApi($array){
        $objeto = new Roles();
        //********************************************************************    
        $verificarExistenciacedula = $objeto->verificar_existencia($array);
        if (empty($verificarExistenciacedula)) {
                $guardar = $objeto->agregar($array);
                if ($guardar == "ok") {
                    exito("ok");
                } else {
                    exito("nok");
                }
        } else {
            error("registro_existente");
        }
    }

    function obtenerDatosParaModificarApi($array){
        $objeto = new Roles();
        $lista = $objeto->obtenerDatosParaModificar($array);
        $listaArr = array();
        if (!empty($lista)) {
            foreach ($lista as $clave => $valor) {
                $item = array(
                    'id' => $valor['idroles'],
                    'descripcionRol' => $valor['descripcionRol'],
                    'accedeRrhh' => $valor['accedeRrhh'],
                    'fichaEmpleado' => $valor['fichaEmpleado'],
                    'solicitudContratacion' => $valor['solicitudContratacion'],
                    'preAprobacionDeSolicitud' => $valor['preAprobacionDeSolicitud'],
                    'aprobacionDeSolicitud' => $valor['aprobacionDeSolicitud'],
                    'fichaDeContrato' => $valor['fichaDeContrato'],
                    'cargoOrganizacional' => $valor['cargoOrganizacional'],
                    'mantenedorAreaDeNegocio' => $valor['mantenedorAreaDeNegocio'],
                    'datosLaboralesPorVencer' => $valor['datosLaboralesPorVencer'],
                    'solicitudContrPendiente' => $valor['solicitudContrPendiente'],
                    'solicitudContratacion2' => $valor['solicitudContratacion2'],
                    'nacionalidad' => $valor['nacionalidad'],
                    'comuna' => $valor['comuna'],
                    'afp' => $valor['afp'],
                    'salud' => $valor['salud'],
                    'turnosLaborales' => $valor['turnosLaborales'],
                    'empresas' => $valor['empresas'],
                    'documento' => $valor['documento'],
                    'tipoEpp' => $valor['tipoEpp'],
                    'antecedentesMedicos' => $valor['antecedentesMedicos'],
                    'cargos' => $valor['cargos'],
                    'tipoEquipo' => $valor['tipoEquipo'],
                    'tipoAnexo' => $valor['tipoAnexo'],
                    'tipoEstudio' => $valor['tipoEstudio'],
                    'tipoTerminoDeContrato' => $valor['tipoTerminoDeContrato'],
                    'contactoParentesco' => $valor['contactoParentesco'],
                    'requisitosDeSeleccion' => $valor['requisitosDeSeleccion'],
                    
                    // Campos de Máquinas (Activos)
                    'accedeActivos' => $valor['accedeActivos'],
                    'informeDocumentoMaquina' => $valor['informeDocumentoMaquina'],
                    'deMaquina' => $valor['deMaquina'],
                    'claseMaquina' => $valor['claseMaquina'],
                    'tipoBus' => $valor['tipoBus'],
                    'tipoMaquina' => $valor['tipoMaquina'],
                    'tipoDocumentoMaquina' => $valor['tipoDocumentoMaquina'],
                    'tipoEquipamientoMaquina' => $valor['tipoEquipamientoMaquina'],
                    'tipoPolizaSeguro' => $valor['tipoPolizaSeguro'],
                    'marcaChasis' => $valor['marcaChasis'],
                    'modeloChasis' => $valor['modeloChasis'],
                    'marcaCarroceria' => $valor['marcaCarroceria'],
                    'modeloCarroceria' => $valor['modeloCarroceria'],
                    'proveedores' => $valor['proveedores'],
                    'aseguradora' => $valor['aseguradora'],
                    
                    // Campos de Contabilidad
                    'accedeContabilidad' => $valor['accedeContabilidad'],
                    'misRendiciones' => $valor['misRendiciones'],
                    'gestionarRendiciones' => $valor['gestionarRendiciones'],
                    'asignacionFdoRendicion' => $valor['asignacionFdoRendicion'],
                    'preAprobacionFdoRendicion' => $valor['preAprobacionFdoRendicion'],
                    'aprobacionFdoRendicion' => $valor['aprobacionFdoRendicion'],
                    'maestroProveedor' => $valor['maestroProveedor'],
                    'condicionPago' => $valor['condicionPago'],
                    'tipoProveedor' => $valor['tipoProveedor'],
                    'comunaContabilidad' => $valor['comunaContabilidad'],
                    'criticidad' => $valor['criticidad'],
                    'clientes' => $valor['clientes'],
                    
                    // Campos de Bodega
                    'accedeBodegas' => $valor['accedeBodegas'],
                    'entregaRepuestoOt' => $valor['entregaRepuestoOt'],
                    'entregaProducto' => $valor['entregaProducto'],
                    'generarTraspasoBodega' => $valor['generarTraspasoBodega'],
                    'solicitarAnulacionEntregaSms' => $valor['solicitarAnulacionEntregaSms'],
                    'aprobarSolicitudAnulacionEntregaSms' => $valor['aprobarSolicitudAnulacionEntregaSms'],
                    'recepcionOrdenCompra' => $valor['recepcionOrdenCompra'],
                    'recepcionTraspaso' => $valor['recepcionTraspaso'],
                    'informeInventario' => $valor['informeInventario'],
                    'kardexProducto' => $valor['kardexProducto'],
                    'ajusteInventario' => $valor['ajusteInventario'],
                    'stockBodegaProducto' => $valor['stockBodegaProducto'],
                    'quiebreStock' => $valor['quiebreStock'],
                    'listaSmsPendiente' => $valor['listaSmsPendiente'],
                    'listaRecepcionOc' => $valor['listaRecepcionOc'],
                    'listaEntregaSms' => $valor['listaEntregaSms'],
                    'consultaAjusteInventario' => $valor['consultaAjusteInventario'],
                    'informeEntregaSms' => $valor['informeEntregaSms'],
                    'evaluacionProveedor' => $valor['evaluacionProveedor'],
                    'maestroProducto' => $valor['maestroProducto'],
                    'maestroRepuesto' => $valor['maestroRepuesto'],
                    'familiaRepuesto' => $valor['familiaRepuesto'],
                    'subfamiliaRepuesto' => $valor['subfamiliaRepuesto'],
                    'deMarca' => $valor['deMarca'],
                    'deModelo' => $valor['deModelo'],
                    'sistemaAplicacion' => $valor['sistemaAplicacion'],
                    'unidadMedida' => $valor['unidadMedida'],
                    'motivoAjusteInventario' => $valor['motivoAjusteInventario'],
                    'tipoDocumentoAjusteInventario' => $valor['tipoDocumentoAjusteInventario'],
                    'categoria' => $valor['categoria'],
                    'subCategoria' => $valor['subCategoria'],
                    'deBodega' => $valor['deBodega'],
                    
                    // Campos de Compras
                    'accedeCompras' => $valor['accedeCompras'],
                    'generarOc' => $valor['generarOc'],
                    'aprobarOc' => $valor['aprobarOc'],
                    'generaSms' => $valor['generaSms'],
                    'preAprobarSms' => $valor['preAprobarSms'],
                    'aprobarSms' => $valor['aprobarSms'],
                    'anularSms' => $valor['anularSms'],
                    'consultaOrdenCompra' => $valor['consultaOrdenCompra'],
                    'ocPendienteRecepcion' => $valor['ocPendienteRecepcion'],
                    'consultaListaOc' => $valor['consultaListaOc'],
                    'consultaListaDetalleOc' => $valor['consultaListaDetalleOc'],
                    'consultaSolicitudMaterialServicio' => $valor['consultaSolicitudMaterialServicio'],
                    'consultaListaSms' => $valor['consultaListaSms'],
                    'consultaListaDetalleSms' => $valor['consultaListaDetalleSms'],
                    'historialOcProveedor' => $valor['historialOcProveedor'],
                    'historialOcRepuesto' => $valor['historialOcRepuesto'],
                    'plazoOrdenCompra' => $valor['plazoOrdenCompra'],
                    'formaPagoOrdenCompra' => $valor['formaPagoOrdenCompra'],
                    'plazoEntregaOrdenCompra' => $valor['plazoEntregaOrdenCompra'],
                    'tipoSolicitudMaterialServicio' => $valor['tipoSolicitudMaterialServicio'],
                    'tipoDocumentoProveedor' => $valor['tipoDocumentoProveedor'],
                    'tipoDocumentoCajaChica' => $valor['tipoDocumentoCajaChica'],
                    
                    // Campos de Mantención
                    'accedeMantencion' => $valor['accedeMantencion'],
                    'reporteFalla' => $valor['reporteFalla'],
                    'preventivaOt' => $valor['preventivaOt'],
                    'otInterna' => $valor['otInterna'],
                    'servicioExternoOt' => $valor['servicioExternoOt'],
                    'asignarTareasPendientes' => $valor['asignarTareasPendientes'],
                    'editarOt' => $valor['editarOt'],
                    'terminarTareaOt' => $valor['terminarTareaOt'],
                    'registroKm' => $valor['registroKm'],
                    'editarKmMaquina' => $valor['editarKmMaquina'],
                    'ordenTrabajo' => $valor['ordenTrabajo'],
                    'repuestos' => $valor['repuestos'],
                    'listaOts' => $valor['listaOts'],
                    'tareasAsignadas' => $valor['tareasAsignadas'],
                    'campana' => $valor['campana'],
                    'pautaMantencion' => $valor['pautaMantencion'],
                    'sistemaMaquina' => $valor['sistemaMaquina'],
                    'subsistemaMaquina' => $valor['subsistemaMaquina'],
                    'tipoTareaMantencion' => $valor['tipoTareaMantencion'],
                    'nivelCriticidad' => $valor['nivelCriticidad'],
                    'secuenciaPauta' => $valor['secuenciaPauta'],
                    'detencionProgramada' => $valor['detencionProgramada'],
                    'modificacionDetencion' => $valor['modificacionDetencion'],
                    'categoriaPautaInspeccion' => $valor['categoriaPautaInspeccion'],
                    'conductores' => $valor['conductores'],
                    
                    // Campos de Configuración
                    'accedeConfiguracion' => $valor['accedeConfiguracion'],
                    'roles' => $valor['roles'],
                    'usuarios' => $valor['usuarios'],
                    'configuracionGeneral' => $valor['configuracionGeneral'],
                    'logsSistema' => $valor['logsSistema'],
                    'backupRestauracion' => $valor['backupRestauracion'],
                    
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

    function modificarApi($array){
        $objeto = new Roles();
        //******************************************************************** 
        $controlActualizacion = 1;
        $verificarExistenciaCedula = $objeto->verificar_existencia($array);
        if (!empty($verificarExistenciaCedula)) {
            $idRecogido = $verificarExistenciaCedula[0]['idroles'];
            $idParaModificar = $array['id'];
            if ($idRecogido != $idParaModificar) {
                $controlActualizacion = 2;
            }
        }

        if ($controlActualizacion == 1) {
            $editar = $objeto->modificar($array);
            if ($editar == "ok") {
                exito("ok");
            } else {
                exito("nok");
            }
        }

        if ($controlActualizacion == 2) {
            exito("registro_existente");
        }
    }

    function eliminarApi($array){
        $objeto = new Roles();
        //********************************************************************    
        $eliminar = $objeto->eliminar($array);
        if ($eliminar == "ok") {
            exito("ok");
        } else {
            exito("nok");
        }
    }

    function resetearPassApi($array){
        $objeto = new Roles();
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
