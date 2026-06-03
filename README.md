# Portal del Estudiante - Módulo de Justificativos de Inasistencia

Este proyecto es una migración dinámica del Portal Estudiante (originalmente estático) a un entorno basado en **PHP 8** y **MySQL/MariaDB**, listo para ser ejecutado bajo XAMPP.

## Características Clave
* **Autenticación Segura**: Sistema de login conectado a base de datos con contraseñas encriptadas usando `bcrypt`. Mapea dinámicamente la cabecera del portal con el nombre de usuario y carrera.
* **Calendario Dinámico e Interactivo**: Carga del mes/año actual en tiempo real con controles para navegar entre meses. Permite seleccionar fechas y registrar inasistencias a asignaturas específicas.
* **Gestión de Archivos**: Filtro interactivo en el explorador para aceptar únicamente archivos PDF e imágenes tomadas desde el celular (`.jpg`, `.jpeg`, `.png`, `.heic`, `.heif`, `.webp`).
* **Simplificación de Estados**: Estados normalizados para el flujo del trámite: `Pendiente`, `Aprobado` y `Rechazado`.
* **Historial Dinámico ("Mis Trámites")**: Consulta en la base de datos que lista las solicitudes del alumno autenticado y muestra sus ramos/días afectados de forma organizada.

---

## Requisitos de Instalación (Local XAMPP)

### 1. Ubicación del Proyecto
Descarga o clona este repositorio en el directorio `htdocs` de tu servidor XAMPP:
* **Linux**: `/opt/lampp/htdocs/proyectos_php/portal estudiante`
* **Windows**: `C:\xampp\htdocs\proyectos_php\portal estudiante`

### 2. Configurar Base de Datos
1. Inicia los servicios de Apache y MySQL en el Panel de Control de XAMPP.
2. Abre phpMyAdmin (`http://localhost/phpmyadmin`) o tu terminal de MySQL.
3. Importa el archivo `database.sql` incluido en la raíz de este proyecto para crear la base de datos `portal_estudiante` y las tablas necesarias.
   ```bash
   mysql -u root < database.sql
   ```

### 3. Permisos de Archivos (Solo Linux)
Para permitir que Apache pueda almacenar los certificados adjuntados en las solicitudes de justificación, otorga permisos de escritura a la carpeta `uploads`:
```bash
chmod 777 uploads
```

---

## Credenciales de Acceso
El script de base de datos (`database.sql`) inserta automáticamente una cuenta de prueba para verificar el funcionamiento:
* **Correo**: `estudiante@alu.uct.cl`
* **Contraseña**: `ClavePrueba123`

---

## Estructura del Código
* `index.php`: Pantalla de inicio de sesión segura y procesamiento POST.
* `index2.php`: Panel principal del estudiante una vez autenticado, controla las sesiones de usuario y carga dinámicamente las subsecciones.
* `conexion.php`: Módulo central de conexión PDO a MySQL.
* `get_justificativos.php`: Módulo que renderiza el calendario dinámico, el formulario y la lista de trámites del estudiante.
* `guardar_justificativo.php`: Endpoint para procesar la subida del documento físico y realizar las inserciones SQL correspondientes dentro de una transacción.
* `cambiar_contrasena.php`: Endpoint para que el estudiante pueda actualizar su clave.
* `get_mock_section.php`: Enrutador para desplegar el resto de pestañas e interfaces estáticas del portal antiguo.
