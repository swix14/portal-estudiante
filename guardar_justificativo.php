<?php
session_start();
header('Content-Type: application/json');
require_once 'conexion.php';

if (!isset($_SESSION['student_id'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no iniciada.']);
    exit();
}

$student_id = $_SESSION['student_id'];
$motivo = trim($_POST['motivo'] ?? '');
$selected_days_json = $_POST['selected_days'] ?? '';

if (empty($selected_days_json)) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos (días seleccionados).']);
    exit();
}

$selected_days = json_encode(array()); // Inicialización por si acaso
try {
    $selected_days = json_decode($selected_days_json, true);
    if (!is_array($selected_days) || empty($selected_days)) {
        echo json_encode(['success' => false, 'message' => 'El formato de días seleccionados es inválido o está vacío.']);
        exit();
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al decodificar los días seleccionados: ' . $e->getMessage()]);
    exit();
}

// Gestionar subida de archivo
$documento_nombre = 'documento.pdf'; // Valor por defecto
if (isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['documento']['tmp_name'];
    $fileName = $_FILES['documento']['name'];
    $fileSize = $_FILES['documento']['size'];
    $fileType = $_FILES['documento']['type'];
    
    // Limpiar el nombre de archivo
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    
    $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'heic', 'heif', 'webp'];
    if (in_array($fileExtension, $allowedExtensions)) {
        // Crear carpeta uploads si no existe
        $uploadFileDir = './uploads/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }
        
        // Generar un nombre único para evitar colisiones
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;
        
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            $documento_nombre = $newFileName;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al mover el archivo subido al directorio de destino.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Extensión de archivo no permitida. Solo PDF, JPG, JPEG, PNG.']);
        exit();
    }
}

try {
    $pdo->beginTransaction();
    
    // Generar código de trámite único
    $codigo_tramite = "";
    $es_unico = false;
    while (!$es_unico) {
        $num_rnd = rand(1000, 9999);
        $codigo_tramite = "TR-" . $num_rnd;
        
        $chk = $pdo->prepare("SELECT id FROM justificativos WHERE codigo_tramite = :codigo");
        $chk->execute([':codigo' => $codigo_tramite]);
        if (!$chk->fetch()) {
            $es_unico = true;
        }
    }
    
    // Insertar el justificativo principal
    $stmt = $pdo->prepare("
        INSERT INTO justificativos (codigo_tramite, estudiante_id, fecha_envio, documento, estado, comentarios)
        VALUES (:codigo, :estudiante_id, :fecha_envio, :documento, 'Pendiente', :comentarios)
    ");
    
    $fecha_actual = date('Y-m-d');
    $stmt->execute([
        ':codigo' => $codigo_tramite,
        ':estudiante_id' => $student_id,
        ':fecha_envio' => $fecha_actual,
        ':documento' => $documento_nombre,
        ':comentarios' => $motivo
    ]);
    
    $justificativo_id = $pdo->lastInsertId();
    
    // Insertar los detalles por día y ramos
    $stmt_det = $pdo->prepare("
        INSERT INTO justificativo_detalles (justificativo_id, fecha, curso)
        VALUES (:just_id, :fecha, :curso)
    ");
    
    foreach ($selected_days as $fecha_str => $cursos) {
        // Convertir fecha de d/m/Y a Y-m-d
        $date_parts = explode('/', $fecha_str);
        if (count($date_parts) === 3) {
            // Asegurar ceros a la izquierda
            $day = str_pad($date_parts[0], 2, '0', STR_PAD_LEFT);
            $month = str_pad($date_parts[1], 2, '0', STR_PAD_LEFT);
            $year = $date_parts[2];
            $mysql_date = "$year-$month-$day";
            
            foreach ($cursos as $curso) {
                $stmt_det->execute([
                    ':just_id' => $justificativo_id,
                    ':fecha' => $mysql_date,
                    ':curso' => $curso
                ]);
            }
        }
    }
    
    $pdo->commit();
    echo json_encode([
        'success' => true,
        'codigo_tramite' => $codigo_tramite
    ]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode([
        'success' => false,
        'message' => 'Error al registrar en la base de datos: ' . $e->getMessage()
    ]);
}
?>
