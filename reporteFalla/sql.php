<?php
include_once '../db.php';

class Sql extends DB
{
  public function listarReportes()
  {
    try {
      file_put_contents('debug_reporte_sql.log', "\n===> Entrando a listarReportes()\n", FILE_APPEND);
      $query = $this->connect()->prepare("
      SELECT 
          rf.idreporte_falla,
          rf.usuario,
          rf.dependencia,
          dm.descripcion AS maquina,
          c.nombre AS conductor,
          rf.km_reportado,
          rf.fecha,
          rf.estado
      FROM reporte_falla rf
      LEFT JOIN maquina dm ON rf.maquina = dm.idmaquina
      LEFT JOIN conductor c ON rf.conductor = c.idconductor
      WHERE rf.estado = 'activo'
      ORDER BY rf.fecha DESC
    ");
      $query->execute();
      file_put_contents('debug_reporte_sql.log', "✅ Consulta listarReportes ejecutada correctamente\n", FILE_APPEND);
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      file_put_contents('debug_reporte_sql.log', "❌ Error listarReportes: " . $e->getMessage() . "\n", FILE_APPEND);
      return null;
    }
  }

  /* =======================================================
       AGREGAR CABECERA
    ======================================================= */
  public function agregarCabecera($item)
  {
    try {
      file_put_contents('debug_reporte_sql.log', "\n===> Entrando a agregarCabecera()\nDatos recibidos:\n" . json_encode($item) . "\n", FILE_APPEND);

      $conexion = $this->connect();
      $query = $conexion->prepare("
        INSERT INTO reporte_falla 
        (usuario, dependencia, maquina, conductor, km_reportado, fecha, estado)
        VALUES 
        (:usuario, :dependencia, :maquina, :conductor, :km_reportado, :fecha, :estado)
      ");
      $query->bindParam(":usuario", $item['usuario'], PDO::PARAM_INT);
      $query->bindParam(":dependencia", $item['dependencia'], PDO::PARAM_INT);
      $query->bindParam(":maquina", $item['maquina'], PDO::PARAM_INT);
      $query->bindParam(":conductor", $item['conductor'], PDO::PARAM_INT);
      $query->bindParam(":km_reportado", $item['km_reportado'], PDO::PARAM_STR);
      $query->bindParam(":fecha", $item['fecha'], PDO::PARAM_STR);
      $query->bindParam(":estado", $item['estado'], PDO::PARAM_STR);
      $query->execute();

      $lastId = $conexion->lastInsertId();
      file_put_contents('debug_reporte_sql.log', "✅ CABECERA insertada correctamente. ID generado: {$lastId}\n", FILE_APPEND);

      return $lastId;
    } catch (Exception $e) {
      file_put_contents('debug_reporte_error.log', "❌ Error agregarCabecera: " . $e->getMessage() . "\n", FILE_APPEND);
      return 0;
    }
  }

  /* =======================================================
       AGREGAR DETALLE
    ======================================================= */
  public function agregarDetalle($item)
  {
    try {
      file_put_contents('debug_detalle_sql.log', "\n===> Entrando a agregarDetalle()\n", FILE_APPEND);

      $conexion = $this->connect();
      $query = $conexion->prepare("
      INSERT INTO detalle_reporte_falla
      (reporte_falla, sistema_maquina, sub_sistema_maquina, observacion)
      VALUES 
      (:reporte_falla, :sistema_maquina, :sub_sistema_maquina, :observacion)
    ");

      $query->bindParam(":reporte_falla", $item['reporte_falla'], PDO::PARAM_INT);
      $query->bindParam(":sistema_maquina", $item['sistema_maquina'], PDO::PARAM_INT);

      if (empty($item['sub_sistema_maquina'])) {
        $query->bindValue(":sub_sistema_maquina", null, PDO::PARAM_NULL);
      } else {
        $query->bindParam(":sub_sistema_maquina", $item['sub_sistema_maquina'], PDO::PARAM_INT);
      }

      $query->bindParam(":observacion", $item['observacion'], PDO::PARAM_STR);

      file_put_contents('debug_detalle_sql.log', "📝 Ejecutando INSERT con datos:\n" . json_encode($item) . "\n", FILE_APPEND);
      $query->execute();

      file_put_contents('debug_detalle_sql.log', "✅ DETALLE insertado correctamente\n", FILE_APPEND);
      return "ok";
    } catch (Exception $e) {
      file_put_contents('debug_detalle_error.log', "❌ Error agregarDetalle: " . $e->getMessage() . "\n", FILE_APPEND);
      return "nok";
    }
  }

  /* =======================================================
       ELIMINAR REPORTE Y SUS DETALLES
    ======================================================= */
  public function eliminar($item)
  {
    try {
      file_put_contents('debug_reporte_sql.log', "\n===> Entrando a eliminar()\nDatos recibidos:\n" . json_encode($item) . "\n", FILE_APPEND);

      $id = $item['id'];
      $conexion = $this->connect();

      $conexion->prepare("DELETE FROM detalle_reporte_falla WHERE reporte_falla = :id")
        ->execute([':id' => $id]);
      file_put_contents('debug_reporte_sql.log', "🗑️ Detalles eliminados del reporte ID: {$id}\n", FILE_APPEND);

      $conexion->prepare("DELETE FROM reporte_falla WHERE idreporte_falla = :id")
        ->execute([':id' => $id]);
      file_put_contents('debug_reporte_sql.log', "🗑️ Cabecera de reporte eliminada ID: {$id}\n", FILE_APPEND);

      return "ok";
    } catch (Exception $e) {
      file_put_contents('debug_reporte_error.log', "❌ Error eliminar reporte: " . $e->getMessage() . "\n", FILE_APPEND);
      return "nok";
    }
  }
}
