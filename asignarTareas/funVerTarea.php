<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../db.php';

try {
    // 🧩 Validar parámetro
    if (!isset($_POST['idTarea']) || empty($_POST['idTarea'])) {
        echo json_encode(['status' => 'error', 'message' => 'Falta el ID de la tarea.']);
        exit;
    }

    $idTarea = intval($_POST['idTarea']);

    // 🧩 Conexión con la base de datos
    $db = new DB();
    $pdo = $db->connect();

    // =======================================================
    // 📋 CABECERA + DETALLE (JOIN entre tareas_ot y ot_interna)
    // =======================================================
    $sql = "
        SELECT 
            t.idtareas_ot,
            t.fecha,
            t.ot_interna,
            t.personal_tecnico,
            t.tipo_tarea_mantencion,
            t.sistema_maquina,
            t.sub_sistema_maquina,
            t.observacion,
            t.estado,
            o.idot_interna,
            o.usuario,
            o.maquina,
            o.centro_de_costo,
            o.km_actual,
            o.fecha AS fecha_ot
        FROM tareas_ot t
        INNER JOIN ot_interna o ON o.idot_interna = t.ot_interna
        WHERE t.idtareas_ot = :idTarea
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idTarea', $idTarea, PDO::PARAM_INT);
    $stmt->execute();

    $tarea = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tarea) {
        echo json_encode(['status' => 'no_data', 'message' => 'No se encontraron datos para esta tarea.']);
        exit;
    }

    // =======================================================
    // 👷 LISTA DE TÉCNICOS DISPONIBLES (personal_tecnico)
    // =======================================================
    $sqlTecnicos = "
        SELECT 
            idpersonal_tecnico AS id, 
            nombre 
        FROM personal_tecnico 
        WHERE estado = 'activo'
        ORDER BY nombre ASC
    ";

    $stmtTec = $pdo->prepare($sqlTecnicos);
    $stmtTec->execute();
    $tecnicos = $stmtTec->fetchAll(PDO::FETCH_ASSOC);

    // Agregar técnicos al array principal
    $tarea['tecnicos'] = $tecnicos;

    // =======================================================
    // 📤 RESPUESTA JSON
    // =======================================================
    echo json_encode([
        'status' => 'ok',
        'data' => $tarea
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error general: ' . $e->getMessage()
    ]);
}
