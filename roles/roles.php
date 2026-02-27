<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include_once '../db.php';

class Roles extends DB{


    function listar(){
        $query = $this->connect()->prepare("select * from roles where estado = 'activo'");
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }


    function verificar_existencia($item){
        $query = $this->connect()->prepare("select * from roles where estado = 'activo' and 
        descripcionRol = :descripcionRol");
        $query->bindParam(":descripcionRol", $item['descripcionRol'], PDO::PARAM_STR);
        if($query->execute()){
          return $query->fetchAll();
        }else{
          return null;		
        }
    }

    function agregar($item){
        $query = $this->connect()->prepare("
            INSERT INTO roles (
                descripcionRol,
                accedeRrhh,
                fichaEmpleado,
                solicitudContratacion,
                preAprobacionDeSolicitud,
                aprobacionDeSolicitud,
                fichaDeContrato,
                cargoOrganizacional,
                mantenedorAreaDeNegocio,
                datosLaboralesPorVencer,
                solicitudContrPendiente,
                solicitudContratacion2,
                nacionalidad,
                comuna,
                afp,
                salud,
                turnosLaborales,
                empresas,
                documento,
                tipoEpp,
                antecedentesMedicos,
                cargos,
                tipoEquipo,
                tipoAnexo,
                tipoEstudio,
                tipoTerminoDeContrato,
                contactoParentesco,
                requisitosDeSeleccion,
                accedeActivos,
                informeDocumentoMaquina,
                deMaquina,
                claseMaquina,
                tipoBus,
                tipoMaquina,
                tipoDocumentoMaquina,
                tipoEquipamientoMaquina,
                tipoPolizaSeguro,
                marcaChasis,
                modeloChasis,
                marcaCarroceria,
                modeloCarroceria,
                proveedores,
                aseguradora,
                accedeContabilidad,
                misRendiciones,
                gestionarRendiciones,
                asignacionFdoRendicion,
                preAprobacionFdoRendicion,
                aprobacionFdoRendicion,
                maestroProveedor,
                condicionPago,
                tipoProveedor,
                comunaContabilidad,
                criticidad,
                clientes,
                accedeBodegas,
                entregaRepuestoOt,
                entregaProducto,
                generarTraspasoBodega,
                solicitarAnulacionEntregaSms,
                aprobarSolicitudAnulacionEntregaSms,
                recepcionOrdenCompra,
                recepcionTraspaso,
                informeInventario,
                kardexProducto,
                ajusteInventario,
                stockBodegaProducto,
                quiebreStock,
                listaSmsPendiente,
                listaRecepcionOc,
                listaEntregaSms,
                consultaAjusteInventario,
                informeEntregaSms,
                evaluacionProveedor,
                maestroProducto,
                maestroRepuesto,
                familiaRepuesto,
                subfamiliaRepuesto,
                deMarca,
                deModelo,
                sistemaAplicacion,
                unidadMedida,
                motivoAjusteInventario,
                tipoDocumentoAjusteInventario,
                categoria,
                subCategoria,
                deBodega,
                accedeCompras,
                generarOc,
                aprobarOc,
                generaSms,
                preAprobarSms,
                aprobarSms,
                anularSms,
                consultaOrdenCompra,
                ocPendienteRecepcion,
                consultaListaOc,
                consultaListaDetalleOc,
                consultaSolicitudMaterialServicio,
                consultaListaSms,
                consultaListaDetalleSms,
                historialOcProveedor,
                historialOcRepuesto,
                plazoOrdenCompra,
                formaPagoOrdenCompra,
                plazoEntregaOrdenCompra,
                tipoSolicitudMaterialServicio,
                tipoDocumentoProveedor,
                tipoDocumentoCajaChica,
                accedeMantencion,
                reporteFalla,
                preventivaOt,
                otInterna,
                servicioExternoOt,
                asignarTareasPendientes,
                editarOt,
                terminarTareaOt,
                registroKm,
                editarKmMaquina,
                ordenTrabajo,
                repuestos,
                listaOts,
                tareasAsignadas,
                campana,
                pautaMantencion,
                sistemaMaquina,
                subsistemaMaquina,
                tipoTareaMantencion,
                nivelCriticidad,
                secuenciaPauta,
                detencionProgramada,
                modificacionDetencion,
                categoriaPautaInspeccion,
                conductores,
                accedeConfiguracion,
                roles,
                usuarios,
                configuracionGeneral,
                logsSistema,
                backupRestauracion,
                estado
            ) VALUES (
                :descripcionRol,
                :accedeRrhh,
                :fichaEmpleado,
                :solicitudContratacion,
                :preAprobacionDeSolicitud,
                :aprobacionDeSolicitud,
                :fichaDeContrato,
                :cargoOrganizacional,
                :mantenedorAreaDeNegocio,
                :datosLaboralesPorVencer,
                :solicitudContrPendiente,
                :solicitudContratacion2,
                :nacionalidad,
                :comuna,
                :afp,
                :salud,
                :turnosLaborales,
                :empresas,
                :documento,
                :tipoEpp,
                :antecedentesMedicos,
                :cargos,
                :tipoEquipo,
                :tipoAnexo,
                :tipoEstudio,
                :tipoTerminoDeContrato,
                :contactoParentesco,
                :requisitosDeSeleccion,
                :accedeActivos,
                :informeDocumentoMaquina,
                :deMaquina,
                :claseMaquina,
                :tipoBus,
                :tipoMaquina,
                :tipoDocumentoMaquina,
                :tipoEquipamientoMaquina,
                :tipoPolizaSeguro,
                :marcaChasis,
                :modeloChasis,
                :marcaCarroceria,
                :modeloCarroceria,
                :proveedores,
                :aseguradora,
                :accedeContabilidad,
                :misRendiciones,
                :gestionarRendiciones,
                :asignacionFdoRendicion,
                :preAprobacionFdoRendicion,
                :aprobacionFdoRendicion,
                :maestroProveedor,
                :condicionPago,
                :tipoProveedor,
                :comunaContabilidad,
                :criticidad,
                :clientes,
                :accedeBodegas,
                :entregaRepuestoOt,
                :entregaProducto,
                :generarTraspasoBodega,
                :solicitarAnulacionEntregaSms,
                :aprobarSolicitudAnulacionEntregaSms,
                :recepcionOrdenCompra,
                :recepcionTraspaso,
                :informeInventario,
                :kardexProducto,
                :ajusteInventario,
                :stockBodegaProducto,
                :quiebreStock,
                :listaSmsPendiente,
                :listaRecepcionOc,
                :listaEntregaSms,
                :consultaAjusteInventario,
                :informeEntregaSms,
                :evaluacionProveedor,
                :maestroProducto,
                :maestroRepuesto,
                :familiaRepuesto,
                :subfamiliaRepuesto,
                :deMarca,
                :deModelo,
                :sistemaAplicacion,
                :unidadMedida,
                :motivoAjusteInventario,
                :tipoDocumentoAjusteInventario,
                :categoria,
                :subCategoria,
                :deBodega,
                :accedeCompras,
                :generarOc,
                :aprobarOc,
                :generaSms,
                :preAprobarSms,
                :aprobarSms,
                :anularSms,
                :consultaOrdenCompra,
                :ocPendienteRecepcion,
                :consultaListaOc,
                :consultaListaDetalleOc,
                :consultaSolicitudMaterialServicio,
                :consultaListaSms,
                :consultaListaDetalleSms,
                :historialOcProveedor,
                :historialOcRepuesto,
                :plazoOrdenCompra,
                :formaPagoOrdenCompra,
                :plazoEntregaOrdenCompra,
                :tipoSolicitudMaterialServicio,
                :tipoDocumentoProveedor,
                :tipoDocumentoCajaChica,
                :accedeMantencion,
                :reporteFalla,
                :preventivaOt,
                :otInterna,
                :servicioExternoOt,
                :asignarTareasPendientes,
                :editarOt,
                :terminarTareaOt,
                :registroKm,
                :editarKmMaquina,
                :ordenTrabajo,
                :repuestos,
                :listaOts,
                :tareasAsignadas,
                :campana,
                :pautaMantencion,
                :sistemaMaquina,
                :subsistemaMaquina,
                :tipoTareaMantencion,
                :nivelCriticidad,
                :secuenciaPauta,
                :detencionProgramada,
                :modificacionDetencion,
                :categoriaPautaInspeccion,
                :conductores,
                :accedeConfiguracion,
                :roles,
                :usuarios,
                :configuracionGeneral,
                :logsSistema,
                :backupRestauracion,
                'activo'
            )
        ");

        $query->bindParam(":descripcionRol", $item['descripcionRol'], PDO::PARAM_STR);
        $query->bindParam(":accedeRrhh", $item['accedeRrhh'], PDO::PARAM_STR);
        $query->bindParam(":fichaEmpleado", $item['fichaEmpleado'], PDO::PARAM_STR);
        $query->bindParam(":solicitudContratacion", $item['solicitudContratacion'], PDO::PARAM_STR);
        $query->bindParam(":preAprobacionDeSolicitud", $item['preAprobacionDeSolicitud'], PDO::PARAM_STR);
        $query->bindParam(":aprobacionDeSolicitud", $item['aprobacionDeSolicitud'], PDO::PARAM_STR);
        $query->bindParam(":fichaDeContrato", $item['fichaDeContrato'], PDO::PARAM_STR);
        $query->bindParam(":cargoOrganizacional", $item['cargoOrganizacional'], PDO::PARAM_STR);
        $query->bindParam(":mantenedorAreaDeNegocio", $item['mantenedorAreaDeNegocio'], PDO::PARAM_STR);
        $query->bindParam(":datosLaboralesPorVencer", $item['datosLaboralesPorVencer'], PDO::PARAM_STR);
        $query->bindParam(":solicitudContrPendiente", $item['solicitudContrPendiente'], PDO::PARAM_STR);
        $query->bindParam(":solicitudContratacion2", $item['solicitudContratacion2'], PDO::PARAM_STR);
        $query->bindParam(":nacionalidad", $item['nacionalidad'], PDO::PARAM_STR);
        $query->bindParam(":comuna", $item['comuna'], PDO::PARAM_STR);
        $query->bindParam(":afp", $item['afp'], PDO::PARAM_STR);
        $query->bindParam(":salud", $item['salud'], PDO::PARAM_STR);
        $query->bindParam(":turnosLaborales", $item['turnosLaborales'], PDO::PARAM_STR);
        $query->bindParam(":empresas", $item['empresas'], PDO::PARAM_STR);
        $query->bindParam(":documento", $item['documento'], PDO::PARAM_STR);
        $query->bindParam(":tipoEpp", $item['tipoEpp'], PDO::PARAM_STR);
        $query->bindParam(":antecedentesMedicos", $item['antecedentesMedicos'], PDO::PARAM_STR);
        $query->bindParam(":cargos", $item['cargos'], PDO::PARAM_STR);
        $query->bindParam(":tipoEquipo", $item['tipoEquipo'], PDO::PARAM_STR);
        $query->bindParam(":tipoAnexo", $item['tipoAnexo'], PDO::PARAM_STR);
        $query->bindParam(":tipoEstudio", $item['tipoEstudio'], PDO::PARAM_STR);
        $query->bindParam(":tipoTerminoDeContrato", $item['tipoTerminoDeContrato'], PDO::PARAM_STR);
        $query->bindParam(":contactoParentesco", $item['contactoParentesco'], PDO::PARAM_STR);
        $query->bindParam(":requisitosDeSeleccion", $item['requisitosDeSeleccion'], PDO::PARAM_STR);

        // BindParam para campos de Máquinas (Activos)
        $query->bindParam(":accedeActivos", $item['accedeActivos'], PDO::PARAM_STR);
        $query->bindParam(":informeDocumentoMaquina", $item['informeDocumentoMaquina'], PDO::PARAM_STR);
        $query->bindParam(":deMaquina", $item['deMaquina'], PDO::PARAM_STR);
        $query->bindParam(":claseMaquina", $item['claseMaquina'], PDO::PARAM_STR);
        $query->bindParam(":tipoBus", $item['tipoBus'], PDO::PARAM_STR);
        $query->bindParam(":tipoMaquina", $item['tipoMaquina'], PDO::PARAM_STR);
        $query->bindParam(":tipoDocumentoMaquina", $item['tipoDocumentoMaquina'], PDO::PARAM_STR);
        $query->bindParam(":tipoEquipamientoMaquina", $item['tipoEquipamientoMaquina'], PDO::PARAM_STR);
        $query->bindParam(":tipoPolizaSeguro", $item['tipoPolizaSeguro'], PDO::PARAM_STR);
        $query->bindParam(":marcaChasis", $item['marcaChasis'], PDO::PARAM_STR);
        $query->bindParam(":modeloChasis", $item['modeloChasis'], PDO::PARAM_STR);
        $query->bindParam(":marcaCarroceria", $item['marcaCarroceria'], PDO::PARAM_STR);
        $query->bindParam(":modeloCarroceria", $item['modeloCarroceria'], PDO::PARAM_STR);
        $query->bindParam(":proveedores", $item['proveedores'], PDO::PARAM_STR);
        $query->bindParam(":aseguradora", $item['aseguradora'], PDO::PARAM_STR);

        // BindParam para campos de Contabilidad
        $query->bindParam(":accedeContabilidad", $item['accedeContabilidad'], PDO::PARAM_STR);
        $query->bindParam(":misRendiciones", $item['misRendiciones'], PDO::PARAM_STR);
        $query->bindParam(":gestionarRendiciones", $item['gestionarRendiciones'], PDO::PARAM_STR);
        $query->bindParam(":asignacionFdoRendicion", $item['asignacionFdoRendicion'], PDO::PARAM_STR);
        $query->bindParam(":preAprobacionFdoRendicion", $item['preAprobacionFdoRendicion'], PDO::PARAM_STR);
        $query->bindParam(":aprobacionFdoRendicion", $item['aprobacionFdoRendicion'], PDO::PARAM_STR);
        $query->bindParam(":maestroProveedor", $item['maestroProveedor'], PDO::PARAM_STR);
        $query->bindParam(":condicionPago", $item['condicionPago'], PDO::PARAM_STR);
        $query->bindParam(":tipoProveedor", $item['tipoProveedor'], PDO::PARAM_STR);
        $query->bindParam(":comunaContabilidad", $item['comunaContabilidad'], PDO::PARAM_STR);
        $query->bindParam(":criticidad", $item['criticidad'], PDO::PARAM_STR);
        $query->bindParam(":clientes", $item['clientes'], PDO::PARAM_STR);

        // BindParam para campos de Bodega
        $query->bindParam(":accedeBodegas", $item['accedeBodegas'], PDO::PARAM_STR);
        $query->bindParam(":entregaRepuestoOt", $item['entregaRepuestoOt'], PDO::PARAM_STR);
        $query->bindParam(":entregaProducto", $item['entregaProducto'], PDO::PARAM_STR);
        $query->bindParam(":generarTraspasoBodega", $item['generarTraspasoBodega'], PDO::PARAM_STR);
        $query->bindParam(":solicitarAnulacionEntregaSms", $item['solicitarAnulacionEntregaSms'], PDO::PARAM_STR);
        $query->bindParam(":aprobarSolicitudAnulacionEntregaSms", $item['aprobarSolicitudAnulacionEntregaSms'], PDO::PARAM_STR);
        $query->bindParam(":recepcionOrdenCompra", $item['recepcionOrdenCompra'], PDO::PARAM_STR);
        $query->bindParam(":recepcionTraspaso", $item['recepcionTraspaso'], PDO::PARAM_STR);
        $query->bindParam(":informeInventario", $item['informeInventario'], PDO::PARAM_STR);
        $query->bindParam(":kardexProducto", $item['kardexProducto'], PDO::PARAM_STR);
        $query->bindParam(":ajusteInventario", $item['ajusteInventario'], PDO::PARAM_STR);
        $query->bindParam(":stockBodegaProducto", $item['stockBodegaProducto'], PDO::PARAM_STR);
        $query->bindParam(":quiebreStock", $item['quiebreStock'], PDO::PARAM_STR);
        $query->bindParam(":listaSmsPendiente", $item['listaSmsPendiente'], PDO::PARAM_STR);
        $query->bindParam(":listaRecepcionOc", $item['listaRecepcionOc'], PDO::PARAM_STR);
        $query->bindParam(":listaEntregaSms", $item['listaEntregaSms'], PDO::PARAM_STR);
        $query->bindParam(":consultaAjusteInventario", $item['consultaAjusteInventario'], PDO::PARAM_STR);
        $query->bindParam(":informeEntregaSms", $item['informeEntregaSms'], PDO::PARAM_STR);
        $query->bindParam(":evaluacionProveedor", $item['evaluacionProveedor'], PDO::PARAM_STR);
        $query->bindParam(":maestroProducto", $item['maestroProducto'], PDO::PARAM_STR);
        $query->bindParam(":maestroRepuesto", $item['maestroRepuesto'], PDO::PARAM_STR);
        $query->bindParam(":familiaRepuesto", $item['familiaRepuesto'], PDO::PARAM_STR);
        $query->bindParam(":subfamiliaRepuesto", $item['subfamiliaRepuesto'], PDO::PARAM_STR);
        $query->bindParam(":deMarca", $item['deMarca'], PDO::PARAM_STR);
        $query->bindParam(":deModelo", $item['deModelo'], PDO::PARAM_STR);
        $query->bindParam(":sistemaAplicacion", $item['sistemaAplicacion'], PDO::PARAM_STR);
        $query->bindParam(":unidadMedida", $item['unidadMedida'], PDO::PARAM_STR);
        $query->bindParam(":motivoAjusteInventario", $item['motivoAjusteInventario'], PDO::PARAM_STR);
        $query->bindParam(":tipoDocumentoAjusteInventario", $item['tipoDocumentoAjusteInventario'], PDO::PARAM_STR);
        $query->bindParam(":categoria", $item['categoria'], PDO::PARAM_STR);
        $query->bindParam(":subCategoria", $item['subCategoria'], PDO::PARAM_STR);
        $query->bindParam(":deBodega", $item['deBodega'], PDO::PARAM_STR);

        // BindParam para campos de Compras
        $query->bindParam(":accedeCompras", $item['accedeCompras'], PDO::PARAM_STR);
        $query->bindParam(":generarOc", $item['generarOc'], PDO::PARAM_STR);
        $query->bindParam(":aprobarOc", $item['aprobarOc'], PDO::PARAM_STR);
        $query->bindParam(":generaSms", $item['generaSms'], PDO::PARAM_STR);
        $query->bindParam(":preAprobarSms", $item['preAprobarSms'], PDO::PARAM_STR);
        $query->bindParam(":aprobarSms", $item['aprobarSms'], PDO::PARAM_STR);
        $query->bindParam(":anularSms", $item['anularSms'], PDO::PARAM_STR);
        $query->bindParam(":consultaOrdenCompra", $item['consultaOrdenCompra'], PDO::PARAM_STR);
        $query->bindParam(":ocPendienteRecepcion", $item['ocPendienteRecepcion'], PDO::PARAM_STR);
        $query->bindParam(":consultaListaOc", $item['consultaListaOc'], PDO::PARAM_STR);
        $query->bindParam(":consultaListaDetalleOc", $item['consultaListaDetalleOc'], PDO::PARAM_STR);
        $query->bindParam(":consultaSolicitudMaterialServicio", $item['consultaSolicitudMaterialServicio'], PDO::PARAM_STR);
        $query->bindParam(":consultaListaSms", $item['consultaListaSms'], PDO::PARAM_STR);
        $query->bindParam(":consultaListaDetalleSms", $item['consultaListaDetalleSms'], PDO::PARAM_STR);
        $query->bindParam(":historialOcProveedor", $item['historialOcProveedor'], PDO::PARAM_STR);
        $query->bindParam(":historialOcRepuesto", $item['historialOcRepuesto'], PDO::PARAM_STR);
        $query->bindParam(":plazoOrdenCompra", $item['plazoOrdenCompra'], PDO::PARAM_STR);
        $query->bindParam(":formaPagoOrdenCompra", $item['formaPagoOrdenCompra'], PDO::PARAM_STR);
        $query->bindParam(":plazoEntregaOrdenCompra", $item['plazoEntregaOrdenCompra'], PDO::PARAM_STR);
        $query->bindParam(":tipoSolicitudMaterialServicio", $item['tipoSolicitudMaterialServicio'], PDO::PARAM_STR);
        $query->bindParam(":tipoDocumentoProveedor", $item['tipoDocumentoProveedor'], PDO::PARAM_STR);
        $query->bindParam(":tipoDocumentoCajaChica", $item['tipoDocumentoCajaChica'], PDO::PARAM_STR);

        // BindParam para campos de Mantención
        $query->bindParam(":accedeMantencion", $item['accedeMantencion'], PDO::PARAM_STR);
        $query->bindParam(":reporteFalla", $item['reporteFalla'], PDO::PARAM_STR);
        $query->bindParam(":preventivaOt", $item['preventivaOt'], PDO::PARAM_STR);
        $query->bindParam(":otInterna", $item['otInterna'], PDO::PARAM_STR);
        $query->bindParam(":servicioExternoOt", $item['servicioExternoOt'], PDO::PARAM_STR);
        $query->bindParam(":asignarTareasPendientes", $item['asignarTareasPendientes'], PDO::PARAM_STR);
        $query->bindParam(":editarOt", $item['editarOt'], PDO::PARAM_STR);
        $query->bindParam(":terminarTareaOt", $item['terminarTareaOt'], PDO::PARAM_STR);
        $query->bindParam(":registroKm", $item['registroKm'], PDO::PARAM_STR);
        $query->bindParam(":editarKmMaquina", $item['editarKmMaquina'], PDO::PARAM_STR);
        $query->bindParam(":ordenTrabajo", $item['ordenTrabajo'], PDO::PARAM_STR);
        $query->bindParam(":repuestos", $item['repuestos'], PDO::PARAM_STR);
        $query->bindParam(":listaOts", $item['listaOts'], PDO::PARAM_STR);
        $query->bindParam(":tareasAsignadas", $item['tareasAsignadas'], PDO::PARAM_STR);
        $query->bindParam(":campana", $item['campana'], PDO::PARAM_STR);
        $query->bindParam(":pautaMantencion", $item['pautaMantencion'], PDO::PARAM_STR);
        $query->bindParam(":sistemaMaquina", $item['sistemaMaquina'], PDO::PARAM_STR);
        $query->bindParam(":subsistemaMaquina", $item['subsistemaMaquina'], PDO::PARAM_STR);
        $query->bindParam(":tipoTareaMantencion", $item['tipoTareaMantencion'], PDO::PARAM_STR);
        $query->bindParam(":nivelCriticidad", $item['nivelCriticidad'], PDO::PARAM_STR);
        $query->bindParam(":secuenciaPauta", $item['secuenciaPauta'], PDO::PARAM_STR);
        $query->bindParam(":detencionProgramada", $item['detencionProgramada'], PDO::PARAM_STR);
        $query->bindParam(":modificacionDetencion", $item['modificacionDetencion'], PDO::PARAM_STR);
        $query->bindParam(":categoriaPautaInspeccion", $item['categoriaPautaInspeccion'], PDO::PARAM_STR);
        $query->bindParam(":conductores", $item['conductores'], PDO::PARAM_STR);

        // BindParam para campos de Configuración
        $query->bindParam(":accedeConfiguracion", $item['accedeConfiguracion'], PDO::PARAM_STR);
        $query->bindParam(":roles", $item['roles'], PDO::PARAM_STR);
        $query->bindParam(":usuarios", $item['usuarios'], PDO::PARAM_STR);
        $query->bindParam(":configuracionGeneral", $item['configuracionGeneral'], PDO::PARAM_STR);
        $query->bindParam(":logsSistema", $item['logsSistema'], PDO::PARAM_STR);
        $query->bindParam(":backupRestauracion", $item['backupRestauracion'], PDO::PARAM_STR);

        if($query->execute()){
            return "ok";
        } else {
            return "nok";		
        }
    }

    function obtenerDatosParaModificar($item){
      $query = $this->connect()->prepare("select * from roles where estado = 'activo' and 
      idroles = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
        return $query->fetchAll();
      }else{
        return null;		
      }
    }

    function modificar($item){
        $query = $this->connect()->prepare("UPDATE roles SET 
            descripcionRol = :descripcionRol,

            -- RRHH
            accedeRrhh = :accedeRrhh,
            fichaEmpleado = :fichaEmpleado,
            solicitudContratacion = :solicitudContratacion,
            preAprobacionDeSolicitud = :preAprobacionDeSolicitud,
            aprobacionDeSolicitud = :aprobacionDeSolicitud,
            fichaDeContrato = :fichaDeContrato,
            cargoOrganizacional = :cargoOrganizacional,
            mantenedorAreaDeNegocio = :mantenedorAreaDeNegocio,
            datosLaboralesPorVencer = :datosLaboralesPorVencer,
            solicitudContrPendiente = :solicitudContrPendiente,
            solicitudContratacion2 = :solicitudContratacion2,
            nacionalidad = :nacionalidad,
            comuna = :comuna,
            afp = :afp,
            salud = :salud,
            turnosLaborales = :turnosLaborales,
            empresas = :empresas,
            documento = :documento,
            tipoEpp = :tipoEpp,
            antecedentesMedicos = :antecedentesMedicos,
            cargos = :cargos,
            tipoEquipo = :tipoEquipo,
            tipoAnexo = :tipoAnexo,
            tipoEstudio = :tipoEstudio,
            tipoTerminoDeContrato = :tipoTerminoDeContrato,
            contactoParentesco = :contactoParentesco,
            requisitosDeSeleccion = :requisitosDeSeleccion,

            -- ACTIVOS
            accedeActivos = :accedeActivos,
            informeDocumentoMaquina = :informeDocumentoMaquina,
            deMaquina = :deMaquina,
            claseMaquina = :claseMaquina,
            tipoBus = :tipoBus,
            tipoMaquina = :tipoMaquina,
            tipoDocumentoMaquina = :tipoDocumentoMaquina,
            tipoEquipamientoMaquina = :tipoEquipamientoMaquina,
            tipoPolizaSeguro = :tipoPolizaSeguro,
            marcaChasis = :marcaChasis,
            modeloChasis = :modeloChasis,
            marcaCarroceria = :marcaCarroceria,
            modeloCarroceria = :modeloCarroceria,
            proveedores = :proveedores,
            aseguradora = :aseguradora,

            -- CONTABILIDAD
            accedeContabilidad = :accedeContabilidad,
            misRendiciones = :misRendiciones,
            gestionarRendiciones = :gestionarRendiciones,
            asignacionFdoRendicion = :asignacionFdoRendicion,
            preAprobacionFdoRendicion = :preAprobacionFdoRendicion,
            aprobacionFdoRendicion = :aprobacionFdoRendicion,
            maestroProveedor = :maestroProveedor,
            condicionPago = :condicionPago,
            tipoProveedor = :tipoProveedor,
            comunaContabilidad = :comunaContabilidad,
            criticidad = :criticidad,
            clientes = :clientes,

            -- BODEGA
            accedeBodegas = :accedeBodegas,
            entregaRepuestoOt = :entregaRepuestoOt,
            entregaProducto = :entregaProducto,
            generarTraspasoBodega = :generarTraspasoBodega,
            solicitarAnulacionEntregaSms = :solicitarAnulacionEntregaSms,
            aprobarSolicitudAnulacionEntregaSms = :aprobarSolicitudAnulacionEntregaSms,
            recepcionOrdenCompra = :recepcionOrdenCompra,
            recepcionTraspaso = :recepcionTraspaso,
            informeInventario = :informeInventario,
            kardexProducto = :kardexProducto,
            ajusteInventario = :ajusteInventario,
            stockBodegaProducto = :stockBodegaProducto,
            quiebreStock = :quiebreStock,
            listaSmsPendiente = :listaSmsPendiente,
            listaRecepcionOc = :listaRecepcionOc,
            listaEntregaSms = :listaEntregaSms,
            consultaAjusteInventario = :consultaAjusteInventario,
            informeEntregaSms = :informeEntregaSms,
            evaluacionProveedor = :evaluacionProveedor,
            maestroProducto = :maestroProducto,
            maestroRepuesto = :maestroRepuesto,
            familiaRepuesto = :familiaRepuesto,
            subfamiliaRepuesto = :subfamiliaRepuesto,
            deMarca = :deMarca,
            deModelo = :deModelo,
            sistemaAplicacion = :sistemaAplicacion,
            unidadMedida = :unidadMedida,
            motivoAjusteInventario = :motivoAjusteInventario,
            tipoDocumentoAjusteInventario = :tipoDocumentoAjusteInventario,
            categoria = :categoria,
            subCategoria = :subCategoria,
            deBodega = :deBodega,

            -- COMPRAS
            accedeCompras = :accedeCompras,
            generarOc = :generarOc,
            aprobarOc = :aprobarOc,
            generaSms = :generaSms,
            preAprobarSms = :preAprobarSms,
            aprobarSms = :aprobarSms,
            anularSms = :anularSms,
            consultaOrdenCompra = :consultaOrdenCompra,
            ocPendienteRecepcion = :ocPendienteRecepcion,
            consultaListaOc = :consultaListaOc,
            consultaListaDetalleOc = :consultaListaDetalleOc,
            consultaSolicitudMaterialServicio = :consultaSolicitudMaterialServicio,
            consultaListaSms = :consultaListaSms,
            consultaListaDetalleSms = :consultaListaDetalleSms,
            historialOcProveedor = :historialOcProveedor,
            historialOcRepuesto = :historialOcRepuesto,
            plazoOrdenCompra = :plazoOrdenCompra,
            formaPagoOrdenCompra = :formaPagoOrdenCompra,
            plazoEntregaOrdenCompra = :plazoEntregaOrdenCompra,
            tipoSolicitudMaterialServicio = :tipoSolicitudMaterialServicio,
            tipoDocumentoProveedor = :tipoDocumentoProveedor,
            tipoDocumentoCajaChica = :tipoDocumentoCajaChica,

            -- MANTENCION
            accedeMantencion = :accedeMantencion,
            reporteFalla = :reporteFalla,
            preventivaOt = :preventivaOt,
            otInterna = :otInterna,
            servicioExternoOt = :servicioExternoOt,
            asignarTareasPendientes = :asignarTareasPendientes,
            editarOt = :editarOt,
            terminarTareaOt = :terminarTareaOt,
            registroKm = :registroKm,
            editarKmMaquina = :editarKmMaquina,
            ordenTrabajo = :ordenTrabajo,
            repuestos = :repuestos,
            listaOts = :listaOts,
            tareasAsignadas = :tareasAsignadas,
            campana = :campana,
            pautaMantencion = :pautaMantencion,
            sistemaMaquina = :sistemaMaquina,
            subsistemaMaquina = :subsistemaMaquina,
            tipoTareaMantencion = :tipoTareaMantencion,
            nivelCriticidad = :nivelCriticidad,
            secuenciaPauta = :secuenciaPauta,
            detencionProgramada = :detencionProgramada,
            modificacionDetencion = :modificacionDetencion,
            categoriaPautaInspeccion = :categoriaPautaInspeccion,
            conductores = :conductores,

            -- CONFIGURACION
            accedeConfiguracion = :accedeConfiguracion,
            roles = :roles,
            usuarios = :usuarios,
            configuracionGeneral = :configuracionGeneral,
            logsSistema = :logsSistema,
            backupRestauracion = :backupRestauracion
        WHERE idroles = :id AND estado = 'activo'");

        foreach ($item as $key => $value) {
            if($key != 'id'){
                $query->bindValue(":$key", $value);
            }
        }
        $query->bindValue(":id", $item['id'], PDO::PARAM_INT);
                
        if($query->execute()){
            return "ok";
        }else{
            return "nok";		
        }
    }

    function eliminar($item){
      $query = $this->connect()->prepare("update roles set estado = 'inactivo' where idroles = :id");
      $query->bindParam(":id", $item['id'], PDO::PARAM_STR);
      if($query->execute()){
          return "ok";
        }else{
          return "nok";		
        }
    }


       
}



?>