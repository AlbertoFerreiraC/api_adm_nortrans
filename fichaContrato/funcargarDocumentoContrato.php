<?php
    include_once 'controlador.php';
    $api = new ApiControlador();
    if ( empty($_FILES['documento']['tmp_name']) != 1) {
        $tipo = $_FILES['documento']['type'];
        $extension = "";
        if($tipo == "image/jpeg"){ $extension = ".jpeg"; }
        if($tipo == "image/png"){ $extension = ".png"; }
        if($tipo == "text/plain"){ $extension = ".txt"; }        
        if($tipo == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"){ $extension = ".xlsx"; }
        if($tipo == "application/vnd.ms-excel"){ $extension = ".xls"; }
        if($tipo == "text/csv"){ $extension = ".csv"; }
        if($tipo == "application/pdf"){ $extension = ".pdf"; }
        if($tipo == "application/msword"){ $extension = ".doc"; }
        if($tipo == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"){ $extension = ".docx"; }
        if($extension != ""){
            $archivo =  file_get_contents($_FILES['documento']['tmp_name']);
            $filename = $_POST['id']."_contrato".$extension; 
            $bytes = file_put_contents('../../adm-nortrans/vistas/img/contrato/'.$filename, $archivo);
            $item = array(
                'id' => $_POST['id'],
                'extension' => $extension
            );
            $api -> actualizarDocumentoContratoApi($item);
        }else{
            echo json_encode(array('mensaje' => "invalido"));
        }
    }else{
        echo json_encode(array('mensaje' => "vacio"));
    }
    
?>