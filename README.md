# Portal del Estudiante - Módulo de Justificativos de Inasistencia (UCT)

Este proyecto es una migración dinámica del Portal Estudiante UCT a un entorno interactivo basado en **PHP 8** y **MySQL/MariaDB**, listo para ser ejecutado bajo XAMPP.

---

## Flujo de Trabajo Completo

El sistema implementa un flujo de justificaciones y reprogramaciones académicas que involucra a tres roles:

```
[ Estudiante ] ----(Sube Certificado y Ramos)----> [ Jefe de Carrera ]
                                                           |
                                                       (Aprueba)
                                                           |
                                                           v
[ Estudiante ] <---(Ve fecha de prueba)--- [ Profesor de Asignatura ]
```

1.  **Estudiante**: Solicita una justificación subiendo un certificado médico o de respaldo e indicando las fechas y ramos específicos que se ausentó. El trámite queda en estado `Pendiente`.
2.  **Jefe de Carrera**: Revisa la solicitud en su bandeja de entrada. Valida el documento adjunto y, si está conforme, cambia el estado a `Aprobado`.
3.  **Profesor**: Tras la aprobación del jefe, el sistema deriva los ramos afectados a la bandeja de cada profesor. El profesor ingresa, selecciona su materia dictada, y agenda la nueva fecha de evaluación recuperativa con indicaciones.
4.  **Estudiante**: Puede entrar a su panel histórico ("Mis Trámites") y revisar de forma desglosada qué profesor ya reprogramó su evaluación, la fecha asignada y el aula o condiciones definidas.

---

## Características Clave
*   **Autenticación Base de Datos (BCRYPT)**: Todos los accesos se validan de forma segura contra la base de datos utilizando hashes `bcrypt`.
*   **Diseño Institucional UCT**: Tanto la pantalla de login como los dashboards de alumno, director y profesor emulan fielmente el diseño y estilo del portal institucional de la Universidad Católica de Temuco.
*   **Bandejas Especializadas**: Filtros interactivos de búsqueda y navegación para jefes y profesores.
*   **Carga de Ramos Dinámicos**: Los profesores solo visualizan las asignaturas que tienen asociadas contractualmente en la base de datos.
*   **Previsualización de Respaldos**: El Jefe y los profesores pueden previsualizar imágenes o abrir PDFs adjuntos en las solicitudes directamente desde sus paneles.

---

## Requisitos de Instalación (Local XAMPP)

### 1. Ubicación del Proyecto
Descarga o clona este repositorio en el directorio `htdocs` de tu servidor XAMPP:
*   **Windows**: `C:\xampp\htdocs\portal-estudiante`
*   **Linux**: `/opt/lampp/htdocs/portal-estudiante`

### 2. Configurar Base de Datos
1.  Inicia los servicios de Apache y MySQL en el Panel de Control de XAMPP.
2.  Abre phpMyAdmin (`http://localhost/phpmyadmin`) o tu cliente MySQL.
3.  Importa el archivo `database.sql` incluido en la raíz de este proyecto para crear la base de datos `portal_estudiante` y todas las tablas necesarias con datos de prueba:
    ```bash
    mysql -u root < database.sql
    ```

---

## Credenciales de Acceso para Pruebas

El script de base de datos (`database.sql`) inserta automáticamente las siguientes cuentas con contraseñas encriptadas:

| Rol | Correo / Usuario | Contraseña | Detalle / Ramo |
| :--- | :--- | :--- | :--- |
| **Estudiante** | `estudiante@alu.uct.cl` | `ClavePrueba123` | Alumno de prueba con ramos inscritos |
| **Jefe de Carrera** | `jefe@uct.cl` | `JefeCarrera123` | Dr. Roberto Muñoz (Director de Carrera) |
| **Profesor** | `profesor@uct.cl` | `ProfesorUct123` | Profesor asignado a *Álgebra Lineal* y *Programación* |

---

## Estructura del Código

*   `index.php`: Login unificado para estudiantes, con enlaces en el pie para acceder a los portales de Jefatura y Profesores.
*   `index2.php`: Portal principal y menú del estudiante tras loguearse.
*   `conexion.php`: Módulo central de conexión PDO a MySQL.
*   `get_justificativos.php`: Módulo que renderiza el formulario con calendario interactivo y el historial de trámites del estudiante con la tabla detallada de reprogramaciones.
*   `guardar_justificativo.php`: Módulo backend que procesa la subida de los certificados en la carpeta `uploads/` y realiza las inserciones SQL.
*   `jefe_carrera.php`: Dashboard institucional del Jefe de Carrera con estadísticas, filtros y modal para resolver las solicitudes de justificativos.
*   `update_justificativo.php`: Endpoint para procesar la resolución de aprobación o rechazo del Jefe de Carrera.
*   `profesor.php`: Panel institucional de los profesores para seleccionar asignaturas dictadas y programar las fechas de las evaluaciones recuperativas.
*   `update_fecha_evaluacion.php`: Endpoint para guardar el agendamiento y los comentarios dictados por el profesor para una inasistencia.
*   `uploads/`: Carpeta donde se almacenan los archivos adjuntos subidos por los alumnos (PDFs e imágenes).
