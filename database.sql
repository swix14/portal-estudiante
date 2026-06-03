CREATE DATABASE IF NOT EXISTS portal_estudiante DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE portal_estudiante;

-- estudiantes
CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rut VARCHAR(12) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    carrera VARCHAR(100) NOT NULL,
    celular VARCHAR(20),
    direccion VARCHAR(150)
) ENGINE=InnoDB;

-- justificativos
CREATE TABLE IF NOT EXISTS justificativos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_tramite VARCHAR(20) NOT NULL UNIQUE,
    estudiante_id INT NOT NULL,
    fecha_envio DATE NOT NULL,
    documento VARCHAR(100),
    estado VARCHAR(30) NOT NULL DEFAULT 'Pendiente',
    comentarios TEXT,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- dias justificativo
CREATE TABLE IF NOT EXISTS justificativo_detalles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    justificativo_id INT NOT NULL,
    fecha DATE NOT NULL,
    curso VARCHAR(150) NOT NULL,
    FOREIGN KEY (justificativo_id) REFERENCES justificativos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ingresa usuario
-- clave: ClavePrueba123
INSERT INTO estudiantes (rut, nombre, email, password, carrera, celular, direccion)
VALUES (
    '20.123.456-7',
    'ESTUDIANTE PRUEBA',
    'estudiante@alu.uct.cl',
    '$2y$10$z/99xnQnl1ZA9JndFUwNOePgo/98rbdIZRVMErUMUaSN64jnrGjVy',
    'INGENIERÍA CIVIL EN INFORMÁTICA',
    '+56 9 1234 5678',
    'Avenida Alemania 0122, Temuco'
) ON DUPLICATE KEY UPDATE email=email;

-- id estudiante
-- tramite 1
SET @estudiante_id = (SELECT id FROM estudiantes WHERE email = 'estudiante@alu.uct.cl' LIMIT 1);

-- tramite 1
INSERT INTO justificativos (codigo_tramite, estudiante_id, fecha_envio, documento, estado, comentarios)
VALUES (
    'TR-1024',
    @estudiante_id,
    '2026-04-12',
    'certificado_dental.pdf',
    'Aprobado',
    'Aprobado. Se justifica inasistencia a clases.'
) ON DUPLICATE KEY UPDATE codigo_tramite=codigo_tramite;

SET @just_1_id = (SELECT id FROM justificativos WHERE codigo_tramite = 'TR-1024' LIMIT 1);

INSERT INTO justificativo_detalles (justificativo_id, fecha, curso)
VALUES (
    @just_1_id,
    '2026-04-10',
    'INF-1101 PROGRAMACIÓN ORIENTADA A OBJETOS'
) ON DUPLICATE KEY UPDATE id=id;

-- tramite 2
INSERT INTO justificativos (codigo_tramite, estudiante_id, fecha_envio, documento, estado, comentarios)
VALUES (
    'TR-1055',
    @estudiante_id,
    '2026-05-05',
    'licencia_medica_gripe.pdf',
    'Pendiente',
    'En proceso de validación con Jefatura de Carrera.'
) ON DUPLICATE KEY UPDATE codigo_tramite=codigo_tramite;

SET @just_2_id = (SELECT id FROM justificativos WHERE codigo_tramite = 'TR-1055' LIMIT 1);

INSERT INTO justificativo_detalles (justificativo_id, fecha, curso)
VALUES 
(
    @just_2_id,
    '2026-05-02',
    'MAT-1102 ÁLGEBRA LINEAL'
),
(
    @just_2_id,
    '2026-05-03',
    'MAT-1102 ÁLGEBRA LINEAL'
) ON DUPLICATE KEY UPDATE id=id;
