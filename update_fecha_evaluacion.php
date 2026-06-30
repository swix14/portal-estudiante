<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once 'conexion.php';

// Verificar sesión de profesor
if (!isset($_SESSION['profesor_logged_in']) || $_SESSION['profesor_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado. Inicie sesión como docente.']);
    exit();
}

$detalle_id = isset($_POST['detalle_id']) ? intval($_POST['detalle_id']) : 0;
$nueva_fecha = isset($_POST['nueva_fecha']) ? trim($_POST['nueva_fecha']) : '';
$comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : '';

if ($detalle_id <= 0 || empty($nueva_fecha)) {
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros obligatorios (ID de detalle y nueva fecha).']);
    exit();
}

// Validar formato de fecha
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $nueva_fecha)) {
    echo json_encode(['success' => false, 'message' => 'Formato de fecha inválido (debe ser AAAA-MM-DD).']);
    exit();
}

try {
    $stmt = $pdo->prepare("
        UPDATE justificativo_detalles 
        SET nueva_fecha_evaluacion = :fecha, 
            estado_docente = 'Reprogramado', 
            comentario_docente = :comentario 
        WHERE id = :id
    ");
    $result = $stmt->execute([
        ':fecha' => $nueva_fecha,
        ':comentario' => $comentario,
        ':id' => $detalle_id
    ]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Evaluación reprogramada con éxito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo reprogramar la evaluación.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
}
?>
