<?php
session_start();
require_once 'conexion.php';

// Cerrar sesión
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['profesor_logged_in']);
    unset($_SESSION['profesor_name']);
    header("Location: profesor.php");
    exit();
}

$login_error = "";

// Procesar login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profesor_login'])) {
    $email = trim($_POST['correo'] ?? '');
    $pass = $_POST['pass'] ?? '';

    if (!empty($email) && !empty($pass)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM profesores WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $profe = $stmt->fetch();

            if ($profe && password_verify($pass, $profe['password'])) {
                $_SESSION['profesor_logged_in'] = true;
                $_SESSION['profesor_id'] = $profe['id'];
                $_SESSION['profesor_name'] = $profe['nombre'];
                header("Location: profesor.php");
                exit();
            }
        } catch (PDOException $e) {
            $login_error = "Error de base de datos: " . $e->getMessage();
        }
    }
    if (empty($login_error)) {
        $login_error = "El correo o la contraseña son incorrectos.";
    }
}

// Obtener ramos disponibles
$cursos_disponibles = [];
if (isset($_SESSION['profesor_logged_in']) && $_SESSION['profesor_logged_in'] === true) {
    try {
        $stmt = $pdo->prepare("SELECT curso FROM profesor_cursos WHERE profesor_id = :p_id ORDER BY curso ASC");
        $stmt->execute([':p_id' => $_SESSION['profesor_id']]);
        $cursos_disponibles = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        die("Error al consultar cursos asignados: " . $e->getMessage());
    }
}

$curso_seleccionado = isset($_GET['curso']) ? trim($_GET['curso']) : '';

// Obtener inasistencias aprobadas para el ramo seleccionado
$inasistencias = [];
if (isset($_SESSION['profesor_logged_in']) && $_SESSION['profesor_logged_in'] === true && !empty($curso_seleccionado)) {
    try {
        $stmt = $pdo->prepare("
            SELECT d.id as detalle_id, d.fecha as fecha_inasistencia, d.nueva_fecha_evaluacion, d.estado_docente, d.comentario_docente,
                   j.codigo_tramite, j.fecha_envio, j.documento, j.comentarios as comentario_estudiante,
                   e.nombre as est_nombre, e.rut as est_rut, e.email as est_email
            FROM justificativo_detalles d
            JOIN justificativos j ON d.justificativo_id = j.id
            JOIN estudiantes e ON j.estudiante_id = e.id
            WHERE j.estado = 'Aprobado' AND d.curso = :curso
            ORDER BY d.fecha DESC, j.id DESC
        ");
        $stmt->execute([':curso' => $curso_seleccionado]);
        $inasistencias = $stmt->fetchAll();
    } catch (PDOException $e) {
        die("Error al consultar inasistencias: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="Dircom" />
    
    <!-- Stylesheets -->
    <link href="css/google_fonts.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" media="only screen and (-webkit-min-device-pixel-ratio: 2)" type="text/css" href="css/retina.css" />
    <link rel="stylesheet" href="css/colors.css" type="text/css" />
    <link rel="stylesheet" href="css/tipsy.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="css/font-awesome.css" type="text/css" />
    <link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" />
    <link rel="stylesheet" href="css/responsive.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    
    <!-- External JavaScripts -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/plugins.js"></script>
    <script type="text/javascript" src="js/movSociales.js"></script>
    <link rel="stylesheet" href="nav-responsive.css" type="text/css" />
    
    <?php if (isset($_SESSION['profesor_logged_in'])): ?>
        <link rel="stylesheet" type="text/css" href="css/nav_vertical.css" />
    <?php endif; ?>

    <title>Portal Profesores - Universidad Católica de Temuco</title>

    <script type="text/javascript">
        function asignar() {
            var x = document.getElementById("correo");
            if (x) x.value = x.value.toUpperCase();
        }
    </script>
    
    <style>
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }
        .badge-pendiente {
            background-color: #f0ad4e;
        }
        .badge-reprogramado {
            background-color: #5cb85c;
        }

        #panelDer {
            float: none !important;
            width: 100% !important;
            margin-top: 0 !important;
            margin-left: 0 !important;
            box-sizing: border-box;
            background: white;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        @media only screen and (max-width: 767px) {
            #header {
                background: #01568e url(images/bg-header2.png) no-repeat center center !important;
                background-size: contain !important;
                height: 0 !important;
                padding-bottom: 12.745% !important;
                width: 100% !important;
            }
            #wrapper {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                border: none !important;
                box-sizing: border-box !important;
            }
            .container {
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                padding-left: 10px !important;
                padding-right: 10px !important;
            }
            #content {
                width: 100% !important;
                box-sizing: border-box !important;
                padding: 10px !important;
            }
            #fondo {
                background: none !important;
                height: auto !important;
            }
            #derecha {
                width: 100% !important;
                float: none !important;
                margin: 0 0 20px 0 !important;
            }
            #izquierda {
                width: 100% !important;
                float: none !important;
                margin: 0 !important;
            }
            #containers {
                width: 100% !important;
                position: static !important;
                margin: 0 auto !important;
                box-sizing: border-box !important;
                height: auto !important;
                padding: 15px !important;
            }
            #hongkiat-form .txtinput {
                width: 100% !important;
                box-sizing: border-box !important;
                margin-bottom: 12px !important;
                font-size: 1.1em !important;
                height: auto !important;
                padding: 8px 15px 8px 45px !important;
            }
            #aligned {
                width: 100% !important;
                float: none !important;
                margin: 0 !important;
            }
            #buttons {
                width: 100% !important;
                margin: 10px 0 0 0 !important;
            }
            #submitbtn {
                width: 100% !important;
                height: 40px !important;
                font-size: 1.2em !important;
            }
        }
    </style>
    
    <script>
        $(function() {
            var enlace_movil = $('#nav-responsive'),
                menu = $('#responsive-menu').find('ul');
            enlace_movil.on('click', function(e) {
                e.preventDefault();
                var esto = $(this);
                esto.toggleClass('nav-active');
                menu.toggleClass('open-responsive-menu');
            });
        });
    </script>
