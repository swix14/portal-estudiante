<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once 'conexion.php';

// Verificar que el jefe de carrera esté logueado
if (!isset($_SESSION['jefe_logged_in']) || $_SESSION['jefe_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado. Sesión no válida.']);
    exit();
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';
$comentarios = isset($_POST['comentarios']) ? trim($_POST['comentarios']) : '';

if ($id <= 0 || empty($estado)) {
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros obligatorios.']);
    exit();
}

// Validar estados permitidos
$estados_validos = ['Pendiente', 'Aprobado', 'Rechazado'];
if (!in_array($estado, $estados_validos)) {
    echo json_encode(['success' => false, 'message' => 'El estado especificado no es válido.']);
    exit();
}

try {
    $stmt = $pdo->prepare("
        UPDATE justificativos 
        SET estado = :estado, comentarios = :comentarios 
        WHERE id = :id
    ");
    $result = $stmt->execute([
        ':estado' => $estado,
        ':comentarios' => $comentarios,
        ':id' => $id
    ]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Justificativo actualizado con éxito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el justificativo.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
}
?>
