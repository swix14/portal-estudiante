<?php
session_start();
header('Content-Type: application/json');
require_once 'conexion.php';

if (!isset($_SESSION['student_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada.']);
    exit();
}

$student_id = $_SESSION['student_id'];
$pass_actual = $_POST['pass_actual'] ?? '';
$pass_nueva = $_POST['pass_nueva'] ?? '';

if (empty($pass_actual) || empty($pass_nueva)) {
    echo json_encode(['success' => false, 'message' => 'Por favor complete todos los campos.']);
    exit();
}

try {
    // Obtener contraseña actual del estudiante
    $stmt = $pdo->prepare("SELECT password FROM estudiantes WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $student_id]);
    $student = $stmt->fetch();

    if ($student && password_verify($pass_actual, $student['password'])) {
        // Encriptar la nueva contraseña
        $new_hash = password_hash($pass_nueva, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos
        $update = $pdo->prepare("UPDATE estudiantes SET password = :password WHERE id = :id");
        $update->execute([
            ':password' => $new_hash,
            ':id' => $student_id
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Contraseña modificada con éxito. Redirigiendo para iniciar sesión nuevamente...'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'La contraseña actual ingresada es incorrecta.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
}
?>