</head>
<body>

    <!-- MENÚ MÓVIL SUPERIOR -->
    <nav id="responsive-menu">
        <a class="nav-responsive" id="nav-responsive" href="#"></a>
        <ul>
            <li><a href="http://www.uct.cl/i.php" TARGET="_blank">Ir a UCTEMUCO.CL</a></li>
            <li><a href="http://webmail.uct.cl/" TARGET="_blank">WEBMAIL</a></li>
            <li><a href="http://directorio.uctemuco.cl/" TARGET="_blank">DIRECTORIO</a></li>
            <li><a href="http://intranet.uctemuco.cl/" TARGET="_blank">INTRANET</a></li>
            <li><a href="http://www.uct.cl/contacto/" TARGET="_blank">CONTACTO</a></li>
            <li><a href="http://admision.uct.cl/" TARGET="_blank">ADMISION</a></li>
            <li><a href="http://acreditacion.uct.cl/" TARGET="_blank">ACREDITACION</a></li>
        </ul>
    </nav>

    <?php if (!isset($_SESSION['profesor_logged_in']) || $_SESSION['profesor_logged_in'] !== true): ?>
        <!-- ==================== ESTADO: NO LOGUEADO (LOGIN PROFESOR) ==================== -->
        <div id="wrapper" class="clearfix">
            <div id="header" class="header3">
                <div class="container clearfix">
                    <div id="logo"></div>
                </div>
                <div id="primary-menu">
                    <div class="container clearfix">
                        <ul id="main-menu">
                            <li class="current">
                                <a href="index.php"><div>INICIO</div></a>
                            </li>
                            <li>
                                <a href="http://www.uctemuco.cl/calendario-academico/" TARGET="_blank"><div>CALENDARIO</div></a>
                            </li>
                            <li>
                                <a href="http://educa.uct.cl/" TARGET="_blank"><div>EDUCA</div></a>
                            </li>
                            <li>
                                <a href="http://dge.uct.cl/" TARGET="_blank"><div>DGE</div></a>
                            </li>
                            <li>
                                <a href="https://daas.uct.cl" TARGET="_blank"><div>ACOMPAÑAMIENTO DAAS</div> </a>
                            </li>
                            <li>
                                <a href="https://dara.uct.cl/" TARGET="_blank"><div>DARA</div></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <br style="clear:both;">
            </div>

            <div id="content">
                <div class="container clearfix">
                    <div id="fondo">
                        <div id="derecha">
                            <!-- carrusel banners -->
                            <div id='cargaBanner'>
                                <div class="wmuSlider example1">
                                    <div class="wmuSliderWrapper">
                                        <article><a href="https://pagosweb.uct.cl" target="_blank"><img src="images/slider/BANNER_PAGOS_WEB.jpg" alt="" /></a></article>
                                        <article><a href="https://escuchaactiva.uct.cl/" target="_blank"><img src="images/slider/slider-escuchaactiva.jpg" alt="" /></a></article>
                                        <article><img src="images/slider/slider-gabriela.jpg" alt="" /></article>
                                    </div>
                                </div>
                                <script src="js/jquery.wmuSlider.js"></script>
                                <script type="text/javascript" src="js/modernizr.custom.min.js"></script>
                                <script>
                                    try {
                                        $('.example1').wmuSlider();
                                    } catch(e) {}
                                </script>
                                <ul id="flechas">
                                    <li id="izq"></li>
                                    <li id="der"></li>
                                </ul>
                            </div>
                        </div>

                        <div id="izquierda">
                            <div id='validar_correo' style="line-height: 6px;letter-spacing: 0.027em;font-size: 12px;">
                                <section id="containers">
                                    <h2 style="color:white">Acceso Docentes</h2>
                                    <form name="profe_form" id="hongkiat-form" method="post" action="profesor.php">
                                        <input type="hidden" name="profesor_login" value="1">
                                        <div id="wrapping" class="clearfix">
                                            <section id="aligned">
                                                <input type="text" onblur="asignar()" name="correo" id="correo" placeholder="correo@uct.cl" autocomplete="off" tabindex="1" class="txtinput" required>
                                                <input type="password" name="pass" id="pass" placeholder="Contraseña" autocomplete="off" tabindex="2" class="txtinput" required>
                                            </section>
                                        </div>
                                        <br style="clear:both;">
                                        <br style="clear:both;">
                                        <section id="buttons">
                                            <center>
                                                <input type="submit" name="submit" id="submitbtn" class="submitbtn" tabindex="7" value="Entrar">
                                            </center>
                                            <br style="clear:both;">
                                            <br style="clear:both;">
                                            <center>
                                                <a href="index.php" style="display: inline-block; font-size:14px; color:white; font-weight: bold; text-decoration: underline;">Volver a Portal Estudiante</a>
                                                <br style="clear:both;">
                                            </center>
                                        </section>
                                    </form>
                                </section>
                            </div>
                        </div>
                        <br>
                        <?php if (!empty($login_error)): ?>
                            <p style="color: red; font-family: 'Open Sans', serif; font-size:17px; text-shadow: -1px -1px 1px #000, 1px 1px 1px #000, -1px 1px 1px #000, 1px -1px 1px #000; text-align: center; font-weight: bold; margin-top: 15px;">
                                <?php echo htmlspecialchars($login_error); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- ==================== ESTADO: LOGUEADO (DASHBOARD PROFESOR) ==================== -->
        <div id="wrapper" class="clearfix">
            <div id="header" class="header3">
                <div class="container clearfix">
                    <div id="logo"></div>
                </div>
                <div id="primary-menu">
                    <div class="container clearfix">
                        <ul id="main-menu">
                            <li class="current">
                                <a href="#"><div>INICIO</div></a>
                            </li>
                            <li>
                                <a href="http://www.uctemuco.cl/calendario-academico/" TARGET="_blank"><div>CALENDARIO</div></a>
                            </li>
                            <li>
                                <a href="http://educa.uct.cl/" TARGET="_blank"><div>EDUCA</div></a>
                            </li>
                            <li>
                                <a href="http://dge.uct.cl/" TARGET="_blank"><div>DGE</div></a>
                            </li>
                            <li>
                                <a href="https://daas.uct.cl" TARGET="_blank"><div>ACOMPAÑAMIENTO DAAS</div> </a>
                            </li>
                            <li>
                                <a href="https://dara.uct.cl/" TARGET="_blank"><div>DARA</div></a>
                            </li>
                            <p id="identificacion">BUEN DIA: <?php echo $_SESSION['profesor_name']; ?> &nbsp;&nbsp;|&nbsp;&nbsp; ROL: DOCENTE</p>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Grilla Principal -->
            <div class="container" style="padding: 0;">
                <div class="row-fluid">
                    <!-- Menú Lateral PC -->
                    <div class="span3 hidden-phone">
                        <div class="content">
                            <ul class="ca-menu">
                                <li>
                                    <a href="#" onclick="window.location.reload(); return false;">
                                        <span class="ca-icon"><img src="./images/icons/observacion-ficha.png"></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Mis Asignaturas</h2>
                                            <h3 class="ca-sub">Programar evaluaciones</h3>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php">
                                        <span class="ca-icon"><img src="./images/icons/datos-personales.png"></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Portal Alumnos</h2>
                                            <h3 class="ca-sub">Ir a la vista principal</h3>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="profesor.php?action=logout">
                                        <span class="ca-icon"><img src="./images/icons/cerrar-sesion.png" style="margin-right:8px;"></span>
                                        <div class="ca-content">
                                            <h2 class="ca-main">Cerrar sesión</h2>
                                            <h3 class="ca-sub" style="width:180px; line-height: 1.3em; margin-top:-3px;">Cerrar sesión docente</h3>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Panel de Contenido Derecho -->
                    <div class="span9">
                        <div id="panelDer">
                            <center>
                                <table width='100%'>
                                    <tr>
                                        <td align='left'>
                                            <font size='5' color='#2e6492'><strong>PROGRAMACIÓN DE EVALUACIONES RECUPERATIVAS</strong></font>
                                        </td>
                                    </tr>
                                </table>
                            </center>
                            <br>

                            <!-- Selector de Asignatura -->
                            <table width='100%' border='0' cellspacing='1' cellpadding='10' style='font-family: Arial, sans-serif; font-size: 13px; border: 1px solid #ccc; background-color: #f9f9f9; margin-bottom: 15px;'>
                                <tr>
                                    <td>
                                        <b>Seleccione Asignatura a Dictar:</b> 
                                        <select id="select_curso" style="width: 100%; max-width: 400px; padding: 6px; font-size: 13px; margin-top: 5px; height: auto;" onchange="changeCurso(this.value)">
                                            <option value="">-- Seleccionar asignatura --</option>
                                            <?php foreach ($cursos_disponibles as $c): ?>
                                                <option value="<?php echo htmlspecialchars($c); ?>" <?php if ($c === $curso_seleccionado) echo 'selected'; ?>>
                                                    <?php echo htmlspecialchars($c); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>

                            <?php if (empty($curso_seleccionado)): ?>
                                <div style="text-align: center; padding: 40px; border: 1px dashed #ccc; border-radius: 4px; font-family: Arial; color: #666; font-style: italic;">
                                    Por favor seleccione una asignatura en el menú superior para ver los alumnos justificados.
                                </div>
                            <?php else: ?>
                                <!-- Tabla de Alumnos Justificados en la asignatura -->
                                <div style="width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                                    <table width='100%' border='0' cellspacing='1' cellpadding='6' id="alumnos_table" style='font-family: Arial, sans-serif; font-size: 13px; border: 1px solid #ccc; min-width: 600px;'>
                                        <thead>
                                            <tr bgcolor='#2e6492' style='color: white; font-weight: bold; text-align: center;'>
                                                <td>Trámite</td>
                                                <td>Estudiante</td>
                                                <td>Fecha Inasistencia</td>
                                                <td>Documento</td>
                                                <td>Estado Recuperativa</td>
                                                <td>Acción</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($inasistencias)): ?>
                                                <tr bgcolor='#ffffff'>
                                                    <td colspan='6' align='center' style="padding:20px; font-style:italic;">No se registran alumnos justificados para esta asignatura.</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php 
                                                $i = 0;
                                                foreach ($inasistencias as $in): 
                                                    $bg = ($i % 2 === 0) ? '#f5f5f5' : '#ffffff';
                                                    
                                                    // Badge de programación del docente
                                                    $badge_class = 'badge-pendiente';
                                                    $estado_txt = 'Pendiente';
                                                    if ($in['estado_docente'] === 'Reprogramado') {
                                                        $badge_class = 'badge-reprogramado';
                                                        $estado_txt = 'Reprogramado (' . date('d/m/Y', strtotime($in['nueva_fecha_evaluacion'])) . ')';
                                                    }
                                                    
                                                    $i++;
                                                ?>
                                                    <tr bgcolor='<?php echo $bg; ?>'>
                                                        <td align='center'><b><?php echo htmlspecialchars($in['codigo_tramite']); ?></b></td>
                                                        <td>
                                                            <b><?php echo htmlspecialchars($in['est_nombre']); ?></b><br>
                                                            <small style="color: #666;"><?php echo htmlspecialchars($in['est_rut']); ?></small>
                                                        </td>
                                                        <td align='center'><?php echo date('d/m/Y', strtotime($in['fecha_inasistencia'])); ?></td>
                                                        <td align='center'>
                                                            <?php if (!empty($in['documento'])): ?>
                                                                <a href="uploads/<?php echo htmlspecialchars($in['documento']); ?>" target="_blank">
                                                                    <img src="./images/icons/documentos3.png" width="12" style="vertical-align: middle;"> Ver Respaldo
                                                                </a>
                                                            <?php else: ?>
                                                                <span style="color:#888;">Sin archivo</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td align='center'>
                                                            <span class="badge <?php echo $badge_class; ?>"><?php echo $estado_txt; ?></span>
                                                        </td>
                                                        <td align='center'>
                                                            <button onclick="openProgramModal(<?php echo htmlspecialchars(json_encode($in)); ?>)" style="background-color: #2e6492; color: white; border: none; padding: 4px 10px; font-weight: bold; cursor: pointer; border-radius: 3px; font-size: 11px;">
                                                                <?php echo ($in['estado_docente'] === 'Reprogramado') ? 'Reagendar' : 'Programar'; ?>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== MODAL DE PROGRAMACIÓN DOCENTE ==================== -->
        <div id="profe_modal_program" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
            <div style="background: white; border: 3px solid #2e6492; border-radius: 4px; width: 95%; max-width: 500px; box-sizing: border-box; padding: 20px; font-family: Arial, sans-serif; box-shadow: 0px 4px 15px rgba(0,0,0,0.3); text-align: left;">
                <h3 style="margin-top: 0; color: #2e6492; border-bottom: 2px solid #2e6492; padding-bottom: 5px; font-size: 16px;">
                    Programar Evaluación Recuperativa: <span id="modal_tramite_id" style="font-weight: bold;">TR-0000</span>
                </h3>
                
                <div style="margin-top: 15px;">
                    <!-- Info Alumno -->
                    <table width="100%" border="0" cellspacing="1" cellpadding="4" style="font-size: 12px; border: 1px solid #ccc; background-color: #fafafa; margin-bottom: 15px;">
                        <tr>
                            <td width="35%"><b>Alumno:</b></td>
                            <td id="modal_al_nombre">-</td>
                        </tr>
                        <tr>
                            <td><b>RUT:</b></td>
                            <td id="modal_al_rut">-</td>
                        </tr>
                        <tr>
                            <td><b>Inasistencia:</b></td>
                            <td id="modal_al_fecha_inasistencia">-</td>
                        </tr>
                        <tr>
                            <td><b>Asignatura:</b></td>
                            <td><b><?php echo htmlspecialchars($curso_seleccionado); ?></b></td>
                        </tr>
                    </table>

                    <!-- Formulario -->
                    <form id="program_form" onsubmit="submitProgram(event)">
                        <input type="hidden" id="modal_detalle_id">
                        
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; font-weight: bold; font-size: 12px; color: #2e6492; margin-bottom: 4px;">Nueva Fecha de Evaluación:</label>
                            <input type="date" id="modal_nueva_fecha" required style="padding: 6px; font-size: 13px; width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 3px; height: auto;">
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; font-weight: bold; font-size: 12px; color: #2e6492; margin-bottom: 4px;">Instrucciones / Comentarios:</label>
                            <textarea id="modal_comentario_docente" style="width: 100%; height: 70px; font-family: Arial, sans-serif; padding: 4px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 3px;" placeholder="Ej: La prueba recuperativa se rendirá en sala 201 en horario de cátedra. Abarca unidades 1 y 2."></textarea>
                        </div>
                        
                        <div style="text-align: right; border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px;">
                            <button type="button" onclick="closeProgramModal()" style="background: #e0e0e0; border: 1px solid #ccc; padding: 5px 12px; cursor: pointer; font-weight: bold; font-size: 12px; border-radius: 2px;">Cancelar</button>
                            <button type="submit" style="background: #2e6492; color: white; border: 1px solid #2e6492; padding: 5px 15px; cursor: pointer; font-weight: bold; font-size: 12px; margin-left: 8px; border-radius: 2px;">Guardar Programación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function changeCurso(curso) {
                if (curso) {
                    window.location.href = 'profesor.php?curso=' + encodeURIComponent(curso);
                } else {
                    window.location.href = 'profesor.php';
                }
            }

            function openProgramModal(inObj) {
                $('#modal_detalle_id').val(inObj.detalle_id);
                $('#modal_tramite_id').text(inObj.codigo_tramite);
                $('#modal_al_nombre').text(inObj.est_nombre);
                $('#modal_al_rut').text(inObj.est_rut);
                
                // Formato fecha inasistencia
                var rawDate = inObj.fecha_inasistencia;
                var parts = rawDate.split('-');
                var formattedDate = rawDate;
                if (parts.length === 3) {
                    formattedDate = parts[2] + '/' + parts[1] + '/' + parts[0];
                }
                $('#modal_al_fecha_inasistencia').text(formattedDate);
                
                // Cargar datos preexistentes si ya está reprogramado
                if (inObj.nueva_fecha_evaluacion) {
                    $('#modal_nueva_fecha').val(inObj.nueva_fecha_evaluacion);
                } else {
                    $('#modal_nueva_fecha').val('');
                }
                $('#modal_comentario_docente').val(inObj.comentario_docente || '');

                $('#profe_modal_program').css('display', 'flex');
            }

            function closeProgramModal() {
                $('#profe_modal_program').css('display', 'none');
            }

            function submitProgram(event) {
                event.preventDefault();
                
                var detId = $('#modal_detalle_id').val();
                var nuevaFecha = $('#modal_nueva_fecha').val();
                var comentario = $('#modal_comentario_docente').val();

                $.ajax({
                    url: 'update_fecha_evaluacion.php',
                    type: 'POST',
                    data: {
                        detalle_id: detId,
                        nueva_fecha: nuevaFecha,
                        comentario: comentario
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            closeProgramModal();
                            window.location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Error al comunicarse con el servidor.');
                    }
                });
            }
        </script>
    <?php endif; ?>

    <!-- PIE DE PAGINA IDENTICO A UCT -->
    <div id="footer" class="footer-dark">
        <div class="container clearfix">
            <div class="footer-widgets-wrap clearfix">
                <div class="col_one_fourth">
                    <div class="widget clearfix">
                        <h4>DIRECCIONES<span> CAMPUS</span></h4>
                        <ul style="font-size: 12px;">
                            <li>CAMPUS SAN FRANCISCO</li>
                            <li class="icon-map-marker">Manuel Montt 56</li>
                            <li class="icon-phone">Fono: +56 45 2 205 470</li>
                        </ul>
                        <ul style="font-size: 12px;">
                            <li>CAMPUS SAN JUAN PABLO II</li>
                            <li class="icon-map-marker">Rudecindo Ortega 02950</li>
                            <li class="icon-phone">Fono: +56 45 2 553 978</li>
                        </ul>
                    </div>
                </div>
                <div class="col_one_fourth">
                    <div class="widget clearfix">
                        <h4>&nbsp;</h4>
                        <ul style="font-size: 12px;">
                            <li>CAMPUS MENCHACA LIRA</li>
                            <li class="icon-map-marker">Avenida Alemania 0422</li>
                            <li class="icon-phone">Fono: +56 45 2 203 822</li>
                        </ul>
                        <ul style="font-size: 12px;">
                            <li>CAMPUS LUIS RIVAS DEL CANTO</li>
                            <li class="icon-map-marker">Callejón Las Mariposas s/n</li>
                            <li class="icon-phone">Fono: +56 45 2 205 596</li>
                        </ul>
                    </div>
                </div>
                <div class="col_one_fourth">
                    <div class="widget clearfix">
                        <h4>TELÉFONOS DE <span>UTILIDAD</span></h4>
                        <ul style="font-size: 12px;">
                            <li>PRENSA INSTITUCIONAL </li>
                            <li class="icon-map-marker">Avenida Alemania 0211</li>
                            <li class="icon-phone">Fono: +56 45 2 205 428</li>
                        </ul>
                        <ul style="font-size: 12px;">
                            <li>BIENESTAR ESTUDIANTIL </li>
                            <li class="icon-map-marker">Manuel Montt 56</li>
                            <li class="icon-phone">Fono: +56 45 2 205 424</li>
                        </ul>
                    </div>
                </div>
                <div class="col_one_fourth">
                    <div class="widget clearfix">
                        <h4>&nbsp;</h4>
                        <ul style="font-size: 12px;">
                            <li>AULA MAGNA </li>
                            <li class="icon-map-marker">Manuel Montt 56</li>
                            <li class="icon-phone">Fono: +56 45 2 205 471</li>
                        </ul>
                        <ul style="font-size: 12px;">
                            <li>MESA CENTRAL </li>
                            <li class="icon-map-marker">Prieto Norte 371</li>
                            <li class="icon-phone">Fono: +56 45 2 205 205</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
    <div id="gotoTop" class="icon-angle-up"></div>
    <script type="text/javascript" src="js/custom.js"></script>
</body>
</html>
